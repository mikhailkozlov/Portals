<?php namespace Sugarcrm\Portals\Controllers\Admin;

use Doctrine\Common\Annotations\Annotation\Attribute;
use Illuminate\Support\MessageBag,
    Sugarcrm\Portals\Services\Validators\PageValidator,
    Sugarcrm\Portals\Controllers\BaseController,
    Sugarcrm\Portals\Helpers\MenuHelper,
    View,
    Config,
    Input,
    Str,
    Redirect;

class PagesController extends BaseController
{

    protected $portal;
    protected $attribute;
    protected $page;
    protected $validator;

    public function __construct(
        \Sugarcrm\Portals\Repo\Portal $portal,
        \Sugarcrm\Portals\Repo\Page $page,
        \Sugarcrm\Portals\Repo\Attribute $attributes
    ) {
        $app = app();
        $this->portal = $portal;
        $this->page = $page;
        $this->attribute = $attributes;
        $this->validator = new PageValidator($app['validator'], new MessageBag);

        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index($portal_id)
    {
        $pages = $this->portal->find($portal_id)->pages()->paginate(15);

        $this->layout->content = View::make(
            Config::get('portals::pages.admin.index', 'portals::admin.pages.index'),
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
        $parents = $this->page->where('type', '=', Config::get('portals::pages.default'))->lists('title', 'id');

        $this->layout->content = View::make(
            Config::get('portals::pages.admin.create', 'portals::admin.pages.create'),
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
        $input = Input::only('slug', 'title', 'content', 'excerpt', 'parent_id', 'status');
        $input['slug'] = Str::slug($input['slug']);
        if (empty($input['slug'])) {
            $input['slug'] = Str::slug($input['title']);
        }
        $input['user_id'] = $this->user->id;

        if (!$this->validator->with($input)->passes()) {
            return Redirect::back()->withInput()->withErrors($this->validator->getErrors());
        }
        $portal = $this->portal->find($portal_id);

        $page = $portal->pages()->create($input);

        return Redirect::route('admin.pages.edit', array($portal_id, $page->id))->with(
            'success',
            "Page '{$input['title']}' has been saved"
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
        $page = $this->page->find($id);
        $status_opt = Config::get('portals::status_options', array());
        $attributes = Config::get('portals::pages.attributes.' . $page->type, array());

        $types = Config::get('portals::pages.types');
        $parentPages = $this->page->where('type', '=', Config::get('portals::pages.default'))->get();

        $allParents = new MenuHelper($parentPages);
        $parents = array(0 => '- Select -');
        $parents = array_merge($parents, $allParents->makeFlatArray());

        $this->layout->content = View::make(
            Config::get('portals::pages.admin.edit', 'portals::admin.pages.edit'),
            compact('page', 'portal_id', 'types', 'parents', 'status_opt', 'attributes')
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
        $input = Input::only('slug', 'title', 'content', 'excerpt', 'status', 'type', 'parent_id', 'attributes');
        $input['slug'] = Str::slug($input['slug']);
        if (!$this->validator->with($input)->forUpdate($id)) {
            return Redirect::back()->withInput()->withErrors($this->validator->getErrors());
        }
        $page = $this->page->find($id);

        if ($input['parent_id'] == $page->id) {
            unset($input['parent_id']);
        }

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

        return Redirect::route('admin.pages.edit', array($portal_id, $id))->with(
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
