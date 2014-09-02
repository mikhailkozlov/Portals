<?php namespace Sugarcrm\Portals\Repo;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    public function portal()
    {
        return $this->hasOne('Sugarcrm\Portals\Repo\Portal');
    }

}