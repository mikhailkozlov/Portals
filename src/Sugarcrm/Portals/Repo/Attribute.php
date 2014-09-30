<?php namespace Sugarcrm\Portals\Repo;

use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{

    protected $fillable = array(
        'parent_id',
        'parent_type',
        'title',
        'value'
    );

    public function __toString()
    {
        return $this->value;
    }

}