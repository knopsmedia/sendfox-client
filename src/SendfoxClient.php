<?php

declare(strict_types=1);

namespace Knops\SendfoxClient;

use Knops\SendfoxClient\Exceptions\SendfoxException;
use Knops\SendfoxClient\Resources\AutomationsResource;
use Knops\SendfoxClient\Resources\CampaignsResource;
use Knops\SendfoxClient\Resources\ContactsResource;
use Knops\SendfoxClient\Resources\FormsResource;
use Knops\SendfoxClient\Resources\ListsResource;
use Knops\SendfoxClient\Resources\UserResource;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;

class SendfoxClient
{
    private const BASE_URL = 'https://api.sendfox.com';

    public function __construct(
        private string $bearerToken,
        private ClientInterface $httpClient,
        private RequestFactoryInterface $requestFactory,
        private StreamFactoryInterface $streamFactory
    ) {
    }

    public function campaigns(): CampaignsResource
    {
        return new CampaignsResource($this);
    }

    public function contacts(): ContactsResource
    {
        return new ContactsResource($this);
    }

    public function lists(): ListsResource
    {
        return new ListsResource($this);
    }

    public function forms(): FormsResource
    {
        return new FormsResource($this);
    }

    public function automations(): AutomationsResource
    {
        return new AutomationsResource($this);
    }

    public function user(): UserResource
    {
        return new UserResource($this);
    }

    /**
     * Make an HTTP request to the Sendfox API
     */
    public function request(string $method, string $endpoint, array $data = []): array
    {
        $url = self::BASE_URL . '/' . ltrim($endpoint, '/');

        $request = $this->requestFactory->createRequest($method, $url);
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $request = $request->withHeader('Content-Type', 'application/json');
        $request = $request->withHeader('Accept', 'application/json');

        if (!empty($data) && in_array($method, ['POST', 'PUT', 'PATCH'])) {
            $body = $this->streamFactory->createStream(json_encode($data));
            $request = $request->withBody($body);
        }

        try {
            $response = $this->httpClient->sendRequest($request);
            return $this->parseResponse($response);
        } catch (\Exception $e) {
            throw new SendfoxException('Request failed: ' . $e->getMessage(), 0, $e);
        }
    }

    /**
     * Parse the HTTP response from the API
     */
    private function parseResponse(ResponseInterface $response): array
    {
        $statusCode = $response->getStatusCode();
        $body = (string) $response->getBody();

        // Check if response is successful
        if ($statusCode < 200 || $statusCode >= 300) {
            $errorData = json_decode($body, true) ?? [];
            $errorMessage = $errorData['message'] ?? 'API request failed';
            throw new SendfoxException($errorMessage, $statusCode);
        }

        // Parse JSON response
        $data = json_decode($body, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new SendfoxException('Invalid JSON response: ' . json_last_error_msg());
        }

        return $data ?? [];
    }
}
