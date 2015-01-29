<?php namespace Sugarcrm\Portals\Repo;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = array('slug', 'title', 'content', 'excerpt', 'status', 'user_id', 'portal_id',  'parent_id', 'type');

    public function portal()
    {
        return $this->belongsTo('Sugarcrm\Portals\Repo\Portal');
    }

    public function attributes()
    {
        return $this->morphMany('Sugarcrm\Portals\Repo\Attribute', 'parent');
    }

}