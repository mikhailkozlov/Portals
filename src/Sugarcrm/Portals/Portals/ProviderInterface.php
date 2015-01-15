<?php namespace Sugarcrm\Portals\Portals;

interface ProviderInterface
{

    public function create(array $data);

    public function update(array $data);

    public function getErrors();

}
