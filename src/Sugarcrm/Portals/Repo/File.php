<?php namespace Sugarcrm\Portals\Repo;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $fillable = array('user_id', 'title', 'description', 'keywords', 'filename', 'extension', 'type', 'size');
}