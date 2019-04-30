<?php

return [
    
    'scaffold_path' => storage_path('scaffold'),
    
    'admin_view_namespace' => 'admin',
    
    'admin_route_namespace' => 'admin',
    
    'models_path' => 'app',
    
    'controllers_path' => 'app/Http/Controllers/Admin',
    
    'controller_namespace' => app()->getNamespace() . 'Http\Controllers\Admin',
    
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
    ]

];