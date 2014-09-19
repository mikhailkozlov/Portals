<?php namespace Sugarcrm\Portals\Controllers;


class FilesController extends BaseController
{
    protected $layout = 'layouts.master';

    protected $file;

    public function __construct(\Sugarcrm\Portals\Repo\File $files)
    {
        $this->file = $files;

        parent::__construct();
    }

    public function get($id)
    {
        $file = $this->file->find($id);

        if (is_null($file)) {
            return Redirect::route('portals.files.download')->with('error', 'File not found.');
        } elseif (!$this->user->inGroup($file->group)) {
            return Redirect::route('portals.files.download')->with('error', 'You have no access for this file.');
        }

        $tmpfname = $this->file->fmReadStream($file);

        // save download
        $file->increment('downloads');

        return Response::download($tmpfname, $file->filename);
    }

}