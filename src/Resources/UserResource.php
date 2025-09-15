<?php

declare(strict_types=1);

namespace Knops\SendfoxClient\Resources;

class UserResource extends BaseResource
{
    /**
     * Get current user information
     */
    public function me(): array
    {
        return $this->client->request('GET', '/me');
    }

    /**
     * Get user's contact fields
     */
    public function contactFields(): array
    {
        return $this->client->request('GET', '/user/contact-fields');
    }
}
