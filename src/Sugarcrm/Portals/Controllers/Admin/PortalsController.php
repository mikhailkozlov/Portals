<?php namespace Sugarcrm\Portals\Controllers\Admin;

use Illuminate\Support\MessageBag,
    Sugarcrm\Portals\Services\Validators\PortalValidator,
    Sugarcrm\Portals\Controllers\BaseController,
    View,
    Config,
    Input,
    Redirect;

class PortalsController extends BaseController
{

    protected $portal;
    protected $validator;

    public function __construct(\Sugarcrm\Portals\Repo\Portal $portal)
    {
        $app             = app();
        $this->portal    = $portal;
        $this->validator = new PortalValidator($app['validator'], new MessageBag);

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

        $this->layout->content = View::make(
            Config::get('portals::portals.admin.index', 'portals::admin.portals.index'),
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
        $status_opt = Config::get('portals::portals.status_options');

        $this->layout->content = View::make(
            Config::get('portals::portals.admin.create', 'portals::admin.portals.create'),
            compact('status_opt')
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $input = Input::only('slug', 'title', 'keywords', 'description', 'status');
        if (!$this->validator->with($input)->passes()) {
            return Redirect::back()->withInput()->withErrors($this->validator->getErrors());
        }

        $portal = $this->portal->create($input);

        return Redirect::route('admin.portals.edit', array($portal->id))->with(
            'success',
            "Portal '{$input['title']}' has been saved"
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
    public function edit($id)
    {
        $portal     = $this->portal->find($id);
        $status_opt = Config::get('portals::portals.status_options');

        $this->layout->content = View::make(
            Config::get('portals::portals.admin.edit', 'portals::admin.portals.edit'),
            compact('portal', 'status_opt')
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function update($id)
    {
        $input = Input::only('slug', 'title', 'keywords', 'description', 'status');
        if (!$this->validator->with($input)->passes()) {
            return Redirect::back()->withInput()->withErrors($this->validator->getErrors());
        }
        $portal = $this->portal->find($id);
        $portal->update($input);

        return Redirect::route('admin.portals.edit', array($id))->with(
            'success',
            "Portal '{$input['title']}' has been saved"
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
