<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use Google\Client as Google_Client;

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
        $account = DB::table('facebook_accounts')->where('platform_id', 9)->first();

        if (!$account) {
            abort(404, 'YouTube account not found');
        }

        $client = new Google_Client();
        $client->setClientId($account->app_id);
        $client->setClientSecret($account->app_secret);
        $client->setRedirectUri($account->redirect_url);
        $client->authenticate($request->get('code'));

        $token = $client->getAccessToken();

        DB::table('facebook_accounts')
            ->where('id', $account->id)
            ->update(['access_token' => json_encode($token)]);

        return redirect('/')->with('success', 'YouTube connected successfully.');
    }
}
