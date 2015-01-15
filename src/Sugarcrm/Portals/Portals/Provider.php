<?php namespace Sugarcrm\Portals\Portals;

class Provider implements ProviderInterface
{

    protected $validator;
    protected $portals;

    public function __construct(ValidableInterface $validator, PortalInterface $portals)
    {
        $this->validator = $validator;
        $this->portals   = $portals;

    }

    public function frontPage()
    {
        return $this->portals->frontPage();
    }

    public function allPages()
    {
        return $this->portals->pages();
    }

    public function create(array $data)
    {
        try {
            if ($this->validator->with($data)->passes()) {
                $this->portals->create($data);
                return true;
            }
        } catch (PortalExistsException $e) {
            $this->validator->add('PortalExistsException', $e->getMessage());
        } catch (NameRequiredException $e) {
            $this->validator->add('NameRequiredException', $e->getMessage());
        }

        return false;
    }

    public function update(array $data)
    {
        try {
            if ($this->validator->with($data)->validForUpdate()) {
                $this->portals->update($data);
                return true;
            }
        } catch (PortalExistsException $e) {
            $this->validator->add('PortalExistsException', $e->getMessage());
        } catch (NameRequiredException $e) {
            $this->validator->add('NameRequiredException', $e->getMessage());
        }

        return false;
    }

    public function getErrors()
    {
        return $this->validator->errors();
    }

}
