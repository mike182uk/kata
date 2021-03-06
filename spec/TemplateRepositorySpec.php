<?php

namespace spec\Mdb\Kata;

use Mdb\Kata\Template;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class TemplateRepositorySpec extends ObjectBehavior
{
    function let(
        Template $fooTemplate,
        Template $barTemplate,
        Template $bazTemplate
    ) {
        $fooTemplate->getLanguage()->willReturn('foo');
        $barTemplate->getLanguage()->willReturn('foo');
        $bazTemplate->getLanguage()->willReturn('bar');

        $this->insert($fooTemplate);
        $this->insert($barTemplate);
        $this->insert($bazTemplate);
    }

    function it_should_be_a_repository()
    {
        $this->shouldHaveType('Mdb\Kata\Repository');
    }

    function it_should_throw_an_exception_when_trying_to_insert_anything_other_than_a_template()
    {
        $this->shouldThrow('InvalidArgumentException')->during('insert', [new \stdClass()]);
    }

    function it_should_retrieve_all_templates_from_the_repository(
        Template $fooTemplate,
        Template $barTemplate,
        Template $bazTemplate
    ) {
        $this->findAll()->shouldReturn([$fooTemplate, $barTemplate, $bazTemplate]);
    }

    function it_should_empty_the_repository()
    {
        $this->clear();

        $this->findAll()->shouldReturn([]);
    }

    function it_should_retrieve_all_templates_for_a_language(
        Template $fooTemplate,
        Template $barTemplate
    ) {
        $this->findAllByLanguage('foo')->shouldReturn([$fooTemplate, $barTemplate]);
    }
}
