<?php

namespace App\DTOs\Common;

use App\Enums\SortDirection;

class ListQueryDTO
{
    public function __construct(
        public readonly ?string $search = null,
        public readonly ?string $sort = null,
        public readonly SortDirection $direction = SortDirection::ASC,
        public readonly int $perPage = 15,
        public readonly int $page = 1,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            search: $data['search'] ?? null,
            sort: $data['sort'] ?? null,
            direction: isset($data['direction'])
                ? SortDirection::from($data['direction'])
                : SortDirection::ASC,
            perPage: (int) ($data['per_page'] ?? 15),
            page: (int) ($data['page'] ?? 1),
        );
    }
}
