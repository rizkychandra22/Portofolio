<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Google\Client;
use Google\Service\Gmail;

class GmailAuth extends Command
{
    protected $signature = 'gmail:auth';
    protected $description = 'Generate Gmail OAuth token';

    public function handle()
    {
        $client = new Client();
        $client->setApplicationName('Laravel Gmail');
        $client->setScopes([Gmail::GMAIL_SEND]);
        $client->setAuthConfig(storage_path('app/key/credentials.json'));
        $client->setAccessType('offline');
        $client->setPrompt('select_account consent');

        $authUrl = $client->createAuthUrl();
        $this->info("🔗 Buka link ini di browser:");
        $this->line($authUrl);
        $this->info("");
        $this->info("📋 Ikuti langkah-langkah berikut:");
        $this->info("1. Login ke akun Gmail yang ingin digunakan");
        $this->info("2. Berikan permission untuk akses Gmail");
        $this->info("3. Anda akan di-redirect ke halaman sukses");
        $this->info("");
        $this->info("⏳ Menunggu autentikasi selesai...");

        // Tunggu beberapa detik untuk user menyelesaikan autentikasi
        sleep(3);

        // Cek apakah token sudah dibuat setiap 2 detik selama 60 detik
        $maxAttempts = 30;
        $attempt = 0;

        while ($attempt < $maxAttempts) {
            $tokenPath = storage_path('app/key/token.json');

            if (file_exists($tokenPath)) {
                $tokenData = json_decode(file_get_contents($tokenPath), true);

                if (isset($tokenData['access_token']) && !isset($tokenData['error'])) {
                    $this->info('✅ Token Gmail berhasil dibuat!');
                    $this->info('📧 Email akan dikirim dari akun Gmail yang diautentikasi');
                    $this->info('🚀 Fitur kirim email dari halaman kontak sudah siap digunakan!');
                    return;
                }
            }

            sleep(2);
            $attempt++;
            $this->info("🔄 Menunggu autentikasi... ({$attempt}/{$maxAttempts})");
        }

        $this->error('❌ Timeout: Token belum dibuat. Pastikan Anda telah menyelesaikan autentikasi di browser.');
        $this->info('💡 Tips: Jika browser tidak redirect otomatis, copy URL callback dan buka manual.');
    }
}
