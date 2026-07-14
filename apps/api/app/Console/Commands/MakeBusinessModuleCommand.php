<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MakeBusinessModuleCommand extends Command
{
    private int $created = 0;

    private int $skipped = 0;

    protected $signature = 'businessos:make-module
        {name : Module name}
        {--all : Generate complete module}
        {--force : Overwrite existing files}
    ';

    protected $description = 'Generate a complete BusinessOS module';

    public function handle(): int
    {
        $module = Str::studly($this->argument('name'));

        $this->newLine();

        $this->components->info("Generating {$module} module...");


        $this->createDirectories($module);

        if ($this->option('all')) {
            $this->generateAll($module);
        }

        $this->newLine();

        $this->components->twoColumnDetail(
            'Module',
            $module
        );

        $this->components->twoColumnDetail(
            'Status',
            'Completed'
        );

        $this->newLine();

        $this->table(
            ['Result', 'Count'],
            [
                ['Created', $this->created],
                ['Skipped', $this->skipped],
            ]
        );


        $this->components->success(
            "{$module} module generated successfully."
        );

        return self::SUCCESS;
    }

    private function createDirectories(string $module): void
    {
        $directories = [

            $this->generatorPath('action_path') . "/{$module}",

            $this->generatorPath('dto_path') . "/{$module}",

            $this->generatorPath('service_path'),

            $this->generatorPath('repository_path'),

            $this->generatorPath('repository_interface_path'),

            $this->generatorPath('model_path'),

            $this->generatorPath('policy_path'),

            $this->generatorPath('controller_path'),

            $this->generatorPath('request_path') . "/{$module}",

            $this->generatorPath('resource_path'),

            config('businessos.generator.factory_path'),

            config('businessos.generator.seeder_path'),

            config('businessos.generator.test_path') . "/{$module}",

        ];

        foreach ($directories as $directory) {
            File::ensureDirectoryExists(base_path($directory));
        }
    }

    private function generateAll(string $module): void
    {
        $path = fn(string $key): string => $this->generatorPath($key);

        $files = [

            'model.stub'
            => $this->appFile($path('model_path') . "/{$module}.php"),

            'service.stub'
            => $this->appFile($path('service_path') . "/{$module}Service.php"),

            'repository.stub'
            => $this->appFile($path('repository_path') . "/{$module}Repository.php"),

            'repository-interface.stub'
            => $this->appFile($path('repository_interface_path') . "/{$module}RepositoryInterface.php"),

            'controller.stub'
            => $this->appFile($path('controller_path') . "/{$module}Controller.php"),

            'resource.stub'
            => $this->appFile($path('resource_path') . "/{$module}Resource.php"),

            'policy.stub'
            => $this->appFile($path('policy_path') . "/{$module}Policy.php"),

            'store-dto.stub'
            => $this->appFile($path('dto_path') . "/{$module}/Store{$module}DTO.php"),

            'update-dto.stub'
            => $this->appFile($path('dto_path') . "/{$module}/Update{$module}DTO.php"),

            'store-request.stub'
            => $this->appFile($path('request_path') . "/{$module}/Store{$module}Request.php"),

            'list-request.stub'
            => $this->appFile($path('request_path') . "/{$module}/List{$module}Request.php"),

            'update-request.stub'
            => $this->appFile($path('request_path') . "/{$module}/Update{$module}Request.php"),

            'action-get.stub'
            => $this->appFile($path('action_path') . "/{$module}/Get{$module}Action.php"),

            'action-create.stub'
            => $this->appFile($path('action_path') . "/{$module}/Create{$module}Action.php"),

            'action-update.stub'
            => $this->appFile($path('action_path') . "/{$module}/Update{$module}Action.php"),

            'action-delete.stub'
            => $this->appFile($path('action_path') . "/{$module}/Delete{$module}Action.php"),

        ];

        $replacements = $this->replacements($module);

        foreach ($files as $stub => $destination) {
            $this->generateFromStub(
                $stub,
                $destination,
                $replacements
            );
        }
    }

    private function generateFromStub(
        string $stub,
        string $destination,
        array $replacements
    ): void {
        $stubPath = config('businessos.generator.stub_path') . DIRECTORY_SEPARATOR . $stub;

        if (! File::exists($stubPath)) {
            $this->error("Stub {$stub} not found.");

            return;
        }

        $content = File::get($stubPath);

        foreach ($replacements as $search => $replace) {
            $content = str_replace(
                "{{ {$search} }}",
                $replace,
                $content
            );
        }

        if (
            File::exists($destination)
            && ! $this->option('force')
        ) {
            $this->warn(basename($destination) . ' already exists.');

            $this->skipped++;

            return;
        }

        File::put($destination, $content);

        $this->created++;

        $this->components->task(
            basename($destination),
            fn() => true
        );
    }

    private function replacements(string $module): array
    {
        return [

            'module' => $module,

            'moduleVariable' => Str::camel($module),

            'modulePlural' => Str::pluralStudly($module),

            'modulePluralVariable' => Str::camel(Str::pluralStudly($module)),

            'table' => Str::snake(Str::pluralStudly($module)),

            'year' => now()->year,

            'namespace' => config(
                'businessos.generator.namespace'
            ),

            'date' => now()->toDateString(),

            'route' => Str::kebab(Str::pluralStudly($module)),

            'permissionPrefix' => Str::snake($module),

        ];
    }

    private function generatorPath(string $key): string
    {
        return config(
            "businessos.generator.$key"
        ) ?? throw new \RuntimeException(
            "Generator path [$key] missing."
        );
    }

    private function appFile(string $path): string
    {
        return app_path($path);
    }
}
