<?php

/**
 * Example using Symfony HTTP Client
 * 
 * Install: composer require symfony/http-client nyholm/psr7
 */

require_once '../vendor/autoload.php';

use Knops\SendfoxClient\SendfoxClient;
use Nyholm\Psr7\Factory\Psr17Factory;
use Symfony\Component\HttpClient\Psr18Client;

// Setup
$httpClient = new Psr18Client();
$psr17Factory = new Psr17Factory();

$sendfox = new SendfoxClient(
    bearerToken: 'your-api-token-here',
    httpClient: $httpClient,
    requestFactory: $psr17Factory,
    streamFactory: $psr17Factory
);

try {
    echo "=== Testing API Connection with Symfony HTTP Client ===\n";
    
    // Test user endpoint
    $user = $sendfox->user()->me();
    echo "✓ User info retrieved: " . ($user['name'] ?? 'Unknown') . "\n";
    
    // Test contact fields
    $contactFields = $sendfox->user()->contactFields();
    echo "✓ Contact fields: " . count($contactFields['data'] ?? []) . " fields\n";
    
    // Test contacts
    $contacts = $sendfox->contacts()->all();
    echo "✓ Contacts: " . count($contacts['data'] ?? []) . " contacts\n";
    
    echo "\nAll tests passed! ✓\n";
    
} catch (\Knops\SendfoxClient\Exceptions\SendfoxException $e) {
    echo "❌ Sendfox API Error: " . $e->getMessage() . "\n";
    echo "Status Code: " . $e->getCode() . "\n";
} catch (\Exception $e) {
    echo "❌ General Error: " . $e->getMessage() . "\n";
}
