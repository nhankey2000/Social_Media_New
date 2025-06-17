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
     * @param array|null $media Array of media file paths (image or video)
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

            // Step 1: Create media container
            $params = [
                'caption' => $message,
                'access_token' => $platformAccount->access_token,
            ];

            if ($media && count($media) > 0) {
                $mediaPath = $media[0];

                if (!file_exists($mediaPath)) {
                    throw new \Exception('Media file does not exist: ' . $mediaPath);
                }

                if ($mediaType === 'image') {
                    $params['image_url'] = asset($mediaPath); // Assumes media is publicly accessible
                } elseif ($mediaType === 'video') {
                    $params['media_type'] = 'VIDEO';
                    $params['video_url'] = asset($mediaPath); // Assumes video is publicly accessible
                } else {
                    throw new \Exception('Unsupported media type: ' . $mediaType);
                }
            } else {
                throw new \Exception('Media file is required for Instagram post.');
            }

            $response = $this->client->post("{$platformAccount->page_id}/media", [
                'form_params' => $params,
            ]);

            $containerData = json_decode($response->getBody()->getContents(), true);

            if (isset($containerData['error'])) {
                throw new \Exception('Failed to create media container: ' . $containerData['error']['message']);
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

            $publishResponse = $this->client->post("{$platformAccount->page_id}/media_publish", [
                'form_params' => $publishParams,
            ]);

            $publishData = json_decode($publishResponse->getBody()->getContents(), true);

            if (isset($publishData['error'])) {
                throw new \Exception('Failed to publish media: ' . $publishData['error']['message']);
            }

            return [
                'success' => true,
                'post_id' => $publishData['id'] ?? null,
            ];

        } catch (RequestException $e) {
            $errorMessage = $e->hasResponse() ? $e->getResponse()->getBody()->getContents() : $e->getMessage();
            Log::error('Instagram post failed: ' . $errorMessage);
            return [
                'success' => false,
                'error' => 'Failed to post to Instagram: ' . $errorMessage,
            ];
        } catch (\Exception $e) {
            Log::error('Instagram post failed: ' . $e->getMessage());
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
}

