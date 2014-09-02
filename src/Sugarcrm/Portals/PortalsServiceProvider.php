<?php namespace Sugarcrm\Portals;

use Illuminate\Support\ServiceProvider,
    Sugarcrm\Portals\Repo\Portal;

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

        /**
         * Register routes
         */
        $portals = Portal::all(array('slug'));

        foreach ($portals as $p) {
            \Route::get($p->slug, 'PortalsController@index'); // You may use get/post
            \Route::get($p->slug . '/{page}', 'PagesController@show'); // You may use get/post
        }
        \Route::get('files/{file}', 'FilesController@get'); // You may use get/post
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array();
    }

}
