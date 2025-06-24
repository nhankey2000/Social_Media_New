<?php

namespace App\Services;

use App\Models\PlatformAccount;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Exception\ConnectException;

class InstagramService
{
    protected $client;

    public function __construct()
    {
        $handlerStack = HandlerStack::create();

        $handlerStack->push(Middleware::retry(
            function ($retries, $request, $response, $exception) {
                if ($retries >= 3) {
                    return false;
                }

                if ($exception instanceof ConnectException) {
                    return true;
                }

                if ($response && in_array($response->getStatusCode(), [503, 429])) {
                    return true;
                }

                if ($response && $response->getStatusCode() === 400) {
                    $body = json_decode($response->getBody()->getContents(), true);
                    if (isset($body['error']['code']) && $body['error']['code'] === 4) {
                        $response->getBody()->rewind();
                        return true;
                    }
                }

                return false;
            },
            function ($retries) {
                return (int) pow(2, $retries) * 1000;
            }
        ));

        $this->client = new Client([
            'base_uri' => 'https://graph.facebook.com/v20.0/',
            'timeout' => 60.0,
            'handler' => $handlerStack,
        ]);
    }

    /**
     * Post an image or video to Instagram
     *
     * @param PlatformAccount $platformAccount
     * @param string $message Caption for the post
     * @param array|null $media Array of media URLs (not file paths)
     * @param string $mediaType Type of media ('image' or 'video')
     * @return array Response with post ID or error message
     * @throws \Exception
     */
    public function postInstagram(PlatformAccount $platformAccount, string $message, ?array $media = null, string $mediaType = 'image'): array
    {
        try {
            if (empty($platformAccount->access_token) || empty($platformAccount->page_id)) {
                throw new \Exception('Access token or Instagram Business Account ID is required.');
            }

            if (!$platformAccount->is_active) {
                throw new \Exception('Instagram account is inactive.');
            }

            $message = $this->normalizeMessage($message);

            // Log the request details
            Log::info('Instagram post request', [
                'account_id' => $platformAccount->id,
                'page_id' => $platformAccount->page_id,
                'media_type' => $mediaType,
                'media_urls' => $media,
                'message_length' => strlen($message),
            ]);

            // Step 1: Create media container
            $params = [
                'caption' => $message,
                'access_token' => $platformAccount->access_token,
            ];

            if ($media && count($media) > 0) {
                $mediaUrl = $media[0]; // Expect URL, not file path

                // FIXED: Validate URL format
                if (!filter_var($mediaUrl, FILTER_VALIDATE_URL)) {
                    throw new \Exception('Invalid media URL format: ' . $mediaUrl);
                }

                // FIXED: Log the media URL being used
                Log::info('Using media URL for Instagram', [
                    'media_url' => $mediaUrl,
                    'media_type' => $mediaType
                ]);

                if ($mediaType === 'image') {
                    $params['image_url'] = $mediaUrl;
                } elseif ($mediaType === 'video') {
                    $params['media_type'] = 'VIDEO';
                    $params['video_url'] = $mediaUrl;
                } else {
                    throw new \Exception('Unsupported media type: ' . $mediaType);
                }
            } else {
                throw new \Exception('Media URL is required for Instagram post.');
            }

            // Log the API request (hide access token)
            Log::info('Instagram API request params', [
                'params' => array_merge($params, ['access_token' => '[HIDDEN]'])
            ]);

            $response = $this->client->post("{$platformAccount->page_id}/media", [
                'form_params' => $params,
            ]);

            $containerData = json_decode($response->getBody()->getContents(), true);

            Log::info('Instagram container creation response', [
                'response' => $containerData
            ]);

            if (isset($containerData['error'])) {
                throw new \Exception('Failed to create media container: ' . json_encode($containerData['error']));
            }

            if (!isset($containerData['id'])) {
                throw new \Exception('No container ID returned from Instagram API.');
            }

            $containerId = $containerData['id'];

            // Step 2: Publish the media container
            $publishParams = [
                'creation_id' => $containerId,
                'access_token' => $platformAccount->access_token,
            ];

            Log::info('Instagram publish request', [
                'creation_id' => $containerId,
                'page_id' => $platformAccount->page_id
            ]);

            $publishResponse = $this->client->post("{$platformAccount->page_id}/media_publish", [
                'form_params' => $publishParams,
            ]);

            $publishData = json_decode($publishResponse->getBody()->getContents(), true);

            Log::info('Instagram publish response', [
                'response' => $publishData
            ]);

            if (isset($publishData['error'])) {
                throw new \Exception('Failed to publish media: ' . json_encode($publishData['error']));
            }

            return [
                'success' => true,
                'post_id' => $publishData['id'] ?? null,
            ];

        } catch (RequestException $e) {
            $errorMessage = $e->hasResponse() ? $e->getResponse()->getBody()->getContents() : $e->getMessage();
            Log::error('Instagram post failed (RequestException)', [
                'error' => $errorMessage,
                'account_id' => $platformAccount->id ?? null,
                'media_type' => $mediaType ?? null,
                'media_urls' => $media ?? null,
            ]);
            return [
                'success' => false,
                'error' => 'Failed to post to Instagram: ' . $errorMessage,
            ];
        } catch (\Exception $e) {
            Log::error('Instagram post failed (Exception)', [
                'error' => $e->getMessage(),
                'account_id' => $platformAccount->id ?? null,
                'media_type' => $mediaType ?? null,
                'media_urls' => $media ?? null,
            ]);
            return [
                'success' => false,
                'error' => 'Failed to post to Instagram: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Edit an Instagram post
     * Logic: If media changes -> delete old post and create new one
     *        If only caption changes -> update caption directly
     *
     * @param PlatformAccount $platformAccount
     * @param string $instagramPostId Current Instagram post ID
     * @param string $newMessage New caption for the post
     * @param array|null $newMedia New media URLs (if changing media)
     * @param string $mediaType Type of media ('image' or 'video')
     * @param array|null $oldMedia Old media URLs for comparison
     * @return array Response with success status or error message
     */
    public function editInstagramPost(PlatformAccount $platformAccount, string $instagramPostId, string $newMessage, ?array $newMedia = null, string $mediaType = 'image', ?array $oldMedia = null): array
    {
        try {
            if (empty($platformAccount->access_token)) {
                throw new \Exception('Access token is required.');
            }

            if (!$platformAccount->is_active) {
                throw new \Exception('Instagram account is inactive.');
            }

            if (empty($instagramPostId)) {
                throw new \Exception('Instagram post ID is required.');
            }

            $newMessage = $this->normalizeMessage($newMessage);

            // Log the edit request details
            Log::info('Instagram edit post request', [
                'account_id' => $platformAccount->id,
                'page_id' => $platformAccount->page_id,
                'instagram_post_id' => $instagramPostId,
                'new_media' => $newMedia,
                'old_media' => $oldMedia,
                'media_type' => $mediaType,
                'message_length' => strlen($newMessage),
            ]);

            // Check if media has changed
            $mediaChanged = $this->hasMediaChanged($newMedia, $oldMedia);

            if ($mediaChanged) {
                Log::info('Media changed - will delete old post and create new one', [
                    'instagram_post_id' => $instagramPostId
                ]);

                // Step 1: Delete the old post
                $deleteResult = $this->deleteInstagramPost($platformAccount, $instagramPostId);

                if (!$deleteResult['success']) {
                    Log::warning('Failed to delete old post during edit', [
                        'delete_error' => $deleteResult['error'],
                        'instagram_post_id' => $instagramPostId
                    ]);
                    // Continue with creating new post even if delete failed
                }

                // Step 2: Create new post with new media and caption
                $postResult = $this->postInstagram($platformAccount, $newMessage, $newMedia, $mediaType);

                if ($postResult['success']) {
                    return [
                        'success' => true,
                        'action' => 'recreated',
                        'old_post_id' => $instagramPostId,
                        'new_post_id' => $postResult['post_id'],
                        'message' => 'Post recreated successfully with new media.',
                    ];
                } else {
                    return [
                        'success' => false,
                        'error' => 'Failed to create new post after deleting old one: ' . $postResult['error'],
                    ];
                }
            } else {
                Log::info('Only caption changed - will update existing post', [
                    'instagram_post_id' => $instagramPostId
                ]);

                // Only caption changed - update the existing post
                $updateResult = $this->updateInstagramCaption($platformAccount, $instagramPostId, $newMessage);

                if ($updateResult['success']) {
                    return [
                        'success' => true,
                        'action' => 'updated',
                        'post_id' => $instagramPostId,
                        'message' => 'Post caption updated successfully.',
                    ];
                } else {
                    return $updateResult;
                }
            }

        } catch (\Exception $e) {
            Log::error('Instagram edit post failed (Exception)', [
                'error' => $e->getMessage(),
                'account_id' => $platformAccount->id ?? null,
                'instagram_post_id' => $instagramPostId ?? null,
            ]);

            return [
                'success' => false,
                'error' => 'Failed to edit Instagram post: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Update only the caption of an existing Instagram post
     *
     * @param PlatformAccount $platformAccount
     * @param string $instagramPostId Instagram post ID
     * @param string $newCaption New caption text
     * @return array Response with success status or error message
     */
    private function updateInstagramCaption(PlatformAccount $platformAccount, string $instagramPostId, string $newCaption): array
    {
        try {
            // Note: Instagram API doesn't support direct caption editing for published posts
            // This is a limitation of the Instagram Graph API
            // We need to inform the user about this limitation

            Log::warning('Instagram API limitation: Cannot update caption of published posts', [
                'instagram_post_id' => $instagramPostId,
                'attempted_caption' => $newCaption
            ]);

            return [
                'success' => false,
                'error' => 'Instagram API does not support editing captions of published posts. The post must be recreated.',
                'suggestion' => 'Please update the media as well to recreate the post, or delete and repost manually.',
            ];

        } catch (\Exception $e) {
            Log::error('Instagram update caption failed', [
                'error' => $e->getMessage(),
                'instagram_post_id' => $instagramPostId,
            ]);

            return [
                'success' => false,
                'error' => 'Failed to update Instagram caption: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Check if media has changed between old and new media arrays
     *
     * @param array|null $newMedia
     * @param array|null $oldMedia
     * @return bool
     */
    private function hasMediaChanged(?array $newMedia, ?array $oldMedia): bool
    {
        // If both are null, no change
        if ($newMedia === null && $oldMedia === null) {
            return false;
        }

        // If one is null and other is not, there's a change
        if ($newMedia === null || $oldMedia === null) {
            return true;
        }

        // Compare arrays
        if (count($newMedia) !== count($oldMedia)) {
            return true;
        }

        // Compare each URL
        for ($i = 0; $i < count($newMedia); $i++) {
            if (!isset($oldMedia[$i]) || $newMedia[$i] !== $oldMedia[$i]) {
                return true;
            }
        }

        return false;
    }

    /**
     * Delete an Instagram post
     *
     * @param PlatformAccount $platformAccount
     * @param string $instagramPostId Instagram post ID to delete
     * @return array Response with success status or error message
     */
    public function deleteInstagramPost(PlatformAccount $platformAccount, string $instagramPostId): array
    {
        try {
            if (empty($platformAccount->access_token)) {
                throw new \Exception('Access token is required.');
            }

            if (!$platformAccount->is_active) {
                throw new \Exception('Instagram account is inactive.');
            }

            if (empty($instagramPostId)) {
                throw new \Exception('Instagram post ID is required.');
            }

            // Log the delete request details
            Log::info('Instagram delete post request', [
                'account_id' => $platformAccount->id,
                'page_id' => $platformAccount->page_id,
                'instagram_post_id' => $instagramPostId,
            ]);

            // Send DELETE request to Instagram API
            $response = $this->client->delete($instagramPostId, [
                'query' => [
                    'access_token' => $platformAccount->access_token,
                ]
            ]);

            $responseData = json_decode($response->getBody()->getContents(), true);

            Log::info('Instagram delete response', [
                'response' => $responseData,
                'instagram_post_id' => $instagramPostId
            ]);

            if (isset($responseData['error'])) {
                throw new \Exception('Failed to delete Instagram post: ' . json_encode($responseData['error']));
            }

            // Check if deletion was successful
            if (isset($responseData['success']) && $responseData['success'] === true) {
                return [
                    'success' => true,
                    'message' => 'Instagram post deleted successfully.',
                ];
            }

            // If no explicit success flag, assume success if no error
            return [
                'success' => true,
                'message' => 'Instagram post deleted successfully.',
            ];

        } catch (RequestException $e) {
            $errorMessage = $e->hasResponse() ? $e->getResponse()->getBody()->getContents() : $e->getMessage();

            // Parse error response if possible
            if ($e->hasResponse()) {
                $errorData = json_decode($errorMessage, true);
                if (isset($errorData['error']['message'])) {
                    $errorMessage = $errorData['error']['message'];
                }
            }

            Log::error('Instagram delete post failed (RequestException)', [
                'error' => $errorMessage,
                'account_id' => $platformAccount->id ?? null,
                'instagram_post_id' => $instagramPostId ?? null,
                'status_code' => $e->hasResponse() ? $e->getResponse()->getStatusCode() : null,
            ]);

            return [
                'success' => false,
                'error' => 'Failed to delete Instagram post: ' . $errorMessage,
            ];
        } catch (\Exception $e) {
            Log::error('Instagram delete post failed (Exception)', [
                'error' => $e->getMessage(),
                'account_id' => $platformAccount->id ?? null,
                'instagram_post_id' => $instagramPostId ?? null,
            ]);

            return [
                'success' => false,
                'error' => 'Failed to delete Instagram post: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Normalize message to ensure compatibility with Instagram API
     *
     * @param string $message
     * @return string
     */
    private function normalizeMessage(string $message): string
    {
        $message = str_replace(["\r\n", "\r"], "\n", $message);
        $message = str_replace("\u000A", "\n", $message);
        return trim($message);
    }
}
