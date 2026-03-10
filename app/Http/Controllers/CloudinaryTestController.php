<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CloudinaryTestController extends Controller
{
    /**
     * Test upload dengan request form biasa (form-data).
     * Jalan di: /api/cloudinary-test
     */
    public function test(Request $request)
    {
        try {
            // Validasi file
            $request->validate([
                'file' => 'required|image|max:2048',
            ]);

            $file = $request->file('file');
            
            Log::info('CloudinaryTest: Starting upload', [
                'original_name' => $file->getClientOriginalName(),
                'size' => $file->getSize(),
                'mime' => $file->getMimeType(),
            ]);

            // Test 1: Coba upload dengan getRealPath
            try {
                $realPath = $file->getRealPath();
                Log::info('CloudinaryTest: Real path obtained', ['path' => $realPath, 'exists' => is_file($realPath)]);

                if (is_file($realPath)) {
                    $uploaded = cloudinary()->uploadApi()->upload($realPath, [
                        'resource_type' => 'image',
                        'asset_folder'  => 'test',
                        'folder'        => 'test',
                    ]);

                    return response()->json([
                        'success' => true,
                        'method' => 'getRealPath',
                        'public_id' => $uploaded['public_id'] ?? 'unknown',
                        'url' => $uploaded['secure_url'] ?? $uploaded['url'] ?? 'unknown',
                    ]);
                }
            } catch (\Throwable $e) {
                Log::warning('CloudinaryTest: getRealPath failed, trying fallback', [
                    'error' => $e->getMessage(),
                ]);
            }

            // Test 2: Fallback dengan file content
            Log::info('CloudinaryTest: Trying fallback with file bytes');
            $ext = $file->getClientOriginalExtension() ?: 'jpg';
            $tmpPath = tempnam(sys_get_temp_dir(), 'cld_') . '.' . $ext;
            file_put_contents($tmpPath, $file->get());

            Log::info('CloudinaryTest: Temp file written', ['tmpPath' => $tmpPath, 'exists' => is_file($tmpPath)]);

            try {
                $uploaded = cloudinary()->uploadApi()->upload($tmpPath, [
                    'resource_type' => 'image',
                    'asset_folder'  => 'test',
                    'folder'        => 'test',
                ]);

                @unlink($tmpPath);

                return response()->json([
                    'success' => true,
                    'method' => 'tempfile',
                    'public_id' => $uploaded['public_id'] ?? 'unknown',
                    'url' => $uploaded['secure_url'] ?? $uploaded['url'] ?? 'unknown',
                ]);
            } catch (\Throwable $e) {
                @unlink($tmpPath);
                throw $e;
            }
        } catch (\Throwable $exception) {
            Log::error('CloudinaryTest: Upload failed', [
                'exception_class' => $exception::class,
                'message' => $exception->getMessage(),
                'trace' => $exception->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'error' => $exception::class,
                'message' => $exception->getMessage(),
            ], 500);
        }
    }

    /**
     * Test apakah credentials Cloudinary valid.
     * Jalan di: /api/cloudinary-info
     */
    public function info()
    {
        try {
            $result = cloudinary()->adminApi()->resources(['max_results' => 1]);

            return response()->json([
                'success' => true,
                'message' => 'Cloudinary credentials valid',
                'cloud_name' => config('cloudinary.cloud_name') ?? env('CLOUDINARY_CLOUD_NAME'),
                'resources_count' => $result['total_count'] ?? 'unknown',
            ]);
        } catch (\Throwable $exception) {
            return response()->json([
                'success' => false,
                'error' => $exception::class,
                'message' => $exception->getMessage(),
            ], 500);
        }
    }
}
