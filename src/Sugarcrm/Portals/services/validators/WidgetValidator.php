<?php namespace Sugarcrm\Portals\Services\Validators;

class WidgetValidator extends AbstractValidator
{
    protected $rules = array(
      'title'      => 'required',
      'menu_order' => 'required|numeric',
      'content'    => 'required',
    );

    public function forUpdate($id)
    {
        return $this->passes();
    }

}