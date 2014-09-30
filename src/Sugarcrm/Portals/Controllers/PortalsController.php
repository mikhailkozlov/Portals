<?php namespace Sugarcrm\Portals\Controllers;

use Sugarcrm\Portals\Helpers\MenuHelper;

class PortalsController extends BaseController
{
    protected $layout = 'layouts.master';

    protected $portal;

    public function __construct(\Sugarcrm\Portals\Repo\Portal $portal)
    {
        $this->portal = $portal;

        parent::__construct();
    }

    /**
     *
     * Display portal index
     *
     * @return mixed
     */
    public function index()
    {
        $portal = $this->portal->where('slug','=',\Request::path())->first();

        if(!$portal){
            return \App::abort('404');
        }
        $menu = array();
        if($portal->page_id > 0) {
            $portal->frontPage;
            if (!is_null($portal->frontPage)) {
                $portal->title = $portal->frontPage->title;
            }
            $this->layout->content = \View::make(
                \Config::get('portals::portals.views.index', 'portals::index'),
                array(
                    'portal'     => $portal,
                    'page'       => $portal->frontPage,
                    'portalMenu' => $menu,
                )
            );
        }else{
            $this->layout->content = \View::make(
                \Config::get('portals::portals.views.blog', 'portals::index_blog'),
                array(
                    'portal'     => $portal,
                    'pages'      => $portal->pages()->whereType('blog')->whereStatus('published')->paginate(10),
                    'portalMenu' => $menu,
                )
            );
        }
    }
}