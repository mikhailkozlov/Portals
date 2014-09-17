<?php namespace Sugarcrm\Portals\Services\Validators;

class FileValidator extends AbstractValidator
{
    protected $rules = array(
        'title' => 'required',
        'file'  => 'required|max:10000',
    );
}