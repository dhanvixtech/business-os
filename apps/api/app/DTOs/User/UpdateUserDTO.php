<?php

namespace App\DTOs\User;

final readonly class UpdateUserDTO
{
    public function __construct(
        public int $id,
        public string $name,
        public string $email,
        public ?string $password,
    ) {}

    public static function fromArray(int $id, array $data): self
    {
        return new self(
            id: $id,
            name: $data['name'],
            email: $data['email'],
            password: $data['password'] ?? null,
        );
    }
}
