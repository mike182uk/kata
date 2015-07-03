<?php

namespace spec\Mdb\Kata\Workspace\Command;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Console\Output\OutputInterface;

class OutputMessageCommandSpec extends ObjectBehavior
{
    const MESSAGE = 'foo';

    function let(
        OutputInterface $consoleOutput
    ) {
        $this->beConstructedWith(
            self::MESSAGE,
            $consoleOutput
        );
    }

    function it_should_expose_a_message()
    {
        $this->getMessage()->shouldReturn(self::MESSAGE);
    }

    function it_should_expose_a_console_output(
        OutputInterface $consoleOutput
    ) {
        $this->getConsoleOutput()->shouldReturn($consoleOutput);
    }
}
