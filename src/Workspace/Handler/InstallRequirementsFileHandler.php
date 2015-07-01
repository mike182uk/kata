<?php

namespace Mdb\Kata\Workspace\Handler;

use Mdb\Kata\KataRepository;
use Mdb\Kata\Workspace\Command\InstallRequirementsFileCommand;
use Symfony\Component\Filesystem\Filesystem;

class InstallRequirementsFileHandler
{
    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * @var KataRepository
     */
    private $kataRepository;

    /**
     * @param Filesystem     $filesystem
     * @param KataRepository $kataRepository
     */
    public function __construct(
        Filesystem $filesystem,
        KataRepository $kataRepository
    ) {
        $this->filesystem = $filesystem;
        $this->kataRepository = $kataRepository;
    }

    /**
     * @param InstallRequirementsFileCommand $command
     */
    public function handle(InstallRequirementsFileCommand $command)
    {
        $kata = $this->kataRepository->findOneByKey($command->getKata());

        $this->filesystem->copy(
            $kata->getRequirementsFilePath(),
            $command->getInstallLocation()
        );
    }
}
