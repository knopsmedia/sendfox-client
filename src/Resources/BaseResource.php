<?php

declare(strict_types=1);

namespace Knops\SendfoxClient\Resources;

use Knops\SendfoxClient\SendfoxClient;

abstract class BaseResource
{
    protected SendfoxClient $client;

    public function __construct(SendfoxClient $client)
    {
        $this->client = $client;
    }
}
