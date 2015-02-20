<?php namespace Sugarcrm\Portals\Controllers\Admin;

use Illuminate\Support\MessageBag,
  Sugarcrm\Portals\Services\Validators\WidgetValidator,
  Sugarcrm\Portals\Helpers\MenuHelper,
  View,
  Config,
  Input,
  Str,
  Redirect;

class WidgetsController extends BaseAdminController
{

    protected $attribute;
    protected $page;
    protected $validator;

    public function __construct(
      \Sugarcrm\Portals\Repo\Portal $portal,
      \Sugarcrm\Portals\Repo\Widget $page,
      \Sugarcrm\Portals\Repo\Attribute $attributes
    ) {
        $app = app();
        $this->portal = $portal;
        $this->page = $page;
        $this->attribute = $attributes;
        $this->validator = new WidgetValidator($app['validator'],
          new MessageBag);

        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index($portal_id)
    {
        $pages = $this->portal
          ->find($portal_id)
          ->widgets()
          ->orderBy('menu_order')
          ->paginate(15);

        $this->layout->content = View::make(
          Config::get('portals::pages.admin.index',
            'portals::admin.widgets.index'),
          compact('pages', 'portal_id')
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create($portal_id)
    {
        $status_opt = Config::get('portals::status_options');
        $types = Config::get('portals::pages.types');
        $parents = $this->page->where('type', '=',
          Config::get('portals::pages.default'))->lists('title', 'id');

        $this->layout->content = View::make(
          Config::get('portals::pages.admin.create',
            'portals::admin.widgets.create'),
          compact('status_opt', 'portal_id', 'types', 'parents')
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store($portal_id)
    {
        $input = Input::only('title', 'content', 'status', 'menu_order');

        $input['type'] = 'widget';
        $input['user_id'] = $this->user->id;
        $input['slug'] = 'widget_' . Str::slug($input['title']) . '_' . $input['menu_order'];


        if (!$this->validator->with($input)->passes()) {
            return Redirect::back()
              ->withInput()
              ->withErrors($this->validator->getErrors());
        }
        $portal = $this->portal->find($portal_id);

        $page = $portal->pages()->create($input);

        return Redirect::route('admin.widgets.edit',
          array($portal_id, $page->id))->with(
          'success',
          "Widget '{$input['title']}' has been saved"
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($portal_id, $id)
    {
        $page = $this->page->with('portal')->find($id);

        $status_opt = Config::get('portals::status_options', array());
        $attributes = Config::get('portals::pages.attributes.' . $page->type,
          array());

        $types = Config::get('portals::pages.types');
        $parentPages = $this->page->where('type', '=',
          Config::get('portals::pages.default'))->get();

        $allParents = new MenuHelper($parentPages);
        $parents = array(0 => '- Select -');
        $parents = array_merge($parents, $allParents->makeFlatArray());

        $this->layout->content = View::make(
          Config::get('portals::pages.admin.edit',
            'portals::admin.widgets.edit'),
          compact('page', 'portal_id', 'types', 'parents', 'status_opt',
            'attributes')
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function update($portal_id, $id)
    {
        $input = Input::only('title', 'content', 'status', 'menu_order');
        $input['slug'] = 'widget_' . Str::slug($input['title']) . '_' . $input['menu_order'];
        if (!$this->validator->with($input)->forUpdate($id)) {
            return Redirect::back()
              ->withInput()
              ->withErrors($this->validator->getErrors());
        }
        $page = $this->page->find($id);

        $page->update($input);

        if (Input::has('attributes')) {
            // remove all
            $page->attributes()->delete();
            foreach ($input['attributes'] as $key => $val) {
                $page->attributes()->create(
                  array(
                    'title' => $key,
                    'value' => $val
                  )
                );
            }
        }

        // $page->attributes()->create();

        return Redirect::route('admin.widgets.edit', array($portal_id, $id))
          ->with(
            'success',
            "Page '{$input['title']}' has been saved"
          );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

}
