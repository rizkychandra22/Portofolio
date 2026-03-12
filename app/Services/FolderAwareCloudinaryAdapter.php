<?php

namespace App\Services;

use Cloudinary\Cloudinary;
use CloudinaryLabs\CloudinaryLaravel\CloudinaryStorageAdapter;
use League\Flysystem\Config;
use League\MimeTypeDetection\MimeTypeDetector;

class FolderAwareCloudinaryAdapter extends CloudinaryStorageAdapter
{
    private Cloudinary $cloudinaryInstance;
    private string $cloudName;

    public function __construct(Cloudinary $cloudinary, ?MimeTypeDetector $mimeTypeDetector = null, ?string $prefix = null)
    {
        parent::__construct($cloudinary, $mimeTypeDetector, $prefix);
        $this->cloudinaryInstance = $cloudinary;
        $this->cloudName = $cloudinary->configuration->cloud->cloudName ?? config('filesystems.disks.cloudinary.cloud', '');
    }

    /**
     * Generate URL langsung tanpa API call ke Cloudinary.
     * Original adapter memanggil adminApi()->asset() setiap kali = lambat.
     */
    public function getUrl(string $path): string
    {
        [$id, $type] = $this->prepareResource($path);

        $base = "https://res.cloudinary.com/{$this->cloudName}";

        return match ($type) {
            'video' => "{$base}/video/upload/{$id}",
            'raw'   => "{$base}/raw/upload/{$id}",
            default => "{$base}/image/upload/f_auto,q_auto/{$id}",
        };
    }

    /**
     * Cek file exists via upload API (jauh lebih cepat dari adminApi).
     * Jika file tidak ada, Cloudinary return error - kita tangkap.
     */
    public function fileExists(string $path): bool
    {
        // Path yang tersimpan di database pasti ada di Cloudinary.
        // Skip network check agar tidak timeout saat load 20+ gambar sekaligus.
        return !empty($path);
    }

    public function write(string $path, string $contents, Config $config): void
    {
        $options = $this->buildUploadOptions($path);
        $this->uploadWithRetry($contents, $options);
    }

    public function writeStream(string $path, $contents, Config $config): void
    {
        $options = $this->buildUploadOptions($path);
        $this->uploadWithRetry($contents, $options);
    }

    /**
     * Generate URL dengan transformasi Cloudinary (resize, crop, dll).
     */
    public function getTransformedUrl(string $path, string $transforms): string
    {
        [$id, $type] = $this->prepareResource($path);

        $base = "https://res.cloudinary.com/{$this->cloudName}";

        return match ($type) {
            'video' => "{$base}/video/upload/{$transforms}/{$id}",
            'raw'   => "{$base}/raw/upload/{$id}",
            default => "{$base}/image/upload/{$transforms}/{$id}",
        };
    }

    private function buildUploadOptions(string $path): array
    {
        [$id, $type] = $this->prepareResource($path);

        $info = pathinfo($path);
        $dirname = str_replace('\\', '/', $info['dirname']);

        $options = [
            'resource_type' => $type,
        ];

        if ($dirname && $dirname !== '.') {
            $options['folder'] = $dirname;
            $options['public_id'] = $info['filename'];
        } else {
            $options['public_id'] = $id;
        }

        return $options;
    }

    /**
     * Retry upload for transient network failures (e.g. cURL 56 connection reset).
     */
    private function uploadWithRetry(mixed $source, array $options): void
    {
        $maxAttempts = 4;

        for ($attempt = 1; $attempt <= $maxAttempts; $attempt++) {
            try {
                set_time_limit(300);

                if (is_resource($source)) {
                    @rewind($source);
                }

                $this->cloudinaryInstance->uploadApi()->upload($source, $options);
                return;
            } catch (\Throwable $e) {
                if ($attempt >= $maxAttempts || ! $this->isRetryableUploadException($e)) {
                    throw $e;
                }

                // Exponential backoff: 0.4s, 0.8s, 1.6s
                usleep(400000 * (2 ** ($attempt - 1)));
            }
        }
    }

    private function isRetryableUploadException(\Throwable $e): bool
    {
        $message = strtolower($e->getMessage());

        return str_contains($message, 'curl error 56')
            || str_contains($message, 'connection was reset')
            || str_contains($message, 'recv failure')
            || str_contains($message, 'curl error 28')
            || str_contains($message, 'operation timed out')
            || str_contains($message, 'ssl connection timeout')
            || str_contains($message, 'failed to connect');
    }
}
