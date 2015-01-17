<?php namespace Sugarcrm\Portals\Controllers\Admin;

use Illuminate\Support\MessageBag,
    Sugarcrm\Portals\Services\Validators\FileValidator,
    App,
    View,
    Config,
    Input,
    File,
    Str,
    Redirect,
    Response;

class FilesController extends BaseAdminController
{
    protected $file;
    protected $validator;
    protected $volumeId = 'l1_';

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
        $input = Input::all(); // have get all to get file
        if (empty($input)) {
            return Redirect::back()->withInput()->withErrors('Looks like file is too big for the server to handle. Please try to resize.');
        }
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

        $input['filename'] = $input_file->getClientOriginalName();
        $input['extension'] = $input_file->getClientOriginalExtension();
        $input['type'] = $input_file->getMimeType();
        $input['size'] = $input_file->getSize();
        $input['user_id'] = $this->user->getId();

        $file = $this->file->create($input);

        $file->fmWriteStream($input_file);

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
     *
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
     *
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


    public function manager()
    {
        $now = \Carbon\Carbon::now();
        $files = $this->file->all();

        $tree = array(
            "cwd"        => array(
                "mime"     => "directory",
                "ts"       => $now->timestamp,
                "read"     => 1,
                "write"    => 1,
                "size"     => 0,
                "hash"     => "l1_Lw",
                "volumeid" => "l1_",
                "name"     => "files",
                "date"     => $now->toDateTimeString(),
                "locked"   => 1
            ),
            "options"    => array(
                "path"          => "",
                "url"           => "/",
                "tmbUrl"        => "/",
                "disabled"      => array(),
                "separator"     => "/",
                "copyOverwrite" => 1
            ),
            "files"      => array(
                array(
                    "mime"     => "directory",
                    "ts"       => $now->timestamp,
                    "read"     => 1,
                    "write"    => 0,
                    "size"     => 0,
                    "hash"     => "l1_Lw",
                    "volumeid" => $this->volumeId,
                    "name"     => "files",
                    "date"     => $now->toDateTimeString(),
                    "locked"   => 1
                )
            ),
            "api"        => "2.0",
            "uplMaxSize" => "2M"
        );


        foreach ($files as $file) {
            $tree['files'][] = array(
                'hash'  => $this->encode(\URL::route('portals.files.download', array($file->id, $file->filename))),
                'mime'  => $file->type,
                'name'  => \URL::route('portals.files.download', array($file->id, $file->filename), false),
                'phash' => "l1_Lw",
                'read'  => 1,
                'size'  => $file->size,
                'ts'    => $file->created_at->timestamp,
                'write' => 0,
            );

        }


        return Response::json($tree);
    }

    protected function encode($path)
    {
        if ($path !== '') {

            // cut ROOT from $path for security reason, even if hacker decodes the path he will not know the root
            $p = $path;
            // if reqesting root dir $path will be empty, then assign '/' as we cannot leave it blank for crypt
            if ($p === '') {
                $p = DIRECTORY_SEPARATOR;
            }

            // TODO crypt path and return hash
            $hash = $p;
            // hash is used as id in HTML that means it must contain vaild chars
            // make base64 html safe and append prefix in begining
            $hash = strtr(base64_encode($hash), '+/=', '-_.');
            // remove dots '.' at the end, before it was '=' in base64
            $hash = rtrim($hash, '.');

            // append volume id to make hash unique
            return $this->volumeId . $hash;
        }
    }

}