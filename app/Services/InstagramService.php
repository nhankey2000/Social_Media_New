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

    /**
     * Update Instagram post content (Note: Instagram doesn't support editing posts)
     * This method will delete the old post and create a new one
     *
     * @param string $postId
     * @param string $accessToken
     * @param string $newMessage
     * @param array|null $newMedia
     * @param string $mediaType
     * @return string|null New post ID if successful
     * @throws \Exception
     */
    public function updatePost(string $postId, string $accessToken, string $newMessage, ?array $newMedia = null, string $mediaType = 'image'): ?string
    {
        Log::info('Instagram update post attempt', [
            'post_id' => $postId,
            'media_type' => $mediaType,
            'has_media' => !empty($newMedia)
        ]);

        // Instagram doesn't support editing posts, so we need to delete and recreate
        // Note: This is a limitation of Instagram API
        throw new \Exception('Instagram API does not support editing posts. You need to delete the old post and create a new one.');
    }

    /**
     * Delete Instagram post
     *
     * @param string $postId
     * @param string $accessToken
     * @return bool
     * @throws \Exception
     */
    public function deletePost(string $postId, string $accessToken): bool
    {
        try {
            Log::info('Instagram delete post request', [
                'post_id' => $postId
            ]);

            $response = $this->client->delete($postId, [
                'query' => [
                    'access_token' => $accessToken,
                ],
            ]);

            $result = json_decode($response->getBody()->getContents(), true);

            Log::info('Instagram delete response', [
                'post_id' => $postId,
                'response' => $result
            ]);

            if (isset($result['error'])) {
                throw new \Exception('Failed to delete Instagram post: ' . json_encode($result['error']));
            }

            return $result['success'] ?? true;

        } catch (RequestException $e) {
            $errorMessage = $e->hasResponse() ? $e->getResponse()->getBody()->getContents() : $e->getMessage();
            Log::error('Instagram delete failed (RequestException)', [
                'post_id' => $postId,
                'error' => $errorMessage
            ]);
            throw new \Exception('Failed to delete Instagram post: ' . $errorMessage);
        } catch (\Exception $e) {
            Log::error('Instagram delete failed (Exception)', [
                'post_id' => $postId,
                'error' => $e->getMessage()
            ]);
            throw new \Exception('Failed to delete Instagram post: ' . $e->getMessage());
        }
    }

    /**
     * Get Instagram post details
     *
     * @param string $postId
     * @param string $accessToken
     * @return array|null
     */
    public function getPostDetails(string $postId, string $accessToken): ?array
    {
        try {
            Log::info('Getting Instagram post details', [
                'post_id' => $postId
            ]);

            $response = $this->client->get($postId, [
                'query' => [
                    'fields' => 'id,media_type,media_url,thumbnail_url,permalink,caption,timestamp,like_count,comments_count',
                    'access_token' => $accessToken,
                ],
            ]);

            $result = json_decode($response->getBody()->getContents(), true);

            if (isset($result['error'])) {
                Log::error('Failed to get Instagram post details', [
                    'post_id' => $postId,
                    'error' => $result['error']
                ]);
                return null;
            }

            return $result;

        } catch (RequestException $e) {
            $errorMessage = $e->hasResponse() ? $e->getResponse()->getBody()->getContents() : $e->getMessage();
            Log::error('Instagram get post details failed', [
                'post_id' => $postId,
                'error' => $errorMessage
            ]);
            return null;
        }
    }

    /**
     * Create a new Instagram post to replace an updated one
     *
     * @param PlatformAccount $platformAccount
     * @param string $message
     * @param array|null $media
     * @param string $mediaType
     * @return array
     */
    public function createReplacementPost(PlatformAccount $platformAccount, string $message, ?array $media = null, string $mediaType = 'image'): array
    {
        Log::info('Creating replacement Instagram post', [
            'account_id' => $platformAccount->id,
            'media_type' => $mediaType
        ]);

        // Use the same postInstagram method to create a new post
        return $this->postInstagram($platformAccount, $message, $media, $mediaType);
    }
}
