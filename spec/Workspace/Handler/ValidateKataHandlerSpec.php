<?php

namespace spec\Mdb\Kata\Workspace\Handler;

use Mdb\Kata\KataRepository;
use Mdb\Kata\Workspace\Command\ValidateKataCommand;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ValidateKataHandlerSpec extends ObjectBehavior
{
    function let(
        KataRepository $kataRepository
    ) {
        $this->beConstructedWith($kataRepository);
    }

    function it_should_validate_a_kata(
        KataRepository $kataRepository,
        ValidateKataCommand $command
    ) {
        $kata = 'foo';

        $command->getKata()->willReturn('foo');

        $kataRepository->findOneByKey($kata)->willReturn(null);

        $this->shouldThrow('InvalidArgumentException')->during('handle', [$command]);
    }
}
