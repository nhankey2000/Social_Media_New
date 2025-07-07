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
     * Đăng một hình ảnh hoặc video lên Instagram
     *
     * @param PlatformAccount $platformAccount
     * @param string $message Chú thích cho bài đăng
     * @param array|null $media Mảng các URL phương tiện (không phải đường dẫn tệp)
     * @param string $mediaType Loại phương tiện ('image' hoặc 'video')
     * @return array Phản hồi với ID bài đăng hoặc thông báo lỗi
     * @throws \Exception
     */
    public function postInstagram(PlatformAccount $platformAccount, string $message, ?array $media = null, string $mediaType = 'image'): array
    {
        try {
            if (empty($platformAccount->access_token) || empty($platformAccount->page_id)) {
                throw new \Exception('Yêu cầu access token hoặc ID tài khoản Instagram Business.');
            }

            if (!$platformAccount->is_active) {
                throw new \Exception('Tài khoản Instagram không hoạt động.');
            }

            $message = $this->normalizeMessage($message);

            // Ghi log chi tiết yêu cầu
            Log::info('Yêu cầu đăng bài Instagram', [
                'account_id' => $platformAccount->id,
                'page_id' => $platformAccount->page_id,
                'media_type' => $mediaType,
                'media_urls' => $media,
                'message_length' => strlen($message),
            ]);

            // Bước 1: Tạo container phương tiện
            $params = [
                'caption' => $message,
                'access_token' => $platformAccount->access_token,
            ];

            if ($media && count($media) > 0) {
                $mediaUrl = $media[0]; // Mong đợi URL, không phải đường dẫn tệp

                // Xác thực định dạng URL
                if (!filter_var($mediaUrl, FILTER_VALIDATE_URL)) {
                    throw new \Exception('Định dạng URL phương tiện không hợp lệ: ' . $mediaUrl);
                }

                // Ghi log URL phương tiện được sử dụng
                Log::info('Sử dụng URL phương tiện cho Instagram', [
                    'media_url' => $mediaUrl,
                    'media_type' => $mediaType
                ]);

                if ($mediaType === 'image') {
                    $params['image_url'] = $mediaUrl;
                } elseif ($mediaType === 'video') {
                    $params['media_type'] = 'VIDEO';
                    $params['video_url'] = $mediaUrl;
                } else {
                    throw new \Exception('Loại phương tiện không được hỗ trợ: ' . $mediaType);
                }
            } else {
                throw new \Exception('Yêu cầu URL phương tiện cho bài đăng Instagram.');
            }

            // Ghi log yêu cầu API (ẩn access token)
            Log::info('Tham số yêu cầu API Instagram', [
                'params' => array_merge($params, ['access_token' => '[ẨN]'])
            ]);

            $response = $this->client->post("{$platformAccount->page_id}/media", [
                'form_params' => $params,
            ]);

            $containerData = json_decode($response->getBody()->getContents(), true);

            Log::info('Phản hồi tạo container Instagram', [
                'response' => $containerData
            ]);

            if (isset($containerData['error'])) {
                throw new \Exception('Không thể tạo container phương tiện: ' . json_encode($containerData['error']));
            }

            if (!isset($containerData['id'])) {
                throw new \Exception('Không có ID container được trả về từ API Instagram.');
            }

            $containerId = $containerData['id'];

            // Bước 2: Xuất bản container phương tiện
            $publishParams = [
                'creation_id' => $containerId,
                'access_token' => $platformAccount->access_token,
            ];

            Log::info('Yêu cầu xuất bản Instagram', [
                'creation_id' => $containerId,
                'page_id' => $platformAccount->page_id
            ]);

            $publishResponse = $this->client->post("{$platformAccount->page_id}/media_publish", [
                'form_params' => $publishParams,
            ]);

            $publishData = json_decode($publishResponse->getBody()->getContents(), true);

            Log::info('Phản hồi xuất bản Instagram', [
                'response' => $publishData
            ]);

            if (isset($publishData['error'])) {
                throw new \Exception('Không thể xuất bản phương tiện: ' . json_encode($publishData['error']));
            }

            return [
                'success' => true,
                'post_id' => $publishData['id'] ?? null,
            ];

        } catch (RequestException $e) {
            $errorMessage = $e->hasResponse() ? $e->getResponse()->getBody()->getContents() : $e->getMessage();
            Log::error('Đăng bài Instagram thất bại (RequestException)', [
                'error' => $errorMessage,
                'account_id' => $platformAccount->id ?? null,
                'media_type' => $mediaType ?? null,
                'media_urls' => $media ?? null,
            ]);
            return [
                'success' => false,
                'error' => 'Không thể đăng bài lên Instagram: ' . $errorMessage,
            ];
        } catch (\Exception $e) {
            Log::error('Đăng bài Instagram thất bại (Exception)', [
                'error' => $e->getMessage(),
                'account_id' => $platformAccount->id ?? null,
                'media_type' => $mediaType ?? null,
                'media_urls' => $media ?? null,
            ]);
            return [
                'success' => false,
                'error' => 'Không thể đăng bài lên Instagram: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Xóa một bài đăng Instagram
     *
     * @param PlatformAccount $platformAccount
     * @param string $instagramPostId ID bài đăng Instagram cần xóa
     * @return array Phản hồi với trạng thái thành công hoặc thông báo lỗi
     */
    public function deleteInstagramPost(PlatformAccount $platformAccount, string $instagramPostId): array
    {
        try {
            if (empty($platformAccount->access_token)) {
                throw new \Exception('Yêu cầu access token.');
            }

            if (!$platformAccount->is_active) {
                throw new \Exception('Tài khoản Instagram không hoạt động.');
            }

            if (empty($instagramPostId)) {
                throw new \Exception('Yêu cầu ID bài đăng Instagram.');
            }

            // Ghi log chi tiết yêu cầu xóa
            Log::info('Yêu cầu xóa bài Instagram', [
                'account_id' => $platformAccount->id,
                'page_id' => $platformAccount->page_id,
                'instagram_post_id' => $instagramPostId,
            ]);

            // Gửi yêu cầu DELETE đến API Instagram
            $response = $this->client->delete($instagramPostId, [
                'query' => [
                    'access_token' => $platformAccount->access_token,
                ]
            ]);

            $responseData = json_decode($response->getBody()->getContents(), true);

            Log::info('Phản hồi xóa Instagram', [
                'response' => $responseData,
                'instagram_post_id' => $instagramPostId
            ]);

            if (isset($responseData['error'])) {
                throw new \Exception('Không thể xóa bài đăng Instagram: ' . json_encode($responseData['error']));
            }

            // Kiểm tra xem xóa có thành công không
            if (isset($responseData['success']) && $responseData['success'] === true) {
                return [
                    'success' => true,
                    'message' => 'Đã xóa bài đăng Instagram thành công.',
                ];
            }

            // Nếu không có cờ thành công rõ ràng, giả định thành công nếu không có lỗi
            return [
                'success' => true,
                'message' => 'Đã xóa bài đăng Instagram thành công.',
            ];

        } catch (RequestException $e) {
            $errorMessage = $e->hasResponse() ? $e->getResponse()->getBody()->getContents() : $e->getMessage();

            // Phân tích phản hồi lỗi nếu có
            if ($e->hasResponse()) {
                $errorData = json_decode($errorMessage, true);
                if (isset($errorData['error']['message'])) {
                    $errorMessage = $errorData['error']['message'];
                }
            }

            Log::error('Xóa bài Instagram thất bại (RequestException)', [
                'error' => $errorMessage,
                'account_id' => $platformAccount->id ?? null,
                'instagram_post_id' => $instagramPostId ?? null,
                'status_code' => $e->hasResponse() ? $e->getResponse()->getStatusCode() : null,
            ]);

            return [
                'success' => false,
                'error' => 'Không thể xóa bài đăng Instagram: ' . $errorMessage,
            ];
        } catch (\Exception $e) {
            Log::error('Xóa bài Instagram thất bại (Exception)', [
                'error' => $e->getMessage(),
                'account_id' => $platformAccount->id ?? null,
                'instagram_post_id' => $instagramPostId ?? null,
            ]);

            return [
                'success' => false,
                'error' => 'Không thể xóa bài đăng Instagram: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Chuẩn hóa thông điệp để đảm bảo tương thích với API Instagram
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
