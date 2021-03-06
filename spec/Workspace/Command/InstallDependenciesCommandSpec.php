<?php

namespace spec\Mdb\Kata\Workspace\Command;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Console\Output\OutputInterface;

class InstallDependenciesCommandSpec extends ObjectBehavior
{
    const LANGAUGE = 'foo';
    const WORKSPACE_PATH = './bar';

    function let(
        OutputInterface $consoleOutput
    ) {
        $this->beConstructedWith(
            self::LANGAUGE,
            self::WORKSPACE_PATH,
            $consoleOutput
        );
    }

    function it_should_expose_a_language()
    {
        $this->getLanguage()->shouldReturn(self::LANGAUGE);
    }

    function it_should_expose_a_workspace_path()
    {
        $this->getWorkspacePath()->shouldReturn(self::WORKSPACE_PATH);
    }

    function it_should_expose_a_console_output(
        OutputInterface $consoleOutput
    ) {
        $this->getConsoleOutput()->shouldReturn($consoleOutput);
    }
}
