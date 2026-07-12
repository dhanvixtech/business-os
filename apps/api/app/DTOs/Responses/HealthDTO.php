<?php

namespace App\DTOs\Responses;

class HealthDTO
{
    public function __construct(
        public readonly string $application,
        public readonly string $version,
        public readonly string $environment,
        public readonly string $phpVersion,
        public readonly string $laravelVersion,
        public readonly string $database,
        public readonly string $cache,
        public readonly string $storage,
        public readonly string $queue,
        public readonly string $timestamp,
    ) {}
}
