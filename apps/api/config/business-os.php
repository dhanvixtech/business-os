<?php

return [

    'pagination' => [
        'default_per_page' => 15,
        'max_per_page' => 100,
    ],

    'roles' => [
        'default_registration_role' => 'Customer',
        'default_admin_created_role' => 'Employee',
    ],

    'generator' => [

        'namespace' => 'App',

        'controller_path' => 'Http/Controllers/Api/V1',

        'request_path' => 'Http/Requests',

        'resource_path' => 'Http/Resources',

        'service_path' => 'Services',

        'repository_path' => 'Repositories/Eloquent',

        'repository_interface_path' => 'Repositories/Contracts',

        'action_path' => 'Actions',

        'dto_path' => 'DTOs',

        'policy_path' => 'Policies',

        'model_path' => 'Models',

        'test_path' => 'tests/Feature',

        'factory_path' => 'database/factories',

        'seeder_path' => 'database/seeders',

        'stub_path' => base_path('stubs/businessos'),
    ],

];
