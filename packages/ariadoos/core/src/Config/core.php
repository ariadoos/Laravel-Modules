<?php

return [

    'package' => [
        'name' => 'Modules',
        'path' => base_path('App/Modules'),
        'namespace' => 'App\\Modules',
    ],

    'vendor' => [
        'name' => null,
        'path' => null,
        'namespace' => null,
    ],

    'moduleRootFolder' => [],

    'stubFiles' => [
        'api.stub' => 'Routes',  // stub name => folder name
        'web.stub' => 'Routes',
        'model.stub' => 'Models',
    ],

    'folders' => [
        'Http' => ['parent' => null, 'generate' => true],
        'Controllers' => ['parent' => 'Http', 'generate' => true],
        'Models' => ['parent' => null, 'generate' => true],
        'Requests' => ['parent' => 'Http', 'generate' => true],
        'Routes' => ['parent' => null, 'generate' => true],
        'Services' => ['parent' => null, 'generate' => true],
        'Providers' => ['parent' => null, 'generate' => true],
        'Repository' => ['parent' => null, 'generate' => true],
        'Eloquent' => ['parent' => 'Repository', 'generate' => true],
        'Interfaces' => ['parent' => 'Repository', 'generate' => true],
        'Api' => ['parent' => 'Http/Controllers', 'generate' => true],
        'Web' => ['parent' => 'Http/Controllers', 'generate' => true],
        'Resources' => ['parent' => 'Http' , 'generate' => true],
    ]
];
