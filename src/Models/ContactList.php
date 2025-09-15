<?php

declare(strict_types=1);

namespace Knops\SendfoxClient\Models;

class ContactList
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly ?array $data = null
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'],
            name: $data['name'],
            data: $data
        );
    }

    public function toArray(): array
    {
        return $this->data ?? [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }
}
