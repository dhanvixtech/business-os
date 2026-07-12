<?php

namespace App\Actions\Health;

use App\DTOs\Responses\HealthDTO;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class GetHealthAction
{
    public function execute(): HealthDTO
    {
        return new HealthDTO(
            application: config('app.name'),
            version: config('app.version', '0.6.1'),
            environment: app()->environment(),
            phpVersion: PHP_VERSION,
            laravelVersion: app()->version(),
            database: $this->database(),
            cache: $this->cache(),
            storage: $this->storage(),
            queue: $this->queue(),
            timestamp: now()->toIso8601String(),
        );
    }

    private function database(): string
    {
        try {
            DB::connection()->getPdo();

            return 'UP';
        } catch (\Throwable) {
            return 'DOWN';
        }
    }

    private function cache(): string
    {
        try {
            Cache::put('health_check', true, 5);

            return Cache::get('health_check')
                ? 'UP'
                : 'DOWN';
        } catch (\Throwable) {
            return 'DOWN';
        }
    }

    private function storage(): string
    {
        return File::isWritable(storage_path())
            ? 'UP'
            : 'DOWN';
    }

    private function queue(): string
    {
        try {
            Artisan::call('queue:failed');

            return 'UP';
        } catch (\Throwable) {
            return 'DOWN';
        }
    }
}
