<?php namespace Admin;

use \Sugarcrm\Portals\Services\Validators\PortalValidator;

class PortalsController extends \BaseController
{

    protected $layout = 'layouts.master';

    protected $portal;

    public function __construct(\Sugarcrm\Portals\Repo\Portal $portal)
    {
        $this->portal = $portal;

        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $portals = $this->portal->paginate(15);

        $this->layout->content = \View::make(
            \Config::get('portals.admin.index', 'portals::admin.portals.index'),
            compact('portals')
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $portal = $this->portal;
        $portal->status_opt = array('draft' => 'draft', 'published' => 'published');

        $this->layout->content = \View::make(
            \Config::get('portals.admin.edit', 'portals::admin.portals.edit'),
            compact('portal')
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $input = \Input::all();
        $validation = new PortalValidator($input);
        if (!$validation->passes()) {
            return \Redirect::back()->withInput()->withErrors($validation->getErrors());
        }

        $fields = array(
            'id' => $id,
            'slug' => $input['slug'],
            'title' => $input['title'],
            'keywords' => $input['keywords'],
            'description' => $input['description'],
            'status' => $input['status'],
        );
        $this->portal->save($fields);

        return \Redirect::route('admin.portals.edit', array($id))->with('success', "Portal `{$input['title']}` has been saved");
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $portal = $this->portal->find($id);
        $portal->status_opt = array('draft' => 'draft', 'published' => 'published');

        $this->layout->content = \View::make(
            \Config::get('portals.admin.edit', 'portals::admin.portals.edit'),
            compact('portal')
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id)
    {
        $input = \Input::all();
        $validation = new PortalValidator($input);
        if (!$validation->passes()) {
            return \Redirect::back()->withInput()->withErrors($validation->getErrors());
        }

        $fields = array(
            'id' => $id,
            'slug' => $input['slug'],
            'title' => $input['title'],
            'keywords' => $input['keywords'],
            'description' => $input['description'],
            'status' => $input['status'],
        );
        $this->portal->save($fields);

        return \Redirect::route('admin.portals.edit', array($id))->with('success', "Portal `{$input['title']}` has been saved");

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

}
