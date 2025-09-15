<?php

declare(strict_types=1);

namespace Knops\SendfoxClient\Resources;

class FormsResource extends BaseResource
{
    /**
     * Get all forms
     *
     * @param string|null $query Search query for filtering forms
     */
    public function all(?string $query = null): array
    {
        $endpoint = '/forms';
        if ($query !== null) {
            $endpoint .= '?' . http_build_query(['query' => $query]);
        }

        return $this->client->request('GET', $endpoint);
    }

    /**
     * Get a specific form by ID
     */
    public function get(int $formId): array
    {
        return $this->client->request('GET', "/forms/{$formId}");
    }
}
