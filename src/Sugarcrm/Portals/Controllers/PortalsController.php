<?php namespace Sugarcrm\Portals\Controllers;

use Sugarcrm\Portals\Helpers\MenuHelper,
  Sugarcrm\Portals\Repo\Portal;

class PortalsController extends BaseController
{

    public function __construct(Portal $portal)
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
    public function index($slug = null)
    {
        if (is_null($slug)) {
            $slug = \Request::path();
        }

        $portal = $this->portal->where('slug', '=', $slug)->first();

        if (!$portal) {
            return \App::abort('404');
        }
        $menu = array();

        $widgets = $portal->widgets()
          ->where('status', 'published')
          ->orderBy('menu_order')
          ->get();

        if ($portal->page_id > 0) {
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
                'widgets'    => $widgets,
              )
            );
        } else {

            $blogPosts = $portal->pages()
              ->with('attributes')
              ->whereType('blog')
              ->whereStatus('published')
              ->orderBy('created_at', 'DESC')
              ->paginate(10);


            $this->layout->content = \View::make(
              \Config::get('portals::layouts.portals.blog',
                'portals::index_blog'),
              array(
                'portal'     => $portal,
                'pages'      => $blogPosts,
                'portalMenu' => $menu,
                'widgets'    => $widgets,
              )
            );
        }
    }
}