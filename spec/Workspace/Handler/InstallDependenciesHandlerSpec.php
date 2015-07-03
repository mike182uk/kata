<?php

namespace spec\Mdb\Kata\Workspace\Handler;

use Mdb\Kata\Language;
use Mdb\Kata\LanguageRepository;
use Mdb\Kata\Workspace\Command\InstallDependenciesCommand;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\ProcessBuilder;

class InstallDependenciesHandlerSpec extends ObjectBehavior
{
    function let(
        LanguageRepository $languageRepository,
        ProcessBuilder $processBuilder
    ) {
        $this->beConstructedWith(
            $languageRepository,
            $processBuilder
        );
    }

    function it_should_run_the_package_manager_install_command(
        LanguageRepository $languageRepository,
        ProcessBuilder $processBuilder,
        Language $language,
        Process $process,
        InstallDependenciesCommand $command
    ) {
        $languageKey = 'foo';
        $packageManagerInstallCommand = 'echo foo';
        $packageManagerInstallCommandArgs = ['echo', 'foo'];
        $workspacePath = './bar';

        $command->getLanguage()->willReturn($languageKey);
        $command->getWorkspacePath()->willReturn($workspacePath);

        $languageRepository->findOneByKey($languageKey)->willReturn($language);

        $language->getPackageManagerInstallCommand()->willReturn($packageManagerInstallCommand);

        $processBuilder->setArguments($packageManagerInstallCommandArgs)->shouldBeCalled();
        $processBuilder->setWorkingDirectory($workspacePath)->shouldBeCalled();

        $processBuilder->getProcess()->willReturn($process);

        $process->run()->shouldBeCalled();

        $this->handle($command);
    }
}
