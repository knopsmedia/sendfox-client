<?php

declare(strict_types=1);

namespace Knops\SendfoxClient\Tests;

use Knops\SendfoxClient\Resources\ContactsResource;
use Knops\SendfoxClient\SendfoxClient;
use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class ContactsResourceTest extends TestCase
{
    private ContactsResource $contacts;
    private ClientInterface $httpClient;
    private RequestFactoryInterface $requestFactory;
    private StreamFactoryInterface $streamFactory;
    private SendfoxClient $sendfoxClient;

    protected function setUp(): void
    {
        $this->httpClient = $this->createMock(ClientInterface::class);
        $this->requestFactory = $this->createMock(RequestFactoryInterface::class);
        $this->streamFactory = $this->createMock(StreamFactoryInterface::class);

        $this->sendfoxClient = new SendfoxClient(
            'test-token',
            $this->httpClient,
            $this->requestFactory,
            $this->streamFactory
        );

        $this->contacts = $this->sendfoxClient->contacts();
    }

    public function testContactsResourceExists(): void
    {
        $this->assertInstanceOf(ContactsResource::class, $this->contacts);
    }

    public function testCreateContactMethodExists(): void
    {
        $this->assertTrue(method_exists($this->contacts, 'create'));
    }

    public function testUnsubscribeMethodExists(): void
    {
        $this->assertTrue(method_exists($this->contacts, 'unsubscribe'));
    }

    public function testUnsubscribedMethodExists(): void
    {
        $this->assertTrue(method_exists($this->contacts, 'unsubscribed'));
    }

    public function testAllMethodAcceptsParameters(): void
    {
        $reflection = new \ReflectionMethod($this->contacts, 'all');
        $parameters = $reflection->getParameters();

        $this->assertCount(3, $parameters);
        $this->assertEquals('query', $parameters[0]->getName());
        $this->assertEquals('unsubscribed', $parameters[1]->getName());
        $this->assertEquals('email', $parameters[2]->getName());
    }
}
