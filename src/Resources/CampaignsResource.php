<?php

declare(strict_types=1);

namespace Knops\SendfoxClient\Resources;

class CampaignsResource extends BaseResource
{
    /**
     * Get all campaigns
     */
    public function all(): array
    {
        return $this->client->request('GET', '/campaigns');
    }

    /**
     * Get a specific campaign by ID
     */
    public function get(int $campaignId): array
    {
        return $this->client->request('GET', "/campaigns/{$campaignId}");
    }
}
