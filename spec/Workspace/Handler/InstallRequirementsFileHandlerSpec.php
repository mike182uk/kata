<?php

namespace spec\Mdb\Kata\Workspace\Handler;

use Mdb\Kata\Kata;
use Mdb\Kata\KataRepository;
use Mdb\Kata\Workspace\Handler\InstallRequirementsFileHandler;
use Mdb\Kata\Workspace\Command\InstallRequirementsFileCommand;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Filesystem\Filesystem;

class InstallRequirementsFileHandlerSpec extends ObjectBehavior
{
    function let(
        Filesystem $filesystem,
        KataRepository $kataRepository
    ) {
        $this->beConstructedWith(
            $filesystem,
            $kataRepository
        );
    }

    function it_should_copy_the_requirements_file_into_the_workspace(
        Filesystem $filesystem,
        KataRepository $kataRepository,
        Kata $kata,
        InstallRequirementsFileCommand $command
    ) {
        $kataKey = 'foo';
        $src = './bar';
        $dest = './baz';

        $command->getKata()->willReturn($kataKey);
        $command->getInstallLocation()->willReturn($dest);

        $kataRepository->findOneByKey($kataKey)->willReturn($kata);
        $kata->getRequirementsFilePath()->willReturn($src);

        $filesystem->copy($src, $dest)->shouldBeCalled();

        $this->handle($command);
    }
}
