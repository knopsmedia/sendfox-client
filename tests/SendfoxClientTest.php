<?php

declare(strict_types=1);

namespace Knops\SendfoxClient\Tests;

use Knops\SendfoxClient\Resources\CampaignsResource;
use Knops\SendfoxClient\Resources\ContactsResource;
use Knops\SendfoxClient\SendfoxClient;
use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;

class SendfoxClientTest extends TestCase
{
    private SendfoxClient $client;
    private ClientInterface $httpClient;
    private RequestFactoryInterface $requestFactory;
    private StreamFactoryInterface $streamFactory;

    protected function setUp(): void
    {
        $this->httpClient = $this->createMock(ClientInterface::class);
        $this->requestFactory = $this->createMock(RequestFactoryInterface::class);
        $this->streamFactory = $this->createMock(StreamFactoryInterface::class);

        $this->client = new SendfoxClient(
            'test-token',
            $this->httpClient,
            $this->requestFactory,
            $this->streamFactory
        );
    }

    public function testCampaignsReturnsCorrectInstance(): void
    {
        $campaigns = $this->client->campaigns();
        $this->assertInstanceOf(CampaignsResource::class, $campaigns);
    }

    public function testContactsReturnsCorrectInstance(): void
    {
        $contacts = $this->client->contacts();
        $this->assertInstanceOf(ContactsResource::class, $contacts);
    }

    public function testAllResourceMethodsExist(): void
    {
        $this->assertInstanceOf(CampaignsResource::class, $this->client->campaigns());
        $this->assertInstanceOf(ContactsResource::class, $this->client->contacts());
        $this->assertTrue(method_exists($this->client, 'lists'));
        $this->assertTrue(method_exists($this->client, 'forms'));
        $this->assertTrue(method_exists($this->client, 'automations'));
        $this->assertTrue(method_exists($this->client, 'user'));
    }
}
