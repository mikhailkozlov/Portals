<?php namespace Sugarcrm\Portals\Services\Validators;

class FileValidator extends AbstractValidator
{
    protected $rules = array(
        'title' => 'required',
        'description' => 'required',
    );
}