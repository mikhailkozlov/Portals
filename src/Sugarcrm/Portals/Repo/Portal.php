<?php namespace Sugarcrm\Portals\Repo;

use Illuminate\Database\Eloquent\Model,
    Illuminate\Support\Str;

class Portal extends Model
{

    protected $fillable = array('slug', 'title', 'keywords', 'description', 'status', 'user_id', 'page_id');

    // alias for page
    public function frontPage()
    {
        return $this->hasOne('Sugarcrm\Portals\Repo\Page');
    }

    public function pages()
    {
        return $this->hasMany('Sugarcrm\Portals\Repo\Page');
    }

    public function widgets()
    {
        return $this->hasMany('Sugarcrm\Portals\Repo\Widget')->where('type', 'widget');
    }

    public function setSlugAttribute($value)
    {
        $slugs = explode('/', trim($value, '/'));
        foreach ($slugs as $i => $s) {
            $slugs[$i] = Str::slug($s);
        }
        $this->attributes['slug'] = implode('/', $slugs);

    }

    public function attributes()
    {
        return $this->morphMany('Sugarcrm\Portals\Repo\Attribute', 'parent');
    }
}