<?php

namespace App\DTOs\Permission;

readonly class ShowPermissionDTO
{
    public function __construct(
        public int $id,
    ) {}
}
