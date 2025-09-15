<?php

declare(strict_types=1);

namespace Knops\SendfoxClient\Models;

class Campaign
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly ?string $subject = null,
        public readonly ?string $status = null,
        public readonly ?array $data = null
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'],
            name: $data['name'],
            subject: $data['subject'] ?? null,
            status: $data['status'] ?? null,
            data: $data
        );
    }

    public function toArray(): array
    {
        return $this->data ?? [
            'id' => $this->id,
            'name' => $this->name,
            'subject' => $this->subject,
            'status' => $this->status,
        ];
    }
}
