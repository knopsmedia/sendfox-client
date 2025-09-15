<?php

declare(strict_types=1);

namespace Knops\SendfoxClient\Models;

class Form
{
    public function __construct(
        public readonly int $id,
        public readonly string $title,
        public readonly ?int $landing_page_id = null,
        public readonly ?string $created_at = null,
        public readonly ?string $updated_at = null,
        public readonly ?array $data = null
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'],
            title: $data['title'],
            landing_page_id: $data['landing_page_id'] ?? null,
            created_at: $data['created_at'] ?? null,
            updated_at: $data['updated_at'] ?? null,
            data: $data
        );
    }

    public function toArray(): array
    {
        return $this->data ?? [
            'id' => $this->id,
            'title' => $this->title,
            'landing_page_id' => $this->landing_page_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
