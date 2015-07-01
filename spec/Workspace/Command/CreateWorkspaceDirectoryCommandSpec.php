<?php

namespace spec\Mdb\Kata\Workspace\Command;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CreateWorkspaceDirectoryCommandSpec extends ObjectBehavior
{
    const PATH = './';

    function let()
    {
        $this->beConstructedWith(self::PATH);
    }

    function it_should_expose_a_path()
    {
        $this->getPath()->shouldReturn(self::PATH);
    }
}
