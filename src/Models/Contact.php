<?php

declare(strict_types=1);

namespace Knops\SendfoxClient\Models;

class Contact
{
    public function __construct(
        public readonly int $id,
        public readonly string $email,
        public readonly ?string $first_name = null,
        public readonly ?string $last_name = null,
        public readonly ?array $data = null
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'],
            email: $data['email'],
            first_name: $data['first_name'] ?? null,
            last_name: $data['last_name'] ?? null,
            data: $data
        );
    }

    public function toArray(): array
    {
        return $this->data ?? [
            'id' => $this->id,
            'email' => $this->email,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
        ];
    }
}
