<?php

namespace Mdb\Kata\Workspace\Handler;

use Mdb\Kata\Workspace\Command\OutputMessageCommand;

class OutputMessageHandler
{
    /**
     * @param OutputMessageCommand $command
     */
    public function handle(OutputMessageCommand $command)
    {
        $consoleOutput = $command->getConsoleOutput();

        $consoleOutput->writeln($command->getMessage());
    }
}
