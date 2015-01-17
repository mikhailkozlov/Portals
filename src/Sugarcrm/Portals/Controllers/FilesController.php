<?php namespace Sugarcrm\Portals\Controllers;

use App,
    Response;

class FilesController extends BaseController
{
    protected $layout = 'layouts.master';

    protected $file;

    public function __construct(\Sugarcrm\Portals\Repo\File $files)
    {
        $this->file = $files;

        parent::__construct();
    }

    public function get($id, $name)
    {
        $file = $this->file->find($id);

        if (is_null($file)) {
            return App::abort(404)->with('error', 'File not found.');
        } elseif (!$this->user->inGroup($file->group)) {
            return App::abort(403)->with('error', 'You have no access for this file.');
        }

        $tmpfname = $this->file->fmReadStream($file);

        // save download
        $file->increment('downloads');

        return Response::download($tmpfname, $file->filename);
    }
}