<?php

namespace App\DTOs\Common;

class ListQueryDTO
{
    public function __construct(
        public readonly ?string $search = null,
        public readonly ?string $sort = null,
        public readonly string $direction = 'asc',
        public readonly int $perPage = 15,
        public readonly int $page = 1,
    ) {}
}
