<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HealthResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'application' => $this->application,
            'version' => $this->version,
            'environment' => $this->environment,
            'php_version' => $this->phpVersion,
            'laravel_version' => $this->laravelVersion,
            'database' => $this->database,
            'cache' => $this->cache,
            'storage' => $this->storage,
            'queue' => $this->queue,
            'timestamp' => $this->timestamp,
        ];
    }
}
