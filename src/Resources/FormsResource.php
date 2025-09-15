<?php

declare(strict_types=1);

namespace Knops\SendfoxClient\Resources;

class FormsResource extends BaseResource
{
    /**
     * Get all forms
     */
    public function all(): array
    {
        return $this->client->request('GET', '/forms');
    }

    /**
     * Get a specific form by ID
     */
    public function get(int $formId): array
    {
        return $this->client->request('GET', "/forms/{$formId}");
    }
}
