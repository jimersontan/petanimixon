<?php
// Quick test of Remove.bg API
require __DIR__ . '/vendor/autoload.php';

$apiKey = 'SZfiDiycJKBR9y3GzFC1U7vK';

$client = new GuzzleHttp\Client();

// Test 1: Check account status
try {
    $res = $client->get('https://api.remove.bg/v1.0/account', [
        'headers' => [
            'X-Api-Key' => $apiKey
        ]
    ]);
    echo "Account Status: " . $res->getBody() . "\n";
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    if ($e instanceof GuzzleHttp\Exception\ClientException && $e->hasResponse()) {
        echo "Response: " . $e->getResponse()->getBody()->getContents() . "\n";
    }
}
