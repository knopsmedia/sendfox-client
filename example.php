<?php

require_once 'vendor/autoload.php';

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\HttpFactory;
use Knops\SendfoxClient\SendfoxClient;

// Setup HTTP client en factories (Guzzle voorbeeld)
$httpClient = new Client();
$httpFactory = new HttpFactory();

// Initialiseer Sendfox client
$sendfox = new SendfoxClient(
    bearerToken: 'your-sendfox-api-token-here',
    httpClient: $httpClient,
    requestFactory: $httpFactory,
    streamFactory: $httpFactory
);

try {
    // Haal alle campaigns op
    echo "=== Campaigns ===\n";
    $campaigns = $sendfox->campaigns()->all();
    echo "Aantal campaigns: " . count($campaigns['data'] ?? []) . "\n\n";

    // Haal alle contacten op
    echo "=== Contacts ===\n";
    $contacts = $sendfox->contacts()->all();
    echo "Aantal contacten: " . count($contacts['data'] ?? []) . "\n\n";

    // Haal alle lijsten op
    echo "=== Lists ===\n";
    $lists = $sendfox->lists()->all();
    echo "Aantal lijsten: " . count($lists['data'] ?? []) . "\n\n";

    // Gebruiker informatie
    echo "=== User Info ===\n";
    $user = $sendfox->user()->me();
    echo "Gebruiker: " . ($user['name'] ?? 'Onbekend') . "\n";
    echo "Email: " . ($user['email'] ?? 'Onbekend') . "\n\n";

    // Contact fields
    echo "=== Contact Fields ===\n";
    $contactFields = $sendfox->user()->contactFields();
    echo "Aantal contact fields: " . count($contactFields['data'] ?? []) . "\n";

} catch (\Knops\SendfoxClient\Exceptions\SendfoxException $e) {
    echo "Sendfox API Error: " . $e->getMessage() . "\n";
    echo "Status Code: " . $e->getCode() . "\n";
} catch (\Exception $e) {
    echo "General Error: " . $e->getMessage() . "\n";
}
