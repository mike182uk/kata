<?php

namespace Mdb\Kata\Workspace\Handler;

use Mdb\Kata\Workspace\Command\CreateWorkspaceDirectoryCommand;
use Symfony\Component\Filesystem\Filesystem;

class CreateWorkspaceDirectoryHandler
{
    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * @param Filesystem $filesystem
     */
    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    /**
     * @param CreateWorkspaceDirectoryCommand $command
     *
     * @throws \InvalidArgumentException
     */
    public function handle(CreateWorkspaceDirectoryCommand $command)
    {
        $path = $command->getPath();

        if ($this->filesystem->exists($path)) {
            throw new \InvalidArgumentException('The path you have specified already exists. Please specify an alternative workspace path.');
        }

        $this->filesystem->mkdir($path);
    }
}
