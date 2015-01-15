<?php namespace Sugarcrm\Portals\Controllers\Admin;

use Illuminate\Routing\Controller,
    Sugarcrm\Portals\Controllers\BaseController,
    App,
    View,
    Config;

class BaseAdminController extends BaseController
{
    protected $layout = 'portals::layouts.admin.master';

    /**
     * Setup the layout used by the controller.
     *
     * @return void
     */
    protected function setupLayout()
    {
        if (!is_null($this->layout)) {
            $tpl = Config::get('portals::layouts.admin.master', $this->layout);
            $this->layout = View::make($tpl);
        }

        //share user
        View::share('user', $this->user);

        //share the config option to all the views
        View::share('portals', Config::get('cpanel::site_config'));
    }

}