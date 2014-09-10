<?php namespace Sugarcrm\Portals\Services\Validators;

class PageValidator extends AbstractValidator
{
    protected $rules = array(
        'title' => 'required',
        'slug' => 'required|unique:portals,slug',
        'content' => 'required',
    );
}