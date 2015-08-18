<?php

namespace Mdb\Kata\Workspace\Handler;

use Mdb\Kata\LanguageRepository;
use Mdb\Kata\Workspace\Command\InstallDependenciesCommand;
use Symfony\Component\Process\ProcessBuilder;

class InstallDependenciesHandler
{
    /**
     * @var LanguageRepository
     */
    private $languageRepository;

    /**
     * @var ProcessBuilder
     */
    private $processBuilder;

    /**
     * @param LanguageRepository $languageRepository
     * @param ProcessBuilder     $processBuilder
     */
    public function __construct(
        LanguageRepository $languageRepository,
        ProcessBuilder $processBuilder
    ) {
        $this->languageRepository = $languageRepository;
        $this->processBuilder = $processBuilder;
    }

    /**
     * @param InstallDependenciesCommand $command
     */
    public function handle(InstallDependenciesCommand $command)
    {
        $consoleOuput = $command->getConsoleOutput();
        $language = $this->languageRepository->findOneByKey($command->getLanguage());

        $packageManagerInstallCommand = $language->getPackageManagerInstallCommand();
        $packageManagerInstallCommandArgs = explode(' ', $packageManagerInstallCommand);

        $this->processBuilder->setArguments($packageManagerInstallCommandArgs);
        $this->processBuilder->setWorkingDirectory($command->getWorkspacePath());

        $process = $this->processBuilder->getProcess();

        $process->run(function ($type, $buffer) use ($consoleOuput) {
            $consoleOuput->write('<comment>[Package Manager] > </comment>'.trim($buffer), true);
        });
    }
}
