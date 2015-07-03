<?php

namespace Mdb\Kata\Workspace\Command;

use Symfony\Component\Console\Output\OutputInterface;

class OutputMessageCommand
{
    /**
     * @var string
     */
    private $message;

    /**
     * @var OutputInterface
     */
    private $consoleOutput;

    /**
     * @param string          $message
     * @param OutputInterface $consoleOutput
     */
    public function __construct($message, OutputInterface $consoleOutput)
    {
        $this->message = $message;
        $this->consoleOutput = $consoleOutput;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @return OutputInterface
     */
    public function getConsoleOutput()
    {
        return $this->consoleOutput;
    }
}
