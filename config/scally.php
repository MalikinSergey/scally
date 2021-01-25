<?php

return [

    /*
     * If 'stubs_path' is null, default stubs, included in package, will be used.
     * Use php artisan vendor:publish --tag=scally_stubs to publish stubs to resources directory and customize them.
     */

    'stubs_path' => null,

    /*
     * Scaffold path must be writeable for webserver.
     */

    'scaffold_path' => storage_path('scaffold'),

    'admin_view_namespace' => 'dashboard',

    'admin_route_namespace' => 'dashboard',

    'models_path' => 'app/Models',

    'controllers_path' => 'app/Http/Controllers/Dashboard',

    'controller_namespace' => app()->getNamespace() . 'Http\Controllers\Dashboard',

    'model_namespace' => app()->getNamespace() . 'Models',

    'locale' => app()->getLocale(),

    'attribute_types' => [

        'string' => [
            'name' => 'String',
            'blueprint' => 'string',

        ],

        'text' => [
            'name' => 'Text',
            'blueprint' => 'text',

        ],

        'unsigned_integer' => [
            'name' => 'Unsigned Int',
            'blueprint' => 'unsignedInteger',

        ],

        'integer' => [
            'name' => 'Int',
            'blueprint' => 'integer',

        ],

        'unsigned_big_integer' => [
            'name' => 'Unsigned BigInt',
            'blueprint' => 'unsignedBigInteger',

        ],

        'big_integer' => [
            'name' => 'BigInt',
            'blueprint' => 'bigInteger',

        ],

        'unsigned_decimal' => [
            'name' => 'Unsigned Decimal',
            'blueprint' => 'unsignedDecimal',

        ],

        'decimal' => [
            'name' => 'Decimal',
            'blueprint' => 'decimal',
        ],

        'variants' => [
            'name' => 'Variants (in DB: string)',
            'blueprint' => 'string',
        ],

        'jsonb' => [
            'name' => 'JSONB',
            'blueprint' => 'jsonb',
        ],
    ]

];
