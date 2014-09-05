<?php

use Sugarcrm\Portals\Repo\Portal,
    Sugarcrm\Portals\Repo\Page,
    Sugarcrm\Portals\Helpers\MenuHelper;

class PagesController extends \BaseController
{
    protected $layout = 'layouts.master';
    protected $portal;
    protected $page;

    public function __construct(Portal $portal, Page $page)
    {
        $this->portal = $portal;
        $this->page   = $page;

        // get all segments
        $segments = \Request::segments();
        // remove last element
        array_pop($segments);
        // find portal
        $this->portal = $portal->where('slug', '=', implode('/', $segments))->first(); //

        if (is_null($this->portal)) {
            return \App::abort('404');
        }

        parent::__construct();
    }

    /**
     *
     * Show page
     *
     * @param $page_slug
     *
     * @return mixed
     */
    public function show($page_slug)
    {
        // find page in the portal
        $page = $this->portal->pages()->where('slug', '=', $page_slug)->first();

        if (is_null($page)) {
            return \App::abort('404');
        }

        // build content
        $this->layout->content = \View::make(
            'portals::page',
            array(
                'portal'     => $this->portal,
                'page'       => $page,
                'portalMenu' => array(),
            )
        );
    }
}