<?php

namespace spec\Mdb\Kata\Workspace\Handler;


use Mdb\Kata\Workspace\Command\CreateWorkspaceDirectoryCommand;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Filesystem\Filesystem;

class CreateWorkspaceDirectoryHandlerSpec extends ObjectBehavior
{
    function let(
        Filesystem $filesystem
    ) {
        $this->beConstructedWith($filesystem);
    }

    function it_should_create_the_workspace_at_the_specified_path(
        Filesystem $filesystem,
        CreateWorkspaceDirectoryCommand $command
    ) {
        $path = './foo';

        $command->getPath()->willReturn($path);
        $filesystem->exists($path)->willReturn(false);

        $filesystem->mkdir($path)->shouldBeCalled();

        $this->handle($command);
    }

    function it_should_throw_an_exception_if_the_specified_path_already_exists(
        Filesystem $filesystem,
        CreateWorkspaceDirectoryCommand $command
    ) {
        $path = './foo';

        $command->getPath()->willReturn($path);

        $filesystem->exists($path)->willReturn(true);

        $this->shouldThrow('InvalidArgumentException')->during('handle', [$command]);
    }
}
