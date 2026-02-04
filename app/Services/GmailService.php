<?php

namespace App\Services;

use Google\Client;
use Google\Service\Gmail;
use Google\Service\Gmail\Message;

class GmailService
{
    protected Gmail $service;
    protected string $user = 'me';

    public function __construct()
    {
        $client = new Client();
        $client->setApplicationName('Laravel Gmail');
        $client->setScopes([Gmail::GMAIL_SEND]);
        $client->setAuthConfig(storage_path('app/key/credentials.json'));
        $client->setAccessType('offline');
        $client->setPrompt('select_account consent');

        // token
        $tokenPath = storage_path('app/key/token.json');

        if (file_exists($tokenPath)) {
            $tokenData = json_decode(file_get_contents($tokenPath), true);
            if (isset($tokenData['access_token'])) {
                $client->setAccessToken($tokenData);
            }
        }

        if ($client->isAccessTokenExpired()) {
            if ($client->getRefreshToken()) {
                try {
                    $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
                    file_put_contents($tokenPath, json_encode($client->getAccessToken()));
                } catch (\Exception $e) {
                    throw new \Exception('Token Gmail kadaluarsa. Jalankan php artisan gmail:auth lagi.');
                }
            } else {
                throw new \Exception('Token Gmail belum dibuat. Jalankan php artisan gmail:auth.');
            }
        }

        $this->service = new Gmail($client);
    }

    public function send(string $to, string $subject, string $html)
    {
        $rawMessage = "To: {$to}\r\n";
        $rawMessage .= "Subject: {$subject}\r\n";
        $rawMessage .= "MIME-Version: 1.0\r\n";
        $rawMessage .= "Content-Type: text/html; charset=utf-8\r\n\r\n";
        $rawMessage .= $html;

        $message = new Message();
        $message->setRaw(base64_encode($rawMessage));

        return $this->service->users_messages->send($this->user, $message);
    }
}
