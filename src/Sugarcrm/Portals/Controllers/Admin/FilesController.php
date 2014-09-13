<?php namespace Sugarcrm\Portals\Controllers\Admin;

use Illuminate\Support\MessageBag,
    Sugarcrm\Portals\Services\Validators\FileValidator,
    Sugarcrm\Portals\Controllers\BaseController,
    View,
    Config,
    Input,
    Str,
    Redirect;

class FilesController extends BaseController
{

    protected $file;
    protected $validator;

    public function __construct(\Sugarcrm\Portals\Repo\File $files)
    {
        $app = app();
        $this->files = $files;
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
        $files = $this->files->paginate(15);

        $filemanager = \App::make('flysystem');

        $contents = $filemanager->listContents();
        echo '<pre>'; // MK: delete me
        print_r($contents);
        echo '</pre>';

        $this->layout->content = View::make(
            Config::get('portals::files.admin.index', 'portals::admin.files.index'),
            compact('files')
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
        if (!$this->validator->with($input)->passes()) {
            return false;
        }

        $file = $this->files->create($input);

        return true;
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
            return false;
        }
        $file = $this->files->find($id);
        $file->update($input);

        return true;
    }

}
