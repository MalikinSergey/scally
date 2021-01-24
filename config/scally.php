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
    
    'models_path' => 'app',
    
    'controllers_path' => 'app/Http/Controllers/Dashboard',
    
    'controller_namespace' => app()->getNamespace() . 'Http\Controllers\Dashboard',
    
    'model_namespace' => app()->getNamespace(),
    
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
        
        'integer' => [
            'name' => 'Integer',
            'blueprint' => 'integer',
        
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
