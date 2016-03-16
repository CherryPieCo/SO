<?php 

namespace Yaro\OAuth;


class ServiceProvider extends \Illuminate\Support\ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;
    
    public function boot()
    {
        include_once __DIR__ .'/Http/routes.php';
        
        $this->publishes([
            __DIR__ . '/../config/config.php' => config_path('yaro.oauth.php'),
        ], 'config');
        $this->publishes([
            __DIR__ . '/../public' => public_path('packages/yaro/oauth'),
        ], 'public');
    } // end boot

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/config.php', 'yaro.oauth.php');

        $this->app['yaro_oauth'] = $this->app->share(function($app) {
            return new OAuth();
        });
    } // end register

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array();
    } // end provides

}
