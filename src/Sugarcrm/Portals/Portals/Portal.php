<?php namespace Sugarcrm\Portals\Portals;

use Illuminate\Database\Eloquent\Model;

class Portal extends Model implements PortalInterface {

    public function frontPage()
    {
        return $this->hasOne('Sugarcrm\Portals\Repo\Page')->where('id', '=', $this->page_id);
    }

    public function pages()
    {
        return $this->hasMany('Sugarcrm\Portals\Repo\Page');
    }

}
