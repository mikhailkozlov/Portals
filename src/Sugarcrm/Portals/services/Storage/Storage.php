<?php namespace Sugarcrm\Portals\Services\Storage;

// @TODO we need to figureout how to allow for multiple storage interfaces

use Illuminate\Config\Repository;
use Aws\S3\S3Client;
use League\Flysystem\Filesystem;
use League\Flysystem\Adapter\AwsS3 as Adapter;

class Storage
{
    protected $config;
    protected $driver;

    public function __construct(Repository $config)
    {
        $this->config = $config;
        $this->selectDriver($this->config->get('portals::filesystem.default'));
    }

    public function selectDriver($conf = 'local')
    {
        switch ($conf) {
            case 's3':
                $this->setupAws();
            case 'local':
                $this->setupLocal();
        }
        return $this;

    }

    public function getDriver()
    {
        return $this->driver;
    }

    public function setupAws()
    {
        $client       = S3Client::factory(
            array(
                'key'    => $this->config->get('portals::filesystem.s3.key'),
                'secret' => $this->config->get('portals::filesystem.s3.secret'),
                'scheme' => 'http'
            )
        );
        $this->driver = new Filesystem(new Adapter($client, $this->config->get(
            'portals::filesystem.s3.bucket'
        ), $this->config->get(
            'portals::filesystem.s3.prefix'
        )));

        return $this;
    }

    public function setupLocal()
    {
//        $this->driver = new Filesystem(new Adapter(__DIR__ . '/' . $this->config->get('portals::filesystem.s3.path')));

        return $this;
    }

} 