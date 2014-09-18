<?php namespace Sugarcrm\Portals\Services\Validators;

class PortalValidator extends AbstractValidator
{
    protected $rules = array(
        'title'       => 'required',
        'slug'        => 'required|unique:portals,slug',
        'description' => 'required',
    );

    public function forUpdate($id)
    {
        $this->rules['slug'] = 'required|unique:portals,slug,' . $id;
        return $this->passes();
    }

}