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
        public readonly ?string $ip_address = null,
        public readonly ?string $unsubscribed_at = null,
        public readonly ?string $created_at = null,
        public readonly ?string $updated_at = null,
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
            ip_address: $data['ip_address'] ?? null,
            unsubscribed_at: $data['unsubscribed_at'] ?? null,
            created_at: $data['created_at'] ?? null,
            updated_at: $data['updated_at'] ?? null,
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
            'ip_address' => $this->ip_address,
            'unsubscribed_at' => $this->unsubscribed_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }

    /**
     * Check if the contact is unsubscribed
     */
    public function isUnsubscribed(): bool
    {
        return $this->unsubscribed_at !== null;
    }
}
