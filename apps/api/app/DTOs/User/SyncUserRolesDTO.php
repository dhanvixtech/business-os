<?php

namespace App\DTOs\User;

readonly class SyncUserRolesDTO
{
    public function __construct(
        public array $roles,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            roles: $data['roles'],
        );
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
