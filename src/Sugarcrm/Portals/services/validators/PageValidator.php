<?php namespace Sugarcrm\Portals\Services\Validators;

class PageValidator extends AbstractValidator
{
    protected $rules = array(
        'title' => 'required',
        'slug' => 'required|unique:pages,slug',
        'content' => 'required',
    );

    public function forUpdate($id)
    {
        $this->rules['slug'] = 'required|unique:pages,slug,' . $id;
        return $this->passes();
    }

}