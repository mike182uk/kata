<?php

namespace Mdb\Kata\Workspace\Handler;

use Mdb\Kata\Console\Utility\PathNormalizer;
use Mdb\Kata\TemplateRepository;
use Mdb\Kata\Workspace\Command\InstallLanguageTemplatesCommand;
use Symfony\Component\Filesystem\Filesystem;

class InstallLanguageTemplatesHandler
{
    const RESOURCES_PATH_PLACEHOLDER = '%resources%';
    const WORKSPACE_PATH_PLACEHOLDER = '%workspace%';

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

            $dest = PathNormalizer::normalizeWorkspaceFilePath(
                $command->getWorkspacePath(),
                $template->getDestFilePath()
            );

            $this->filesystem->copy($src, $dest);
        }
    }
}
