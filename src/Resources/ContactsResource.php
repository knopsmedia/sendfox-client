<?php

declare(strict_types=1);

namespace Knops\SendfoxClient\Resources;

class ContactsResource extends BaseResource
{
    /**
     * Get all contacts
     *
     * @param string|null $query Search query for filtering contacts
     * @param bool|null $unsubscribed Filter unsubscribed contacts
     * @param string|null $email Filter by specific email
     */
    public function all(?string $query = null, ?bool $unsubscribed = null, ?string $email = null): array
    {
        $params = [];
        if ($query !== null) {
            $params['query'] = $query;
        }
        if ($unsubscribed !== null) {
            $params['unsubscribed'] = $unsubscribed ? 'true' : 'false';
        }
        if ($email !== null) {
            $params['email'] = $email;
        }

        $endpoint = '/contacts';
        if (!empty($params)) {
            $endpoint .= '?' . http_build_query($params);
        }

        return $this->client->request('GET', $endpoint);
    }

    /**
     * Get a specific contact by ID
     */
    public function get(int $contactId): array
    {
        return $this->client->request('GET', "/contacts/{$contactId}");
    }

    /**
     * Create a new contact
     *
     * @param string $email The contact's email address
     * @param string|null $firstName First name
     * @param string|null $lastName Last name
     * @param string|null $ipAddress IP address
     * @param array|null $lists Array of list IDs to add the contact to
     * @param array|null $contactFields Array of custom contact fields
     */
    public function create(
        string $email,
        ?string $firstName = null,
        ?string $lastName = null,
        ?string $ipAddress = null,
        ?array $lists = null,
        ?array $contactFields = null
    ): array {
        $data = ['email' => $email];

        if ($firstName !== null) {
            $data['first_name'] = $firstName;
        }
        if ($lastName !== null) {
            $data['last_name'] = $lastName;
        }
        if ($ipAddress !== null) {
            $data['ip_address'] = $ipAddress;
        }
        if ($lists !== null) {
            $data['lists'] = $lists;
        }
        if ($contactFields !== null) {
            $data['contact_fields'] = $contactFields;
        }

        return $this->client->request('POST', '/contacts', $data);
    }

    /**
     * Unsubscribe a contact by email
     *
     * @param string $email The email address to unsubscribe
     */
    public function unsubscribe(string $email): array
    {
        return $this->client->request('POST', '/contacts/unsubscribe', [
            'email' => $email
        ]);
    }

    /**
     * Get list of unsubscribed contacts
     *
     * @param string|null $query Search query for filtering contacts
     */
    public function unsubscribed(?string $query = null): array
    {
        $endpoint = '/contacts/unsubscribed';
        if ($query !== null) {
            $endpoint .= '?' . http_build_query(['query' => $query]);
        }

        return $this->client->request('GET', $endpoint);
    }
}
