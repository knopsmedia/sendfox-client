<?php

/**
 * Advanced Contact Management Example
 * 
 * This example demonstrates the new contact management features:
 * - Creating contacts
 * - Unsubscribing contacts  
 * - Listing unsubscribed contacts
 * - Filtering contacts
 */

require_once '../vendor/autoload.php';

use Knops\SendfoxClient\SendfoxClient;
use Knops\SendfoxClient\Models\Contact;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\HttpFactory;

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
    echo "=== Contact Management Examples ===\n\n";

    // 1. Create a new contact
    echo "1. Creating a new contact...\n";
    $newContact = $sendfox->contacts()->create(
        email: 'new.contact@example.com',
        firstName: 'Jane',
        lastName: 'Smith',
        ipAddress: '192.168.1.100',
        lists: [123, 456], // Add to lists with IDs 123 and 456
        contactFields: [
            ['name' => 'company', 'value' => 'Acme Corp'],
            ['name' => 'phone', 'value' => '+1234567890']
        ]
    );
    
    // Create Contact model from response
    $contact = Contact::fromArray($newContact);
    echo "✓ Created contact: {$contact->email} (ID: {$contact->id})\n";
    echo "  Name: {$contact->first_name} {$contact->last_name}\n";
    echo "  Unsubscribed: " . ($contact->isUnsubscribed() ? 'Yes' : 'No') . "\n\n";

    // 2. List all contacts with filters
    echo "2. Listing contacts with filters...\n";
    
    // Get all contacts
    $allContacts = $sendfox->contacts()->all();
    echo "✓ Total contacts: " . count($allContacts['data'] ?? []) . "\n";
    
    // Filter by search query
    $searchResults = $sendfox->contacts()->all(query: 'jane');
    echo "✓ Contacts matching 'jane': " . count($searchResults['data'] ?? []) . "\n";
    
    // Filter by specific email
    $emailResults = $sendfox->contacts()->all(email: 'new.contact@example.com');
    echo "✓ Contact with specific email: " . count($emailResults['data'] ?? []) . "\n";
    
    // Filter only unsubscribed contacts
    $unsubscribedResults = $sendfox->contacts()->all(unsubscribed: true);
    echo "✓ Unsubscribed contacts via filter: " . count($unsubscribedResults['data'] ?? []) . "\n\n";

    // 3. Unsubscribe a contact
    echo "3. Unsubscribing a contact...\n";
    $unsubscribeResult = $sendfox->contacts()->unsubscribe('new.contact@example.com');
    
    $unsubscribedContact = Contact::fromArray($unsubscribeResult);
    echo "✓ Unsubscribed contact: {$unsubscribedContact->email}\n";
    echo "  Unsubscribed at: {$unsubscribedContact->unsubscribed_at}\n";
    echo "  Is unsubscribed: " . ($unsubscribedContact->isUnsubscribed() ? 'Yes' : 'No') . "\n\n";

    // 4. Get list of unsubscribed contacts
    echo "4. Getting unsubscribed contacts list...\n";
    $unsubscribedList = $sendfox->contacts()->unsubscribed();
    echo "✓ Total unsubscribed contacts: " . count($unsubscribedList['data'] ?? []) . "\n";
    
    // Search within unsubscribed contacts
    $unsubscribedSearch = $sendfox->contacts()->unsubscribed(query: 'example');
    echo "✓ Unsubscribed contacts matching 'example': " . count($unsubscribedSearch['data'] ?? []) . "\n\n";

    // 5. Display some contact details using the model
    echo "5. Contact model features...\n";
    if (!empty($allContacts['data'])) {
        foreach (array_slice($allContacts['data'], 0, 3) as $contactData) {
            $contact = Contact::fromArray($contactData);
            echo "• {$contact->email} - ";
            echo ($contact->first_name || $contact->last_name) 
                ? "{$contact->first_name} {$contact->last_name}" 
                : "No name";
            echo " (" . ($contact->isUnsubscribed() ? 'Unsubscribed' : 'Active') . ")\n";
        }
    }

    echo "\n✅ All contact management examples completed successfully!\n";

} catch (\Knops\SendfoxClient\Exceptions\SendfoxException $e) {
    echo "❌ Sendfox API Error: " . $e->getMessage() . "\n";
    echo "Status Code: " . $e->getCode() . "\n";
} catch (\Exception $e) {
    echo "❌ General Error: " . $e->getMessage() . "\n";
}
