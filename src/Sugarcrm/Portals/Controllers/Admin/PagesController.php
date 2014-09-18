<?php namespace Sugarcrm\Portals\Controllers\Admin;

use Illuminate\Support\MessageBag,
    Sugarcrm\Portals\Services\Validators\PageValidator,
    Sugarcrm\Portals\Controllers\BaseController,
    View,
    Config,
    Input,
    Str,
    Redirect;

class PagesController extends BaseController
{

    protected $portal;
    protected $page;
    protected $validator;

    public function __construct(\Sugarcrm\Portals\Repo\Portal $portal, \Sugarcrm\Portals\Repo\Page $page)
    {
        $app             = app();
        $this->portal    = $portal;
        $this->page      = $page;
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

        $this->layout->content = View::make(
            Config::get('portals::pages.admin.create', 'portals::admin.pages.create'),
            compact('status_opt', 'portal_id')
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store($portal_id)
    {
        $input = Input::only('slug', 'title', 'content', 'excerpt', 'status');
        $input['slug'] = Str::slug($input['slug']);
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
        $page       = $this->page->find($id);
        $status_opt = Config::get('portals::status_options', array());

        $this->layout->content = View::make(
            Config::get('portals::pages.admin.edit', 'portals::admin.pages.edit'),
            compact('page', 'status_opt')
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
        $input = Input::only('slug', 'title', 'content', 'excerpt', 'status');
        $input['slug'] = Str::slug($input['slug']);
        if (!$this->validator->with($input)->forUpdate($id)) {
            return Redirect::back()->withInput()->withErrors($this->validator->getErrors());
        }
        $page = $this->page->find($id);
        $page->update($input);

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
