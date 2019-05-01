<?php

namespace Mlsg\Scally;

use Illuminate\Support\ServiceProvider;

class MlsgScallyServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/scally.php', 'scally'
        );
        
        $this->publishes([
            __DIR__.'/../config/scally.php' => config_path('scally.php'),
        ]);
    
        $this->loadRoutesFrom(__DIR__.'/web.php');
    
    }
    
    public function register()
    {
    
    }
    
}