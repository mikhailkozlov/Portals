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

    public function get($file)
    {
        return 'Downloading file';
    }

}