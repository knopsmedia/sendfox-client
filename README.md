# Sendfox API Client

Een PHP library voor communicatie met de Sendfox API, gebouwd met PSR HTTP Client Interface voor maximale flexibiliteit.

## Features

- ✅ PSR-7, PSR-17 en PSR-18 compliant
- ✅ Geen afhankelijkheid van een specifieke HTTP client
- ✅ Volledig typed met PHP 8.0+ property types
- ✅ Alle Sendfox API endpoints ondersteund
- ✅ Exception handling
- ✅ Data models voor veelgebruikte responses

## Installatie

```bash
composer require knops/sendfox-client
```

## Vereisten

- PHP 8.0 of hoger
- Een PSR-18 HTTP Client (zoals Guzzle, Symfony HTTP Client, etc.)
- Een PSR-17 HTTP Factory implementatie
- Een Sendfox API token

## Quick Start

### 1. Installeer een HTTP client

```bash
# Voor Guzzle
composer require guzzlehttp/guzzle

# Of voor Symfony HTTP Client
composer require symfony/http-client nyholm/psr7
```

### 2. Basis gebruik met Guzzle

```php
<?php

use GuzzleHttp\Client;use GuzzleHttp\Psr7\HttpFactory;use Knops\SendfoxClient\SendfoxClient;

// Setup HTTP client en factories
$httpClient = new Client();
$httpFactory = new HttpFactory();

// Initialiseer Sendfox client
$sendfox = new SendfoxClient(
    bearerToken: 'your-sendfox-api-token',
    httpClient: $httpClient,
    requestFactory: $httpFactory,
    streamFactory: $httpFactory
);

// Gebruik de API
$campaigns = $sendfox->campaigns()->all();
$contacts = $sendfox->contacts()->all();
```

### 3. Gebruik met Symfony HTTP Client

```php
<?php

use Knops\SendfoxClient\SendfoxClient;use Nyholm\Psr7\Factory\Psr17Factory;use Symfony\Component\HttpClient\Psr18Client;

$httpClient = new Psr18Client();
$psr17Factory = new Psr17Factory();

$sendfox = new SendfoxClient(
    bearerToken: 'your-sendfox-api-token',
    httpClient: $httpClient,
    requestFactory: $psr17Factory,
    streamFactory: $psr17Factory
);
```

## API Usage

### Campaigns

```php
// Alle campaigns ophalen
$campaigns = $sendfox->campaigns()->all();

// Specifieke campaign ophalen
$campaign = $sendfox->campaigns()->get(2490607);
```

### Contacts

```php
// Alle contacten ophalen
$contacts = $sendfox->contacts()->all();

// Contacten filteren
$filtered = $sendfox->contacts()->all(
    query: 'john',              // Zoek op naam/email
    unsubscribed: true,         // Alleen uitgeschreven contacten
    email: 'test@example.com'   // Specifiek emailadres
);

// Specifiek contact ophalen
$contact = $sendfox->contacts()->get(125534483);

// Nieuw contact aanmaken
$newContact = $sendfox->contacts()->create(
    email: 'new@example.com',
    firstName: 'John',
    lastName: 'Doe',
    ipAddress: '192.168.1.1',
    lists: [123, 456],  // Voeg toe aan lijsten
    contactFields: [
        ['name' => 'company', 'value' => 'Acme Corp'],
        ['name' => 'phone', 'value' => '+31612345678']
    ]
);

// Contact uitschrijven
$sendfox->contacts()->unsubscribe('email@example.com');

// Uitgeschreven contacten ophalen
$unsubscribed = $sendfox->contacts()->unsubscribed();

// Zoeken in uitgeschreven contacten
$unsubscribedFiltered = $sendfox->contacts()->unsubscribed('john');
```

### Lists

```php
// Alle lijsten ophalen
$lists = $sendfox->lists()->all();

// Lijsten filteren
$filteredLists = $sendfox->lists()->all('newsletter');

// Specifieke lijst ophalen
$list = $sendfox->lists()->get(584322);

// Nieuwe lijst aanmaken
$newList = $sendfox->lists()->create('Nieuwe lijst naam');

// Contacten in lijst ophalen
$listContacts = $sendfox->lists()->contacts(584322);

// Contacten in lijst zoeken
$searchResults = $sendfox->lists()->contacts(584322, 'john');

// Contact uit lijst verwijderen
$sendfox->lists()->removeContact(584322, 125534483);
```

### Forms

```php
// Alle formulieren ophalen
$forms = $sendfox->forms()->all();

// Formulieren filteren
$filteredForms = $sendfox->forms()->all('signup');

// Specifiek formulier ophalen
$form = $sendfox->forms()->get(123);
```

### Automations

```php
// Alle automations ophalen
$automations = $sendfox->automations()->all();

// Specifieke automation ophalen
$automation = $sendfox->automations()->get(456);
```

### User

```php
// Huidige gebruiker informatie
$user = $sendfox->user()->me();

// Contact velden van gebruiker
$contactFields = $sendfox->user()->contactFields();
```

## Data Models

De library bevat enkele data models voor veelgebruikte responses:

```php
use Knops\SendfoxClient\Models\Campaign;
use Knops\SendfoxClient\Models\Contact;
use Knops\SendfoxClient\Models\ContactList;
use Knops\SendfoxClient\Models\Form;
use Knops\SendfoxClient\Models\Automation;
use Knops\SendfoxClient\Models\User;

// Creëer model van array data
$campaign = Campaign::fromArray($campaignData);
$contact = Contact::fromArray($contactData);
$list = ContactList::fromArray($listData);
$form = Form::fromArray($formData);
$automation = Automation::fromArray($automationData);
$user = User::fromArray($userData);

// Converteer model terug naar array
$array = $campaign->toArray();
```

### Contact Model Features

Het `Contact` model heeft extra functionaliteit:

```php
$contact = Contact::fromArray($contactData);

// Toegang tot alle contact eigenschappen
echo $contact->id;              // Contact ID
echo $contact->email;           // Email address
echo $contact->first_name;      // Voornaam
echo $contact->last_name;       // Achternaam
echo $contact->ip_address;      // IP adres
echo $contact->unsubscribed_at; // Uitschrijf datum (null als niet uitgeschreven)
echo $contact->created_at;      // Aanmaak datum
echo $contact->updated_at;      // Update datum

// Controleer uitschrijf status
if ($contact->isUnsubscribed()) {
    echo "Contact is uitgeschreven op: " . $contact->unsubscribed_at;
} else {
    echo "Contact is actief";
}
```

### User Model Features

Het `User` model heeft extra functionaliteit voor account monitoring:

```php
$user = User::fromArray($userData);

// Toegang tot gebruiker eigenschappen
echo $user->name;            // Gebruikersnaam
echo $user->email;           // Email adres
echo $user->contacts_count;  // Aantal contacten
echo $user->contact_limit;   // Contact limiet

// Contact limiet monitoring
if ($user->isAtContactLimit()) {
    echo "Je hebt je contact limiet bereikt!";
}

// Contact gebruik percentage
$usage = $user->getContactUsagePercentage();
echo "Contact gebruik: {$usage}%";
```

### ContactList Model Features

Het `ContactList` model bevat performance statistieken:

```php
$list = ContactList::fromArray($listData);

echo $list->name;                          // Lijst naam
echo $list->average_email_open_percent;    // Gemiddeld open percentage
echo $list->average_email_click_percent;   // Gemiddeld klik percentage
```

## Exception Handling

```php
use Knops\SendfoxClient\Exceptions\SendfoxException;

try {
    $campaign = $sendfox->campaigns()->get(999999);
} catch (SendfoxException $e) {
    echo "API Error: " . $e->getMessage();
    echo "Status Code: " . $e->getCode();
}
```

## Dependency Injection

Met een DI container kun je de client eenvoudig registreren:

```php
// Symfony DI example
$container->register(SendfoxClient::class)
    ->setArguments([
        '$bearerToken' => '%sendfox.api_token%',
        '$httpClient' => new Reference(ClientInterface::class),
        '$requestFactory' => new Reference(RequestFactoryInterface::class),
        '$streamFactory' => new Reference(StreamFactoryInterface::class),
    ]);
```

## Testing

Voor testing kun je eenvoudig een mock HTTP client gebruiken:

```php
use Psr\Http\Client\ClientInterface;
use PHPUnit\Framework\TestCase;

class SendfoxClientTest extends TestCase
{
    public function testCampaignsCall()
    {
        $httpClient = $this->createMock(ClientInterface::class);
        // Setup mock expectations...
        
        $sendfox = new SendfoxClient(
            'test-token',
            $httpClient,
            $requestFactory,
            $streamFactory
        );
        
        // Test your logic...
    }
}
```

## License

MIT License. Zie [LICENSE](LICENSE) voor details.

## Contributing

Bijdragen zijn welkom! Open een issue of submit een pull request.

## API Documentatie

Voor volledige API documentatie, zie: [Sendfox API Documentation](https://sendfox.com/api)
