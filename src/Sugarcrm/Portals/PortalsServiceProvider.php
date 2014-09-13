<?php namespace Sugarcrm\Portals;

use Illuminate\Support\ServiceProvider,
    Sugarcrm\Portals\Repo\Portal,
    Sugarcrm\Portals\Services\Storage\Storage;

class PortalsServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->package('sugarcrm/portals');

        include __DIR__ . '/../../routes.php';

        /**
         * Register routes
         */
        $portals = Portal::all(array('slug'));

        // insert routes into app
        foreach ($portals as $p) {
            // @TODO  - add routes and make sure we enforce permissions
            \Route::get($p->slug, 'Sugarcrm\Portals\Controllers\PortalsController@index'); // You may use get/post
            \Route::get(
                $p->slug . '/{page_slug}',
                'Sugarcrm\Portals\Controllers\PagesController@show'
            ); // You may use get/post
        }
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerFlysystem();
    }

    public function registerFlysystem()
    {
        $app = $this->app;

        $app->singleton(
            'flysystem',
            function ($app) {
                $drvr = new Storage($app['config']);
                return $drvr->getDriver();
            }
        );
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array('portals');
    }

}
