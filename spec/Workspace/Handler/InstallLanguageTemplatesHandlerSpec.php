<?php

namespace spec\Mdb\Kata\Workspace\Handler;

use Mdb\Kata\Template;
use Mdb\Kata\TemplateRepository;
use Mdb\Kata\Workspace\Command\InstallLanguageTemplatesCommand;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Filesystem\Filesystem;

class InstallLanguageTemplatesHandlerSpec extends ObjectBehavior
{
    const LANGUAGE = 'foo';
    const RESOURCES_PATH = './bar/';
    const WORKSPACE_PATH = './baz/';

    function let(
        Filesystem $filesystem,
        TemplateRepository $templateRepository
    ) {
        $this->beConstructedWith(
            $filesystem,
            $templateRepository
        );
    }

    function it_should_copy_the_language_templates_into_the_workspace(
        Filesystem $filesystem,
        InstallLanguageTemplatesCommand $command,
        TemplateRepository $templateRepository,
        Template $template1,
        Template $template2
    ) {
        $command->getLanguage()->willReturn(self::LANGUAGE);
        $command->getWorkspacePath()->willReturn(self::WORKSPACE_PATH);

        $template1Src = 'foo';
        $template1Dest = 'bar';

        $template1->getSrcFilePath()->willReturn($template1Src);
        $template1->getDestFilePath()->willReturn($template1Dest);

        $template2Src = 'baz';
        $template2Dest = 'qux';

        $template2->getSrcFilePath()->willReturn($template2Src);
        $template2->getDestFilePath()->willReturn($template2Dest);

        $templateRepository->findAllByLanguage(self::LANGUAGE)->willReturn([$template1, $template2]);

        $filesystem->copy($template1Src, $template1Dest)->shouldBeCalled();
        $filesystem->copy($template2Src, $template2Dest)->shouldBeCalled();

        $this->handle($command);
    }
}
