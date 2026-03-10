<?php

namespace App\Support;

class CloudinaryUrl
{
    public static function fromPath(?string $path): string
    {
        if (empty($path)) {
            return '';
        }

        // Keep legacy values that already store a full URL.
        if (filter_var($path, FILTER_VALIDATE_URL) !== false) {
            return $path;
        }

        $info = pathinfo(str_replace('\\\\', '/', $path));
        $dirname = ($info['dirname'] ?? '.') !== '.' ? $info['dirname'] : '';
        $filename = $info['filename'] ?? '';

        $publicId = ltrim(($dirname ? $dirname.'/' : '').$filename, '/');

        if ($publicId === '') {
            return '';
        }

        return (string) app(\Cloudinary\Cloudinary::class)->image($publicId)->toUrl();
    }
}
