<?php

namespace Mdb\Kata\CommandBus;

use League\Tactician\Handler\Locator\HandlerLocator;
use Pimple\Container;

class HandlerContainerLocator implements HandlerLocator
{
    /**
     * @var Container
     */
    private $container;

    /**
     * @var string
     */
    private $handlerContainerKeyPrefix;

    /**
     * @param Container $container
     * @param string    $handlerContainerKeyPrefix
     */
    public function __construct(Container $container, $handlerContainerKeyPrefix)
    {
        $this->container = $container;
        $this->handlerContainerKeyPrefix = $handlerContainerKeyPrefix;
    }

    /**
     * {@inheritdoc}
     */
    public function getHandlerForCommand($commandName)
    {
        $containerKey = $this->handlerContainerKeyPrefix.$commandName;

        return $this->container[$containerKey];
    }
}
