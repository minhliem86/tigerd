<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ComposerProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('Client::layouts.navigation', 'App\ViewComposers\NavigationComposer');
        view()->composer('Client::layouts.footer', 'App\ViewComposers\SinglePageComposer');
        view()->composer('Client::layouts.testimonial', 'App\ViewComposers\TestimonialComposer');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
