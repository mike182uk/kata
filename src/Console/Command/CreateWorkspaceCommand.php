<?php

namespace Mdb\Kata\Console\Command;

use InvalidArgumentException;
use Mdb\Kata\Kata;
use Mdb\Kata\KataRepository;
use Mdb\Kata\Language;
use Mdb\Kata\LanguageRepository;
use Mdb\Kata\TemplateRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;

class CreateWorkspaceCommand extends Command
{
    const RESOURCES_PATH_PLACEHOLDER = '%resources%';
    const WORKSPACE_PATH_PLACEHOLDER = '%workspace%';
    const REQUIREMENTS_FILE_FILENAME = 'requirements.md';

    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * @var KataRepository
     */
    private $kataRepository;

    /**
     * @var LanguageRepository
     */
    private $languageRepository;

    /**
     * @var TemplateRepository
     */
    private $templateRepository;

    /**
     * @var string
     */
    private $resourcesPath;

    /**
     * @var string
     */
    private $workspacePath;

    /**
     * @param Filesystem         $filesystem
     * @param KataRepository     $kataRepository
     * @param LanguageRepository $languageRepository
     * @param TemplateRepository $templateRepository
     * @param string             $resourcesPath
     */
    public function __construct(
        Filesystem $filesystem,
        KataRepository $kataRepository,
        LanguageRepository $languageRepository,
        TemplateRepository $templateRepository,
        $resourcesPath
    ){
        $this->filesystem = $filesystem;
        $this->kataRepository = $kataRepository;
        $this->languageRepository = $languageRepository;
        $this->templateRepository = $templateRepository;
        $this->resourcesPath = $resourcesPath;

        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('create:workspace')
            ->setDescription('Create a new kata workspace')
            ->addArgument(
                'path',
                InputArgument::REQUIRED,
                'Path to kata workspace'
            )
            ->addOption(
                'kata',
                null,
                InputOption::VALUE_REQUIRED,
                'Kata to perform'
            )
            ->addOption(
                'language',
                null,
                InputOption::VALUE_REQUIRED,
                'Language to use for kata'
            )
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $path = $input->getArgument('path');
        $this->createWorkspaceDirectory($path);
        $this->workspacePath = $path;

        $kataKey = $input->getOption('kata');
        $kata = $this->kataRepository->findOneByKey($kataKey);

        if (!is_null($kataKey) && !$kata instanceof Kata) {
            $this->removeWorkspace($this->workspacePath);

            throw new InvalidArgumentException(
                sprintf('The kata "%s" is not a valid kata. Please specify a valid kata.', $kataKey)
            );
        }

        if (!$kata) {
            $kata = $this->kataRepository->findOneByRandom();
        }

        $this->installRequirementsFile(
            sprintf('%s/%s', $path, self::REQUIREMENTS_FILE_FILENAME),
            $kata
        );

        $languageKey = $input->getOption('language');
        $language = $this->languageRepository->findOneByKey($languageKey);

        if (!is_null($languageKey) && !$language instanceof Language) {
            $this->removeWorkspace($this->workspacePath);

            throw new InvalidArgumentException(
                sprintf('The language "%s" is not a valid language. Please specify a valid language.', $languageKey)
            );
        }

        if (!$language) {
            $language = $this->languageRepository->findOneByRandom();
        }

        $this->installTemplates($language);
    }

    /**
     * @param string $path
     */
    private function createWorkspaceDirectory($path)
    {
        if ($this->filesystem->exists($path)) {
            throw new InvalidArgumentException('The path you have specified already exists. Please specify an alternative workspace path.');
        }

        $this->filesystem->mkdir($path);
    }

    /**
     * @param string $destination
     * @param Kata   $kata
     */
    private function installRequirementsFile($destination, Kata $kata)
    {
        $kataRequirementsFile = $this->getResourceFilePath(
            $kata->getRequirementsFilePath()
        );

        $this->filesystem->copy(
            $kataRequirementsFile,
            $destination
        );
    }

    /**
     * @param Language $language
     */
    private function installTemplates(Language $language)
    {
        $templates = $this->templateRepository->findAllByLanguage(
            $language->getKey()
        );

        foreach ($templates as $template) {
            $src = $this->getResourceFilePath(
                $template->getSrcFilePath()
            );

            $dest = $this->getWorkspaceFilePath(
                $template->getDestFilePath()
            );

            $this->filesystem->copy(
                $src,
                $dest
            );
        }
    }

    /**
     * @param string $resourceFile
     *
     * @return string
     */
    private function getResourceFilePath($resourceFile)
    {
        return preg_replace(
            sprintf('/%s/', self::RESOURCES_PATH_PLACEHOLDER),
            $this->resourcesPath,
            $resourceFile
        );
    }

    /**
     * @param string $workspaceFile
     *
     * @return string
     */
    private function getWorkspaceFilePath($workspaceFile)
    {
        return preg_replace(
            sprintf('/%s/', self::WORKSPACE_PATH_PLACEHOLDER),
            $this->workspacePath,
            $workspaceFile
        );
    }

    /**
     * @param string $workspacePath
     */
    private function removeWorkspace($workspacePath)
    {
        $this->filesystem->remove($workspacePath);
    }
}
