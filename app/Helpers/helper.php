<?php

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

if (!function_exists('activeRoute')) {
    function activeRoute($routeName)
    {
        return Route::currentRouteNamed($routeName) ? 'active' : '';
    }
}
if (!function_exists('storeFileSurat')) {
    function storeFileSurat($file, $folder = 'surat')
    {
        if (!$file) {
            return null;
        }

        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs($folder, $filename, 'public');

        return $path;
    }
}

if (!function_exists('deleteFileSurat')) {
    function deleteFileSurat($path)
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}
if (!function_exists('deleteFileSurat')) {
    function deleteFileSurat($path)
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}

if (!function_exists('backupToGoogleDrive')) {

    /**
     * Backup file ke Google Drive melalui Apps Script
     *
     * @param string $path   Path file di storage public
     * @param string $jenis  masuk|keluar
     * @return array
     */
    function backupToGoogleDrive($path, $jenis = 'masuk')
    {
        if (!$path) {
            throw new Exception('Path file kosong.');
        }

        if (!Storage::disk('public')->exists($path)) {
            throw new Exception('File tidak ditemukan: ' . $path);
        }

        $fullPath = Storage::disk('public')->path($path);

        $payload = [
            'jenis'     => $jenis,
            'tahun'     => date('Y'),
            'filename'  => basename($fullPath),
            'mimeType'  => mime_content_type($fullPath),
            'file'      => base64_encode(
                file_get_contents($fullPath)
            ),
        ];

        $response = Http::asJson()
            ->timeout(120)
            ->post(
                env('GOOGLE_DRIVE_WEBHOOK'),
                $payload
            );

        Log::info('GDRIVE RESPONSE', [
            'status' => $response->status(),
            'body' => $response->body(),
        ]);


        if (!$response->successful()) {
            throw new Exception(
                'HTTP Error: ' . $response->status()
            );
        }

        $result = $response->json();

        if (
            !isset($result['status']) ||
            $result['status'] !== true
        ) {
            throw new Exception(
                $result['message'] ?? 'Backup Google Drive gagal.'
            );
        }

        return $result;
    }
}
