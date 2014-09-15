<?php namespace Sugarcrm\Portals\Controllers\Admin;

use Illuminate\Support\MessageBag,
    Sugarcrm\Portals\Services\Validators\FileValidator,
    Sugarcrm\Portals\Controllers\BaseController,
    View,
    Config,
    Input,
    File,
    Str,
    Redirect;

class FilesController extends BaseController
{

    protected $file;
    protected $validator;

    public function __construct(\Sugarcrm\Portals\Repo\File $file)
    {
        $app = app();
        $this->file = $file;
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

        $filemanager = \App::make('flysystem');
        //        $contents = $filemanager->listContents();
        //        echo '<pre>'; // MK: delete me
        //        print_r($contents);
        //        echo '</pre>';

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
        $this->layout->content = View::make(
            Config::get('portals::files.admin.create', 'portals::admin.files.create'),
            compact('')
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $input = Input::only('title', 'description', 'keywords');
        $input_file = Input::file('file');

        if (!$this->validator->with($input)->passes()) {
            return Redirect::back()->withInput()->withErrors($this->validator->getErrors());
        }

        $input['filename'] = $input_file->getClientOriginalName();
        $input['extension'] = $input_file->getClientOriginalExtension();
        $input['type'] = $input_file->getMimeType();
        $input['size'] = $input_file->getSize();

        $file = $this->file->create($input);

        return Redirect::route('admin.files.view');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $file = $this->file->find($id);

        $this->layout->content = View::make(
            Config::get('portals::files.admin.edit', 'portals::admin.files.edit'),
            compact('file')
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
        $input = Input::only('title', 'description', 'keywords');
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

}
