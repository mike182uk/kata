<?php

namespace spec\Mdb\Kata;

use Mdb\Kata\Language;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class LanguageRepositorySpec extends ObjectBehavior
{
    function let(
        Language $fooLanguage,
        Language $barLanguage
    ) {
        $fooLanguage->getKey()->willReturn('foo');
        $barLanguage->getKey()->willReturn('bar');

        $this->insert($fooLanguage);
        $this->insert($barLanguage);
    }

    function it_should_be_a_repository()
    {
        $this->shouldHaveType('Mdb\Kata\Repository');
    }

    function it_should_throw_an_exception_when_trying_to_insert_anything_other_than_a_language()
    {
        $this->shouldThrow('InvalidArgumentException')->during('insert', [new \stdClass()]);
    }

    function it_should_retrieve_all_languages_from_the_repository(
        Language $fooLanguage,
        Language $barLanguage
    ) {
        $this->findAll()->shouldReturn([$fooLanguage, $barLanguage]);
    }

    function it_should_retrieve_a_language_by_its_key(
        Language $fooLanguage
    ) {
        $this->findOneByKey('foo')->shouldReturn($fooLanguage);
    }

    function it_should_retrieve_a_language_randomly()
    {
        $this->findOneByRandom()->shouldHaveType('Mdb\Kata\Language');
    }

    function it_should_empty_the_repository()
    {
        $this->clear();

        $this->findAll()->shouldReturn([]);
    }
}
