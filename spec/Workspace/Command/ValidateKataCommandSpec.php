<?php

namespace spec\Mdb\Kata\Workspace\Command;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ValidateKataCommandSpec extends ObjectBehavior
{
    const KATA = 'foo';

    function let()
    {
        $this->beConstructedWith(self::KATA);
    }

    function it_should_expose_a_kata()
    {
        $this->getKata()->shouldReturn(self::KATA);
    }
}
