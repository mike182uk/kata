<?php

namespace spec\Mdb\Kata\CommandBus;

use Mdb\Kata\Kata;
use Mdb\Kata\Workspace\Command\ValidateKataCommand;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ClassNameWithoutSuffixExtractorSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('Command');
    }

    function it_should_be_a_command_name_extractor()
    {
        $this->shouldHaveType('League\Tactician\Handler\CommandNameExtractor\CommandNameExtractor');
    }

    function it_should_return_the_class_name_only()
    {
        $fqn = new Kata('foo', 'bar', 'baz');

        $this->extract($fqn)->shouldReturn('Kata');
    }

    function it_should_return_the_class_name_without_suffix()
    {
        $fqn = new ValidateKataCommand('foo');

        $this->extract($fqn)->shouldReturn('ValidateKata');
    }
}
