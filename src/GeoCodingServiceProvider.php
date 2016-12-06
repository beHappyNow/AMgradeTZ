<?php

namespace AMgradeTZ\GeoCoding;

use Illuminate\Support\ServiceProvider;

class GeoCodingServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->registerGeoCoder();
        $this->app->alias('geocoder', 'AMgradeTZ\GeoCoding\GeoCodingClient');
    }
    public function boot()
    {
        $this->publishes([
            __DIR__.'/config.php' => config_path('geocoder.php'),
        ]);
    }

    /**
     * Register the GeoCoder instance.
     *
     * @return void
     */
    protected function registerGeoCoder()
    {
        $this->app->singleton('geocoder', function ($app) {
            return new GeoCodingClient(config('geocoder.GOOGLE_MAPS_API_KEY'), $app['cache']);
        });
    }
}