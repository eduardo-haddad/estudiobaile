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
        Blade::component('site.components.carouselAgenda', 'carouselAgenda');
        Blade::component('site.components.fichaTecnica', 'fichaTecnica');
        Blade::component('site.components.assuntos', 'assuntos');
        Blade::component('site.components.dataELocal', 'dataELocal');
        Blade::component('site.components.parceiros', 'parceiros');
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
