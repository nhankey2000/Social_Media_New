<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Google\Client; // ✅ Dùng đúng class Client trong namespace Google

class YouTubeOAuthController extends Controller
{
    public function redirectToGoogle()
    {
        $account = DB::table('facebook_accounts')->where('platform_id', 9)->first();

        if (!$account) {
            abort(404, 'YouTube account not found');
        }

        $client = new Client(); // ✅ Dùng đúng tên class
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

        $client = new Client();
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
