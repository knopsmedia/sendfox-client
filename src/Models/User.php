<?php

declare(strict_types=1);

namespace Knops\SendfoxClient\Models;

class User
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly string $email,
        public readonly ?int $contacts_count = null,
        public readonly ?int $contact_limit = null,
        public readonly ?string $created_at = null,
        public readonly ?string $updated_at = null,
        public readonly ?array $data = null
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'],
            name: $data['name'],
            email: $data['email'],
            contacts_count: $data['contacts_count'] ?? null,
            contact_limit: $data['contact_limit'] ?? null,
            created_at: $data['created_at'] ?? null,
            updated_at: $data['updated_at'] ?? null,
            data: $data
        );
    }

    public function toArray(): array
    {
        return $this->data ?? [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'contacts_count' => $this->contacts_count,
            'contact_limit' => $this->contact_limit,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }

    /**
     * Check if the user has reached their contact limit
     */
    public function isAtContactLimit(): bool
    {
        if ($this->contact_limit === null || $this->contacts_count === null) {
            return false;
        }

        return $this->contacts_count >= $this->contact_limit;
    }

    /**
     * Get the percentage of contacts used
     */
    public function getContactUsagePercentage(): float
    {
        if ($this->contact_limit === null || $this->contacts_count === null || $this->contact_limit === 0) {
            return 0.0;
        }

        return ($this->contacts_count / $this->contact_limit) * 100;
    }
}
