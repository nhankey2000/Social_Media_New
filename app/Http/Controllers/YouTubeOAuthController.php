<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Google_Client;

class YouTubeOAuthController extends Controller
{
    public function redirectToGoogle()
    {
        // Lấy từ bảng facebook_accounts, platform_id = 9 là YouTube
        $account = DB::table('facebook_accounts')->where('platform_id', 3)->first();

        if (!$account) {
            abort(404, 'YouTube account not found');
        }

        $client = new Google_Client();
        $client->setClientId($account->app_id);
        $client->setClientSecret($account->app_secret);
        $client->setRedirectUri($account->redirect_url);
        $client->addScope('https://www.googleapis.com/auth/youtube.upload');

        return redirect($client->createAuthUrl());
    }

    public function handleGoogleCallback(Request $request)
    {
        $account = DB::table('platform_accounts')->where('platform_id', 3)->first(); // hoặc 9 nếu bạn để YouTube là 9

        if (!$account) {
            abort(404, 'YouTube account not found');
        }

        $client = new \Google_Client();
        $client->setClientId($account->app_id);
        $client->setClientSecret($account->app_secret);
        $client->setRedirectUri($account->redirect_url);
        $client->authenticate($request->get('code'));

        $token = $client->getAccessToken();

        DB::table('platform_accounts')
            ->where('id', $account->id)
            ->update([
                'access_token' => $token['access_token'] ?? null,
                'refresh_token' => $token['refresh_token'] ?? null,
                'expires_at' => now()->addSeconds($token['expires_in'] ?? 3600),
                'updated_at' => now(),
            ]);

        return redirect('/')->with('success', 'YouTube connected successfully.');
    }

}
