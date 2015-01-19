<?php namespace Sugarcrm\Portals;

use Aws\CloudFront\Exception\Exception;
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
        include __DIR__ . '/../../helpers.php';

        /**
         * Register routes
         *
         * This whole section needs to be moved so it does not get boostrapped on CLI
         *
         */
        try {
            $portals = Portal::all(array('slug'));

            // insert routes into app
            foreach ($portals as $p) {
                // @TODO  - add routes and make sure we enforce permissions
                \Route::get($p->slug,
                    array(
                        'as'     => 'public.' . $p->slug . '.index',
                        'uses'   => 'Sugarcrm\Portals\Controllers\PortalsController@index',
                        'before' => 'portals.auth' // you should be able to use that even to control access.
                    )); // You may use get/post
                \Route::get(
                    $p->slug . '/{page_slug}',
                    array(
                        'as'     => 'public.' . $p->slug . '.index',
                        'uses'   => 'Sugarcrm\Portals\Controllers\PagesController@show',
                        'before' => 'portals.auth'// you should be able to use that even to control access.
                    )); // You may use get/post
            }
        }catch (\Exception $e){
            // skip
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
