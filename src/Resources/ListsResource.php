<?php

declare(strict_types=1);

namespace Knops\SendfoxClient\Resources;

class ListsResource extends BaseResource
{
    /**
     * Get all lists
     *
     * @param string|null $query Search query for filtering lists
     */
    public function all(?string $query = null): array
    {
        $endpoint = '/lists';
        if ($query !== null) {
            $endpoint .= '?' . http_build_query(['query' => $query]);
        }

        return $this->client->request('GET', $endpoint);
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
     *
     * @param int $listId The list ID
     * @param string|null $query Search query for filtering contacts in this list
     */
    public function contacts(int $listId, ?string $query = null): array
    {
        $endpoint = "/lists/{$listId}/contacts";
        if ($query !== null) {
            $endpoint .= '?' . http_build_query(['query' => $query]);
        }

        return $this->client->request('GET', $endpoint);
    }

    /**
     * Remove a contact from a list
     */
    public function removeContact(int $listId, int $contactId): array
    {
        return $this->client->request('DELETE', "/lists/{$listId}/contacts/{$contactId}");
    }
}
