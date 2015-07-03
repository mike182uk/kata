<?php

namespace spec\Mdb\Kata\Workspace\Handler;

use Mdb\Kata\Workspace\Command\OutputMessageCommand;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Console\Output\Output;

class OutputMessageHandlerSpec extends ObjectBehavior
{
    function it_should_output_a_message(
        Output $consoleOutput,
        OutputMessageCommand $command
    ) {
        $message = 'foo';

        $command->getMessage()->willReturn($message);
        $command->getConsoleOutput()->willReturn($consoleOutput);

        $consoleOutput->writeln($message)->shouldBeCalled();

        $this->handle($command);
    }
}
