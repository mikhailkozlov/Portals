<?php namespace Sugarcrm\Portals\Controllers;

use Illuminate\Routing\Controller,
  App,
  View,
  Config;

class BaseController extends Controller
{
    protected $user   = null;
    protected $auth;
    protected $layout = 'portals::layouts.master';
    public    $portal;

    public function __construct()
    {
        $this->auth = App::make('sentry');
        // probably a good place to get user and some other data we need
        if ($this->auth->check()) {
            $this->user = $this->auth->getUser();
        }
    }

    /**
     * Setup the layout used by the controller.
     *
     * @return void
     */
    protected function setupLayout()
    {
        if (!is_null($this->layout)) {
            $tpl = Config::get('portals::layouts.master', $this->layout);
            $this->layout = View::make($tpl);
        }

        //share user
        View::share('user', $this->user);

        //share the config option to all the views
        View::share('portals', Config::get('cpanel::site_config'));
    }

    protected function userGroupsList()
    {
        return $this->auth->getGroupProvider()
          ->createModel()
          ->lists('name', 'id');
    }
}