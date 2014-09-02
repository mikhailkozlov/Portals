<?php


class PortalsController extends \BaseController
{
    protected $layout = 'layouts.master';

    protected $portal;

    public function __construct(\Sugarcrm\Portals\Repo\Portal $portal)
    {
        $this->portal = $portal;

        parent::__construct();
    }

    public function index()
    {
        $portal = $this->portal->where('slug','=',\Request::path())->first();

        if(!$portal){
            return \App::abort('404');
        }
        $menu = array();
        if($portal->page_id > 0){
            $portal->frontPage;
            if(!is_null($portal->frontPage)){
                $portal->title = $portal->frontPage->title;
            }
        }
        $this->layout->content = \View::make(
            \Config::get('portals::portals.views.index', 'portals::index'),
            array(
                'portal'     => $portal,
                'page'       => $portal->frontPage,
                'portalMenu' => $menu,
            )
        );
    }

//    public function getPage($portal_slug, $page_slug)
//    {
//        $portal = Portal::where('slug','=',$portal_slug)->first();
//
//        $page = $portal->pages()->where('slug','=',$page_slug)->first();
//
//        $pages = $portal->pages()->select('id', 'title', 'parent_id', 'slug')->get();
//        $menu  = new \MenuHelper($pages,'internal/'.$portal->slug.'/');
//        $menu  = $menu->itemArray();
//
//
//        $this->layout->content = \View::make('internal.page',
//            array(
//                'portal'     => $portal,
//                'page'       => $page,
//                'portalMenu' => $menu,
//            )
//        );
//    }
}