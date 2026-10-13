<?php

namespace App\Providers;

use App;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        if (App::isProduction()) {
            URL::forceScheme('https');
        }
        //Model::shouldBeStrict(!$this->app->isProduction());
    }
}
