<?php

declare(strict_types=1);

namespace Knops\SendfoxClient\Models;

class Automation
{
    public function __construct(
        public readonly int $id,
        public readonly int $user_id,
        public readonly string $title,
        public readonly ?string $created_at = null,
        public readonly ?string $updated_at = null,
        public readonly ?array $data = null
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'],
            user_id: $data['user_id'],
            title: $data['title'],
            created_at: $data['created_at'] ?? null,
            updated_at: $data['updated_at'] ?? null,
            data: $data
        );
    }

    public function toArray(): array
    {
        return $this->data ?? [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'title' => $this->title,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
