<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Google\Client;
use Google\Service\Gmail;

class GoogleAuthController extends Controller
{
    public function callback(Request $request)
    {
        $code = $request->get('code');

        if (!$code) {
            return response()->json(['error' => 'No authorization code provided'], 400);
        }

        try {
            $client = new Client();
            $client->setApplicationName('Laravel Gmail');
            $client->setScopes([Gmail::GMAIL_SEND]);
            $client->setAuthConfig(storage_path('app/key/credentials.json'));
            $client->setAccessType('offline');
            $client->setPrompt('select_account consent');

            $token = $client->fetchAccessTokenWithAuthCode($code);

            file_put_contents(
                storage_path('app/key/token.json'),
                json_encode($token)
            );

            return response()->json([
                'success' => true,
                'message' => 'Token Gmail berhasil dibuat! Anda dapat menutup tab ini.',
                'token' => $token
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Gagal mendapatkan token: ' . $e->getMessage()
            ], 500);
        }
    }
}