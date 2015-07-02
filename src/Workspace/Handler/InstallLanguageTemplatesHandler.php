<?php

namespace Mdb\Kata\Workspace\Handler;

use Mdb\Kata\TemplateRepository;
use Mdb\Kata\Workspace\Command\InstallLanguageTemplatesCommand;
use Symfony\Component\Filesystem\Filesystem;

class InstallLanguageTemplatesHandler
{
    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * @var TemplateRepository
     */
    private $templateRepository;

    /**
     * @param Filesystem         $filesystem
     * @param TemplateRepository $templateRepository
     */
    public function __construct(
        Filesystem $filesystem,
        TemplateRepository $templateRepository
    ) {
        $this->filesystem = $filesystem;
        $this->templateRepository = $templateRepository;
    }

    /**
     * @param InstallLanguageTemplatesCommand $command
     */
    public function handle(InstallLanguageTemplatesCommand $command)
    {
        $templates = $this->templateRepository->findAllByLanguage(
            $command->getLanguage()
        );

        foreach ($templates as $template) {
            $src = $template->getSrcFilePath();
            $dest = sprintf('%s/%s', $command->getWorkspacePath(), $template->getDestFilePath());

            $this->filesystem->copy($src, $dest);
        }
    }
}
