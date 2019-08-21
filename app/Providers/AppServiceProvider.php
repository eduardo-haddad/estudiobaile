<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::component('site.components.carousel', 'carousel');
        Blade::component('site.components.notas', 'notas');
        Blade::component('site.components.texto', 'texto');
        Blade::component('site.components.galeria', 'galeria');
        Blade::component('site.components.galeriaMobile', 'galeriaMobile');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
