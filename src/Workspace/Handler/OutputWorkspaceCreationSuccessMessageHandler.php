<?php

namespace Mdb\Kata\Workspace\Handler;

use Mdb\Kata\KataRepository;
use Mdb\Kata\LanguageRepository;
use Mdb\Kata\Workspace\Command\OutputWorkspaceCreationSuccessMessageCommand;

class OutputWorkspaceCreationSuccessMessageHandler
{
    /**
     * @var KataRepository
     */
    private $kataRepository;

    /**
     * @var LanguageRepository
     */
    private $languageRepository;

    /**
     * @param KataRepository     $kataRepository
     * @param LanguageRepository $languageRepository
     */
    public function __construct(KataRepository $kataRepository, LanguageRepository $languageRepository)
    {
        $this->kataRepository = $kataRepository;
        $this->languageRepository = $languageRepository;
    }

    /**
     * @param OutputWorkspaceCreationSuccessMessageCommand $command
     */
    public function handle(OutputWorkspaceCreationSuccessMessageCommand $command)
    {
        $consoleOutput = $command->getConsoleOutput();

        $consoleOutput->writeln(
            $this->getMessage(
                $command->getWorkspacePath(),
                $command->getKata(),
                $command->getLanguage()
            )
        );
    }

    /**
     * @param string $workspacePath
     * @param string $kata
     * @param string $language
     *
     * @return string
     */
    private function getMessage($workspacePath, $kata, $language)
    {
        $kata = $this->kataRepository->findOneByKey($kata)->getName();
        $language = $this->languageRepository->findOneByKey($language)->getName();

        return sprintf(
            '<info>Kata workspace successfully created at <comment>%s</comment> with the kata <comment>%s</comment> using the language <comment>%s</comment></info>',
            $workspacePath,
            $kata,
            $language
        );
    }
}
