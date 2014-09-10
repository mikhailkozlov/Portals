<?php namespace Sugarcrm\Portals\Repo;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = array('slug', 'title', 'content', 'excerpt', 'status', 'user_id', 'page_id');

    public function portal()
    {
        return $this->hasOne('Sugarcrm\Portals\Repo\Portal');
    }

}