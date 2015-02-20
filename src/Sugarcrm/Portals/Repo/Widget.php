<?php namespace Sugarcrm\Portals\Repo;

class Widget extends Page
{

    protected $table = 'pages';

    protected $fillable = array(
      'slug',
      'title',
      'content',
      'excerpt',
      'status',
      'user_id',
      'portal_id',
      'parent_id',
      'menu_order',
      'type'
    );

    public function portal()
    {
        return $this->belongsTo('Sugarcrm\Portals\Repo\Portal');
    }

    public function attributes()
    {
        return $this->morphMany('Sugarcrm\Portals\Repo\Attribute', 'parent');
    }

    public function published()
    {
        $this->where('status', 'published')->orderBy('menu_order');

        return $this;
    }
}