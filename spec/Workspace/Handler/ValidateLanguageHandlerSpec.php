<?php

namespace spec\Mdb\Kata\Workspace\Handler;

use Mdb\Kata\LanguageRepository;
use Mdb\Kata\Workspace\Command\ValidateLanguageCommand;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ValidateLanguageHandlerSpec extends ObjectBehavior
{
    function let(
        LanguageRepository $languageRepository
    ) {
        $this->beConstructedWith($languageRepository);
    }

    function it_should_validate_a_language(
        LanguageRepository $languageRepository,
        ValidateLanguageCommand $command
    ) {
        $language = 'foo';

        $command->getLanguage()->willReturn('foo');

        $languageRepository->findOneByKey($language)->willReturn(null);

        $this->shouldThrow('InvalidArgumentException')->during('handle', [$command]);
    }
}
