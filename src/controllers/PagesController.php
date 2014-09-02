<?php

use \Sugarcrm\Portals\Repo\Portal,
    \Sugarcrm\Portals\Repo\Page;

class PagesController extends \BaseController
{
    protected $layout = 'layouts.master';

    protected $portal;
    protected $page;

    public function __construct(Portal $portal, Page $page)
    {
        $this->portal = $portal;
        $this->page   = $page;

        parent::__construct();
    }

    public function show($page)
    {

    }
}