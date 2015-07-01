<?php

namespace spec\Mdb\Kata\Workspace\Command;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ValidateLanguageCommandSpec extends ObjectBehavior
{
    const LANGUAGE = 'foo';

    function let()
    {
        $this->beConstructedWith(self::LANGUAGE);
    }

    function it_should_expose_a_language()
    {
        $this->getLanguage()->shouldReturn(self::LANGUAGE);
    }
}
