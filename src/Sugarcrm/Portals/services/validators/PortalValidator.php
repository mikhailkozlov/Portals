<?php namespace Sugarcrm\Portals\Services\Validators;

class PortalValidator extends AbstractValidator
{
    protected $rules = array(
        'title'       => 'required',
        'slug'        => 'required|unique:portals,slug',
        'description' => 'required',
    );
}