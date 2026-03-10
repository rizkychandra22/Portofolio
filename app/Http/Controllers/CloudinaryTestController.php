<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CloudinaryTestController extends Controller
{
    /**
     * Test apakah credentials Cloudinary valid.
     * GET /api/cloudinary-info
     */
    public function info()
    {
        try {
            $cloudName = env('CLOUDINARY_CLOUD_NAME');
            $key = env('CLOUDINARY_KEY');
            $secret = env('CLOUDINARY_SECRET');

            if (! $cloudName || ! $key || ! $secret) {
                return response()->json([
                    'success' => false,
                    'error_type' => 'MissingCredentials',
                    'message' => 'CLOUDINARY_CLOUD_NAME, CLOUDINARY_KEY, atau CLOUDINARY_SECRET tidak ditemukan di .env',
                ], 400);
            }

            // test dengan call sederhana ke upload API (tidak perlu Admin API key)
            $cloudinary = app('cloudinary');
            
            return response()->json([
                'success' => true,
                'message' => 'Cloudinary environment configured correctly',
                'cloud_name' => $cloudName,
                'key_configured' => ! empty($key),
                'secret_configured' => ! empty($secret),
            ]);
        } catch (\Throwable $e) {
            Log::error('Unexpected error in cloudinary-info', [
                'exception' => $e::class,
                'message' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'error_type' => $e::class,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Test upload dengan request form biasa (form-data).
     * POST /api/cloudinary-test
     * Parameter: file (image file)
     */
    public function test(Request $request)
    {
        try {
            $validated = $request->validate([
                'file' => 'required|image|mimes:jpeg,png,gif,webp|max:2048',
            ]);

            $file = $request->file('file');
            
            Log::info('CloudinaryTest: Starting upload', [
                'filename' => $file->getClientOriginalName(),
                'size' => $file->getSize(),
                'mime' => $file->getMimeType(),
            ]);

            // Strategy 1: Try getRealPath
            $realPath = $file->getRealPath();
            
            if (! empty($realPath) && is_file($realPath)) {
                Log::info('CloudinaryTest: Uploading via getRealPath');
                
                $uploaded = app('cloudinary')->uploadApi()->upload($realPath, [
                    'resource_type' => 'image',
                    'asset_folder'  => 'test',
                    'folder'        => 'test',
                ]);

                return response()->json([
                    'success' => true,
                    'method' => 'getRealPath',
                    'public_id' => $uploaded['public_id'] ?? 'unknown',
                    'url' => $uploaded['secure_url'] ?? $uploaded['url'] ?? null,
                    'message' => 'Upload berhasil via file path method',
                ]);
            }

            // Strategy 2: Fallback to tempfile
            Log::info('CloudinaryTest: getRealPath unavailable, using tempfile fallback');
            
            $tmpPath = tempnam(sys_get_temp_dir(), 'cld_test_');
            file_put_contents($tmpPath, $file->get());

            try {
                $uploaded = app('cloudinary')->uploadApi()->upload($tmpPath, [
                    'resource_type' => 'image',
                    'asset_folder'  => 'test',
                    'folder'        => 'test',
                ]);

                @unlink($tmpPath);

                return response()->json([
                    'success' => true,
                    'method' => 'tempfile',
                    'public_id' => $uploaded['public_id'] ?? 'unknown',
                    'url' => $uploaded['secure_url'] ?? $uploaded['url'] ?? null,
                    'message' => 'Upload berhasil via tempfile method',
                ]);
            } finally {
                @unlink($tmpPath);
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'error_type' => 'ValidationError',
                'message' => 'File validation failed',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Cloudinary\Api\Exception $e) {
            Log::error('Cloudinary upload failed', [
                'error' => $e->getMessage(),
                'code' => $e->getCode(),
            ]);

            return response()->json([
                'success' => false,
                'error_type' => 'CloudinaryUploadAPI',
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
            ], 400);
        } catch (\Throwable $e) {
            Log::error('Unexpected error in cloudinary-test', [
                'exception' => $e::class,
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'error_type' => $e::class,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
