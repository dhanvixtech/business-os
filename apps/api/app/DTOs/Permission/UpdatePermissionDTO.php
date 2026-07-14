<?php

namespace App\DTOs\Permission;

readonly class UpdatePermissionDTO
{
    public function __construct(
        public int $id,
        public string $name,
        public ?string $guard_name = 'sanctum',
    ) {}

    public static function fromArray(int $id, array $data): self
    {
        return new self(
            id: $id,
            name: $data['name'],
            guard_name: $data['guard_name'] ?? 'sanctum',
        );
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
