<?php

declare(strict_types=1);

namespace Knops\SendfoxClient\Resources;

class ContactsResource extends BaseResource
{
    /**
     * Get all contacts
     */
    public function all(): array
    {
        return $this->client->request('GET', '/contacts');
    }

    /**
     * Get a specific contact by ID
     */
    public function get(int $contactId): array
    {
        return $this->client->request('GET', "/contacts/{$contactId}");
    }
}
