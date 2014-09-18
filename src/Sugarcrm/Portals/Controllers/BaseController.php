<?php namespace Sugarcrm\Portals\Controllers;

use Illuminate\Routing\Controller,
    App,
    View,
    Config;

class BaseController extends Controller
{
    public $user = null;

    protected $layout = 'portals::layouts.master';

    public function __construct()
    {
        $sentry = App::make('sentry');
        // probably a good place to get user and some other data we need
        if ($sentry->check()) {
            $this->user = $sentry->getUser();
        }
    }

    /**
     * Setup the layout used by the controller.
     *
     * @return void
     */
    protected function setupLayout()
    {
        $this->layout = Config::get('portals::layouts.master');

        if (!is_null($this->layout)) {
            $this->layout = View::make($this->layout);
        }

        //share user
        View::share('user', $this->user);

        //share the config option to all the views
        View::share('portals', Config::get('cpanel::site_config'));
    }
}