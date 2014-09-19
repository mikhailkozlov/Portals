<?php namespace Sugarcrm\Portals\Controllers\Admin;

use Illuminate\Support\MessageBag,
    Sugarcrm\Portals\Services\Validators\FileValidator,
    Sugarcrm\Portals\Controllers\BaseController,
    App,
    View,
    Config,
    Input,
    File,
    Str,
    Redirect,
    Response;

class FilesController extends BaseController
{
    protected $file;
    protected $validator;

    public function __construct(\Sugarcrm\Portals\Repo\File $file)
    {
        $app             = app();
        $this->file      = $file;
        $this->validator = new FileValidator($app['validator'], new MessageBag);
        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $files = $this->file->paginate(15);

        $this->layout->content = View::make(
            Config::get('portals::files.admin.index', 'portals::admin.files.index'),
            compact('files')
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $userGroups = $this->userGroupsList();

        $this->layout->content = View::make(
            Config::get('portals::files.admin.create', 'portals::admin.files.create'),
            compact('userGroups')
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $input      = Input::all(); // have get all to get file
        $input_file = Input::file('file');

        if (!Input::has('title') && $input_file->isValid()) {
            $input['title'] = $input_file->getClientOriginalName();
        }

        if (empty($input['title']) && $input_file->isValid()) {
            $input['title'] = $input_file->getClientOriginalName();
        }

        if (!$this->validator->with($input)->passes()) {
            return Redirect::back()->withInput()->withErrors($this->validator->getErrors());
        }

        $input['filename']  = $input_file->getClientOriginalName();
        $input['extension'] = $input_file->getClientOriginalExtension();
        $input['type']      = $input_file->getMimeType();
        $input['size']      = $input_file->getSize();
        $input['user_id']   = $this->user->getId();

        $file = $this->file->create($input);

        $file->fmWriteStream($input_file);

        return Redirect::route('admin.files.edit', array($file->id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $file       = $this->file->find($id);
        $userGroups = $this->userGroupsList();

        $this->layout->content = View::make(
            Config::get('portals::files.admin.edit', 'portals::admin.files.edit'),
            compact('file', 'userGroups')
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
        $input = Input::only('title', 'description', 'keywords', 'group_id');

        if (!$this->validator->with($input)->passes()) {
            return Redirect::back()->withInput()->withErrors($this->validator->getErrors());
        }

        $file = $this->file->find($id);
        $file->update($input);

        return Redirect::route('admin.files.edit', array($id))->with(
            'success',
            "File information '{$input['title']}' has been saved"
        );
    }

    /**
     * Download file from Storage
     *
     * @param  int $id
     * @return Response
     */
    public function download($id)
    {
        $file = $this->file->find($id);

        if (is_null($file)) {
            return Redirect::route('admin.files.view')->with('error', 'File not found.');
        }

        $tmpfname = $this->file->fmReadStream($file);

        // save download
        $file->increment('downloads');

        return Response::download($tmpfname, $file->filename);
    }

}