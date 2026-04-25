<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class BackgroundRemovalService
{
    /**
     * Call Remove.bg API using Guzzle multipart (official method).
     * Returns raw PNG bytes if successful, or null on failure.
     */
    public function removeBackground($imagePath)
    {
        $apiKey = config('services.removebg.key');
        if (!$apiKey) {
            Log::error('Remove.bg API Key is missing from config/services.php or .env');
            return null;
        }

        try {
            $client = new Client();
            $res = $client->post('https://api.remove.bg/v1.0/removebg', [
                'multipart' => [
                    [
                        'name'     => 'image_file',
                        'contents' => fopen($imagePath, 'r')
                    ],
                    [
                        'name'     => 'size',
                        'contents' => 'auto'
                    ]
                ],
                'headers' => [
                    'X-Api-Key' => $apiKey
                ]
            ]);

            Log::info('Remove.bg API success - status: ' . $res->getStatusCode());
            return $res->getBody()->getContents();

        } catch (\GuzzleHttp\Exception\ClientException $e) {
            Log::error('Remove.bg API ClientException: ' . $e->getMessage());
            if ($e->hasResponse()) {
                Log::error('Remove.bg Response Body: ' . $e->getResponse()->getBody()->getContents());
            }
            return null;
        } catch (\Exception $e) {
            Log::error('Remove.bg Exception: ' . $e->getMessage());
            return null;
        }
    }
}
