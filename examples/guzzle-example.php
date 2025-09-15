<?php

/**
 * Example using Guzzle HTTP Client
 * 
 * Install: composer require guzzlehttp/guzzle
 */

require_once '../vendor/autoload.php';

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\HttpFactory;
use Knops\SendfoxClient\SendfoxClient;

// Setup
$httpClient = new Client();
$httpFactory = new HttpFactory();

$sendfox = new SendfoxClient(
    bearerToken: 'your-api-token-here',
    httpClient: $httpClient,
    requestFactory: $httpFactory,
    streamFactory: $httpFactory
);

try {
    // Test API connection
    echo "=== Testing API Connection with Guzzle ===\n";
    $user = $sendfox->user()->me();
    echo "✓ API Connection successful!\n";
    echo "User: " . ($user['name'] ?? 'Unknown') . "\n";
    
    // Get campaigns
    $campaigns = $sendfox->campaigns()->all();
    echo "✓ Found " . count($campaigns['data'] ?? []) . " campaigns\n";
    
    // Get lists
    $lists = $sendfox->lists()->all();
    echo "✓ Found " . count($lists['data'] ?? []) . " lists\n";
    
} catch (\Knops\SendfoxClient\Exceptions\SendfoxException $e) {
    echo "❌ Sendfox API Error: " . $e->getMessage() . "\n";
    echo "Status Code: " . $e->getCode() . "\n";
} catch (\Exception $e) {
    echo "❌ General Error: " . $e->getMessage() . "\n";
}
