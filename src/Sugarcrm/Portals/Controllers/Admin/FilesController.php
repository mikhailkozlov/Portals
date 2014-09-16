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

    protected $auth;
    protected $file;
    protected $validator;

    public function __construct(\Sugarcrm\Portals\Repo\File $file, \Cartalyst\Sentry\Sentry $auth)
    {
        $app               = app();
        $this->auth        = $auth;
        $this->file        = $file;
        $this->validator   = new FileValidator($app['validator'], new MessageBag);
        $this->filemanager = App::make('flysystem');
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
        // @TODO add goups
        //$allGroups = $this->auth->getGroupProvider()->findAll();

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
        $input      = Input::only('title', 'description', 'keywords');
        $input_file = Input::file('file');

        if (!$this->validator->with(Input::all())->passes()) {
            return Redirect::back()->withInput()->withErrors($this->validator->getErrors());
        }
        // TODO - we probably need to move all that into File model and let it deal with it
        // upload file
        $stream = fopen($input_file->getPathname(), 'r+');
        $this->filemanager->writeStream(
            $input_file->getClientOriginalName(),
            $stream,
            array(
                'visibility' => 'private',
                'mimetype'   => $input_file->getMimeType(),
            )
        );

        $input['filename']    = $input_file->getClientOriginalName();
        $input['extension']   = $input_file->getClientOriginalExtension();
        $input['type']        = $input_file->getMimeType();
        $input['size']        = $input_file->getSize();
        $input['user_id']     = 0; //@TODO  - add current user, I think $this->auth->getUser()->getId();
        $input['permissions'] = 'admin'; // @TODO - we probably need to store Group ID here or create another column to do that.

        $file = $this->file->create($input);

        return Redirect::route('admin.files.edit', array($file->id));
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
        $file = $this->file->find($id);

        //@TODO - add ability to change group

        $this->layout->content = View::make(
            Config::get('portals::files.admin.edit', 'portals::admin.files.edit'),
            compact('file')
        );
    }

    /**
     * Download file from Storage
     *
     * @param  int $id
     *
     * @return Response
     */
    public function download($id)
    {
        $file = $this->file->find($id);

        if (is_null($file)) {
            return Redirect::route('admin.files.view')->with('error', 'File not found.');
        }

        if (!$this->filemanager->has($file->filename)) {
            return Redirect::route('admin.files.view')->with('error', $file->filename . ' not found on the hard drive');
        }

        // TODO - we probably need to move all that into File model and let it deal with it
        // Retrieve a read-stream
        $tmpfname = tempnam("/tmp", $file->filename);
        $stream   = $this->filemanager->readStream($file->filename);
        $contents = stream_get_contents($stream);
        $handle   = fopen($tmpfname, "w");
        fwrite($handle, $contents);
        fclose($handle);

        // save download
        $file->increment('downloads');

        return Response::download($tmpfname, $file->filename);
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
