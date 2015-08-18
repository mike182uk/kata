<?php

namespace Mdb\Kata\Workspace\Command;

use Symfony\Component\Console\Output\OutputInterface;

class InstallDependenciesCommand
{
    /**
     * @var string
     */
    private $language;

    /**
     * @var string
     */
    private $workspacePath;

    /**
     * @param string          $lanuage
     * @param string          $workspacePath
     * @param OutputInterface $consoleOutput
     */
    public function __construct($lanuage, $workspacePath, OutputInterface $consoleOutput)
    {
        $this->language = $lanuage;
        $this->workspacePath = $workspacePath;
        $this->consoleOutput = $consoleOutput;
    }

    /**
     * @return string
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * @return string
     */
    public function getWorkspacePath()
    {
        return $this->workspacePath;
    }

    /**
     * @return OutputInterface
     */
    public function getConsoleOutput()
    {
        return $this->consoleOutput;
    }
}
