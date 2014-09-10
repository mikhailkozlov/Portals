<?php namespace Sugarcrm\Portals\Controllers;

use Illuminate\Routing\Controller,
    View,
    Config;

class BaseController extends Controller
{

    public $assets;

    public $user = null;

    protected $layout = 'layouts.master';

    public function __construct()
    {
        // probably a good place to get user and some other data we need
    }

    /**
     * Setup the layout used by the controller.
     *
     * @return void
     */
    protected function setupLayout()
    {
        if (!is_null($this->layout)) {
            $this->layout = View::make($this->layout);
        }

        //share the config option to all the views
        View::share('cpanel', Config::get('cpanel::site_config'));

        //share the assets
        View::share('assets', $this->assets);
    }
}