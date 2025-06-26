<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Google_Client;
use Google_Service_YouTube;

class YouTubeOAuthController extends Controller
{
    public function redirectToGoogle()
    {
        // Lấy từ bảng facebook_accounts, platform_id = 3 là YouTube
        $account = DB::table('facebook_accounts')->where('platform_id', 3)->first();

        if (!$account) {
            abort(404, 'YouTube account not found in facebook_accounts');
        }

        $client = new Google_Client();
        $client->setClientId($account->app_id);
        $client->setClientSecret($account->app_secret);
        $client->setRedirectUri($account->redirect_url);
        $client->setAccessType('offline');
        $client->setPrompt('consent');
        $client->addScope('https://www.googleapis.com/auth/youtube.readonly');
        $client->addScope('https://www.googleapis.com/auth/youtube.upload');
        $client->addScope('https://www.googleapis.com/auth/userinfo.email');
        $client->addScope('https://www.googleapis.com/auth/userinfo.profile');
        return redirect($client->createAuthUrl());
    }

    public function handleGoogleCallback(Request $request)
    {
        // Lấy thông tin từ facebook_accounts
        $account = DB::table('facebook_accounts')->where('platform_id', 3)->first();

        if (!$account) {
            abort(404, 'YouTube account not found in facebook_accounts');
        }

        $client = new Google_Client();
        $client->setClientId($account->app_id);
        $client->setClientSecret($account->app_secret);
        $client->setRedirectUri($account->redirect_url);

        // Xác thực và lấy access token
        $client->authenticate($request->get('code'));
        $token = $client->getAccessToken();

        // Lấy thông tin channel
        $youtube = new Google_Service_YouTube($client);
        $channelsResponse = $youtube->channels->listChannels('snippet', [
            'mine' => true
        ]);

        $channelName = $channelsResponse->getItems()[0]->snippet->title;

        // Lưu vào bảng platform_accounts
        DB::table('platform_accounts')
            ->updateOrInsert(
                ['platform_id' => 3],
                [
                    'name' => $channelName,
                    'access_token' => json_encode($token),
                    'updated_at' => now()
                ]
            );

        return redirect('/admin/platform-accounts')->with('success', 'YouTube connected successfully.');
    }
}
