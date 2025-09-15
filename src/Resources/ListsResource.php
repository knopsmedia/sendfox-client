<?php

declare(strict_types=1);

namespace Knops\SendfoxClient\Resources;

class ListsResource extends BaseResource
{
    /**
     * Get all lists
     */
    public function all(): array
    {
        return $this->client->request('GET', '/lists');
    }

    /**
     * Get a specific list by ID
     */
    public function get(int $listId): array
    {
        return $this->client->request('GET', "/lists/{$listId}");
    }

    /**
     * Create a new list
     */
    public function create(string $name): array
    {
        return $this->client->request('POST', '/lists', [
            'name' => $name
        ]);
    }

    /**
     * Get contacts in a specific list
     */
    public function contacts(int $listId): array
    {
        return $this->client->request('GET', "/lists/{$listId}/contacts");
    }

    /**
     * Remove a contact from a list
     */
    public function removeContact(int $listId, int $contactId): array
    {
        return $this->client->request('DELETE', "/lists/{$listId}/contacts/{$contactId}");
    }
}
