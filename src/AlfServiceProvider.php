<?php

namespace z0dd\Alf;

use Illuminate\Support\ServiceProvider;
use App;
use Blade;

/**
 * Class AlfServiceProvider
 *
 * @package z0dd\Alf
 */
class AlfServiceProvider extends ServiceProvider
{
    /**
     * 
     */
    public function boot()
    {
        $this->publishes([__DIR__ . '/../config/' => config_path() . '/']);
    }

    /**
     * 
     */
    public function register()
    {
        App::singleton(Alf::class, function(){
            return new \z0dd\Alf\Alf();
        });
    }
}