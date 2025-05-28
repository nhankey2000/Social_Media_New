<?php

namespace App\Services\Connection;

use App\Models\PlatformAccount;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class Connection
{
    public function check(PlatformAccount $account)
    {
        // Kiểm tra các trường bắt buộc
        if (!$account->access_token || !$account->app_id || !$account->app_secret) {
            return false;
        }

        $platformName = strtolower($account->platform->name);
        $client = new Client([
            'base_uri' => 'https://graph.facebook.com/v20.0/',
            'timeout' => 10,
        ]);

        try {
            if ($platformName === 'facebook') {
                // Kiểm tra token cho Facebook
                $response = $client->get('debug_token', [
                    'query' => [
                        'input_token' => $account->access_token,
                        'access_token' => $account->app_id . '|' . $account->app_secret,
                    ],
                ]);

                if ($response->getStatusCode() === 200) {
                    $data = json_decode($response->getBody(), true);

                    if (isset($data['data']['is_valid']) && $data['data']['is_valid']) {
                        $expiresAt = null;
                        if (isset($data['data']['expires_at']) && $data['data']['expires_at'] > 0) {
                            $expiresAt = new \DateTime();
                            $expiresAt->setTimestamp($data['data']['expires_at']);
                        }
                        return [
                            'success' => true,
                            'expires_at' => $expiresAt
                        ];
                    }
                }

                return false;
            } elseif ($platformName === 'instagram') {
                // Kiểm tra token cho Instagram
                $response = $client->get('me', [
                    'query' => [
                        'fields' => 'id,username',
                        'access_token' => $account->access_token,
                    ],
                ]);

                if ($response->getStatusCode() === 200) {
                    $data = json_decode($response->getBody(), true);

                    if (isset($data['id']) && isset($data['username'])) {
                        // Instagram Graph API không trả về expires_at, giả định token dài hạn
                        return [
                            'success' => true,
                            'expires_at' => null // Instagram page access tokens thường không có thời hạn
                        ];
                    }
                }

                return false;
            }

            // Nền tảng không được hỗ trợ
            return false;
        } catch (RequestException $e) {
            return false;
        } catch (\Exception $e) {
            return false;
        }
    }
}   
