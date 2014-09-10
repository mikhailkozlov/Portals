<?php namespace Sugarcrm\Portals\Services\Validators;

use Illuminate\Validation\Factory,
    Illuminate\Support\MessageBag;

class AbstractValidator implements ValidableInterface
{

    /**
     * Validator
     *
     * @var \Illuminate\Validation\Factory
     */
    protected $validator;

    /**
     * @var \Illuminate\Support\MessageBag
     */
    protected $errors;

    /**
     * Validation data key => value array
     *
     * @var Array
     */
    protected $data = array();

    /**
     * Validation rules
     *
     * @var Array
     */
    protected $rules = array();

    /**
     * Custom error messages
     *
     * @var Array
     */
    protected $messages = array();

    function __construct(Factory $validator, MessageBag $errors)
    {
        $this->validator = $validator;
        $this->errors    = $errors;
    }

    public function with(array $data)
    {
        $this->data = $data;

        return $this;
    }

    public function passes()
    {
        $validator = $this->validator->make($this->data, $this->rules, $this->messages);

        if ($validator->fails()) {
            $this->errors = $validator->messages();
            return false;
        }

        return true;
    }

    public function validForCreate()
    {
        return $this->passes();
    }

    public function validForUpdate()
    {
        return $this->passes();
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function add($key, $message)
    {
        $this->errors->add($key, $message);
        return $this;
    }

    public function getData()
    {
        return $this->data;
    }
}