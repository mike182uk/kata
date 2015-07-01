<?php

namespace spec\Mdb\Kata\CommandBus;

use PhpSpec\ObjectBehavior;
use Pimple\Container;
use Prophecy\Argument;

class HandlerContainerLocatorSpec extends ObjectBehavior
{
    const COMMAND_HANDLER_CONTAINER_KEY_PREFIX = 'commands.';

    function let(
        Container $container
    ) {
        $this->beConstructedWith(
            $container,
            self::COMMAND_HANDLER_CONTAINER_KEY_PREFIX
        );
    }

    function it_should_be_a_command_handler_locator()
    {
        $this->shouldHaveType('League\Tactician\Handler\Locator\HandlerLocator');
    }

    function it_should_find_a_handler_for_a_command_in_the_container(
        Container $container
    ) {
        $commandName = 'foo';
        $containerKey = self::COMMAND_HANDLER_CONTAINER_KEY_PREFIX  . $commandName;
        $command = new \stdClass();

        $container->offsetGet($containerKey)->willReturn($command);

        $this->getHandlerForCommand($commandName)->shouldReturn($command);
    }
}
