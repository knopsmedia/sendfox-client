<?php

declare(strict_types=1);

namespace Knops\SendfoxClient\Resources;

class AutomationsResource extends BaseResource
{
    /**
     * Get all automations
     */
    public function all(): array
    {
        return $this->client->request('GET', '/automations');
    }

    /**
     * Get a specific automation by ID
     */
    public function get(int $automationId): array
    {
        return $this->client->request('GET', "/automations/{$automationId}");
    }
}
