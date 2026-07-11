<?php

namespace App\DTOs\Role;

readonly class SyncRolePermissionsDTO
{
    public function __construct(
        public array $permissions,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            permissions: $data['permissions'],
        );
    }
}
