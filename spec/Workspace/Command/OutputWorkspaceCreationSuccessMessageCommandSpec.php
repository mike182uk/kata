<?php

namespace spec\Mdb\Kata\Workspace\Command;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Console\Output\OutputInterface;

class OutputWorkspaceCreationSuccessMessageCommandSpec extends ObjectBehavior
{
    const WORKSPACE_PATH = './foo';
    const KATA = 'bar';
    const LANGUAGE = 'baz';

    function let(
        OutputInterface $consoleOutput
    ) {
        $this->beConstructedWith(
            self::WORKSPACE_PATH,
            self::KATA,
            self::LANGUAGE,
            $consoleOutput
        );
    }

    function it_should_expose_a_workspace_path()
    {
        $this->getWorkspacePath()->shouldReturn(self::WORKSPACE_PATH);
    }

    function it_should_expose_a_kata()
    {
        $this->getKata()->shouldReturn(self::KATA);
    }

    function it_should_expose_a_language()
    {
        $this->getLanguage()->shouldReturn(self::LANGUAGE);
    }

    function it_should_expose_a_console_output(
        OutputInterface $consoleOutput
    ) {
        $this->getConsoleOutput()->shouldReturn($consoleOutput);
    }
}
