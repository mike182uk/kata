<?php

namespace Mdb\Kata\Workspace\Command;

use Symfony\Component\Console\Output\OutputInterface;

class OutputWorkspaceCreationSuccessMessageCommand
{
    /**
     * @var string
     */
    private $workspacePath;

    /**
     * @var string
     */
    private $kata;

    /**
     * @var string
     */
    private $language;

    /**
     * @var OutputInterface
     */
    private $consoleOutput;

    /**
     * @param string          $workspacePath
     * @param string          $kata
     * @param string          $language
     * @param OutputInterface $consoleOutput
     */
    public function __construct($workspacePath, $kata, $language, OutputInterface $consoleOutput)
    {
        $this->workspacePath = $workspacePath;
        $this->kata = $kata;
        $this->language = $language;
        $this->consoleOutput = $consoleOutput;
    }

    /**
     * @return string
     */
    public function getWorkspacePath()
    {
        return $this->workspacePath;
    }

    /**
     * @return string
     */
    public function getKata()
    {
        return $this->kata;
    }

    /**
     * @return string
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * @return OutputInterface
     */
    public function getConsoleOutput()
    {
        return $this->consoleOutput;
    }
}
