<?php

namespace spec\Mdb\Kata\Workspace\Command;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class InstallLanguageTemplatesCommandSpec extends ObjectBehavior
{
    const LANGUAGE = 'foo';
    const WORKSPACE_PATH = 'baz';

    function let()
    {
        $this->beConstructedWith(
            self::LANGUAGE,
            self::WORKSPACE_PATH
        );
    }

    function it_should_expose_a_language()
    {
        $this->getLanguage()->shouldReturn(self::LANGUAGE);
    }

    function it_should_expose_a_workspace_path()
    {
        $this->getWorkspacePath()->shouldReturn(self::WORKSPACE_PATH);
    }
}
