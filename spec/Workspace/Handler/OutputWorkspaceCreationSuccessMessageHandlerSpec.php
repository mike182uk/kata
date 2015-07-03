<?php

namespace spec\Mdb\Kata\Workspace\Handler;

use Mdb\Kata\Kata;
use Mdb\Kata\KataRepository;
use Mdb\Kata\Language;
use Mdb\Kata\LanguageRepository;
use Mdb\Kata\Workspace\Command\OutputWorkspaceCreationSuccessMessageCommand;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Console\Output\Output;

class OutputWorkspaceCreationSuccessMessageHandlerSpec extends ObjectBehavior
{
    function let(
        KataRepository $kataRepository,
        LanguageRepository $languageRepository
    ) {
        $this->beConstructedWith(
            $kataRepository,
            $languageRepository
        );
    }

    function it_should_output_details_of_the_newly_created_workspace(
        KataRepository $kataRepository,
        LanguageRepository $languageRepository,
        Output $consoleOutput,
        OutputWorkspaceCreationSuccessMessageCommand $command,
        Kata $kata,
        Language $language
    ) {
        $workspacePath = './foo';
        $kataKey = 'bar';
        $languageKey = 'baz';
        $kataName = 'Bar';
        $languageName = 'Baz';

        $command->getWorkspacePath()->willReturn($workspacePath);
        $command->getKata()->willReturn($kataKey);
        $command->getLanguage()->willReturn($languageKey);
        $command->getConsoleOutput()->willReturn($consoleOutput);

        $kata->getName()->willReturn($kataName);
        $language->getName()->willReturn($languageName);

        $kataRepository->findOneByKey($kataKey)->willReturn($kata);
        $languageRepository->findOneByKey($languageKey)->willReturn($language);

        $consoleOutput->writeln(Argument::that(function($value) use ($workspacePath, $kataName, $languageName) {
            preg_match_all(
                sprintf('#(<comment>%s</comment>|<comment>%s</comment>|<comment>%s</comment>)#', preg_quote($workspacePath), $kataName, $languageName),
                $value,
                $matches
            );

            return count($matches[0]) === 3;
        }))->shouldBeCalled();

        $this->handle($command);
    }
}
