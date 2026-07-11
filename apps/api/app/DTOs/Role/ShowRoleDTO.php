<?php

namespace App\DTOs\Role;

readonly class ShowRoleDTO
{
    public function __construct(
        public int $id,
    ) {}
}
