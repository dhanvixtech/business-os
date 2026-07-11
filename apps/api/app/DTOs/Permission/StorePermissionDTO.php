<?php

namespace App\DTOs\Permission;

readonly class StorePermissionDTO
{
    public function __construct(
        public string $name,
        public ?string $guard_name = 'sanctum',
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'],
            guard_name: $data['guard_name'] ?? 'sanctum',
        );
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
