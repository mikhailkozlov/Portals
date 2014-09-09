<?php namespace Sugarcrm\Portals\Services\Validators;

class PortalValidator extends Validator
{
    public static $rules = array(
        'title' => 'required',
        'slug' => 'required',
        'description' => 'required',
    );
}