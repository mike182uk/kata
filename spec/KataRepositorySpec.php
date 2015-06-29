<?php

namespace spec\Mdb\Kata;

use Mdb\Kata\Kata;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class KataRepositorySpec extends ObjectBehavior
{
    function let(
        Kata $fooKata,
        Kata $barKata
    ){
        $fooKata->getKey()->willReturn('foo');
        $barKata->getKey()->willReturn('bar');

        $this->insert($fooKata);
        $this->insert($barKata);
    }

    function it_should_retrieve_all_katas_from_the_repository(
        Kata $fooKata,
        Kata $barKata
    ){
        $this->findAll()->shouldReturn([$fooKata, $barKata]);
    }

    function it_should_retrieve_a_kata_by_its_key(
        Kata $fooKata
    ){
        $this->findOneByKey('foo')->shouldReturn($fooKata);
    }

    function it_should_retrieve_a_kata_randomly()
    {
        $this->findOneByRandom()->shouldHaveType('Mdb\Kata\Kata');
    }

    function it_should_empty_the_repository()
    {
        $this->clear();

        $this->findAll()->shouldReturn([]);
    }
}
