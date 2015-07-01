<?php

namespace spec\Mdb\Kata\Workspace\Command;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class InstallRequirementsFileCommandSpec extends ObjectBehavior
{
    const KATA = 'foo';
    const INSTALL_LOCATION = './baz/foo';

    function let()
    {
        $this->beConstructedWith(
            self::KATA,
            self::INSTALL_LOCATION
        );
    }

    function it_should_expose_a_kata()
    {
        $this->getKata()->shouldReturn(self::KATA);
    }

    function it_should_expose_an_install_location()
    {
        $this->getInstallLocation()->shouldReturn(self::INSTALL_LOCATION);
    }
}
