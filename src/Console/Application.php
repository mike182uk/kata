<?php

namespace Mdb\Kata\Console;

use Pimple\Container;
use Symfony\Component\Console\Application as BaseApplication;

class Application extends BaseApplication
{
    /**
     * @var Container
     */
    private $container;

    /**
     * {@inheritdoc}
     */
    public function __construct()
    {
        $this->container = new Container();

        $containerAssembler = new ContainerAssembler();
        $containerAssembler->assemble($this->container);

        parent::__construct('kata', '0.0.1');
    }

    /**
     * @return Container
     */
    public function getContainer()
    {
        return $this->container;
    }

    public function discoverCommands()
    {
        foreach ($this->container->keys() as $key) {
            if (strpos($key, 'console.command.') === 0) {
                $this->add($this->container[$key]);
            }
        }
    }
}
