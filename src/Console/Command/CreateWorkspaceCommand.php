<?php

namespace Mdb\Kata\Console\Command;

use League\Tactician\CommandBus;
use Mdb\Kata\KataRepository;
use Mdb\Kata\LanguageRepository;
use Mdb\Kata\Workspace\Command\CreateWorkspaceDirectoryCommand;
use Mdb\Kata\Workspace\Command\InstallLanguageTemplatesCommand;
use Mdb\Kata\Workspace\Command\InstallRequirementsFileCommand;
use Mdb\Kata\Workspace\Command\ValidateKataCommand;
use Mdb\Kata\Workspace\Command\ValidateLanguageCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class CreateWorkspaceCommand extends Command
{
    const REQUIREMENTS_FILE_FILENAME = 'requirements.md';

    /**
     * @var CommandBus
     */
    private $commandBus;

    /**
     * @var string
     */
    private $resourcesPath;

    /**
     * @var KataRepository
     */
    private $kataRepository;

    /**
     * @var LanguageRepository
     */
    private $languageRepository;

    /**
     * @param CommandBus         $commandBus
     * @param string             $resourcesPath
     * @param KataRepository     $kataRepository
     * @param LanguageRepository $languageRepository
     */
    public function __construct(
        CommandBus $commandBus,
        $resourcesPath,
        KataRepository $kataRepository,
        LanguageRepository $languageRepository
    ) {
        $this->commandBus = $commandBus;
        $this->resourcesPath = $resourcesPath;
        $this->kataRepository = $kataRepository;
        $this->languageRepository = $languageRepository;

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
                'k',
                InputOption::VALUE_REQUIRED,
                'Kata to perform'
            )
            ->addOption(
                'language',
                'l',
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
        $workspacePath = rtrim($input->getArgument('path'), '/');
        $kata = $input->getOption('kata');
        $language = $input->getOption('language');

        if (is_null($kata)) {
            $kata = $this->kataRepository->findOneByRandom()->getKey();
        }

        if (is_null($language)) {
            $language = $this->languageRepository->findOneByRandom()->getKey();
        }

        $commands = [
            new ValidateKataCommand($kata),
            new ValidateLanguageCommand($language),
            new CreateWorkspaceDirectoryCommand($workspacePath),
            new InstallRequirementsFileCommand(
                $kata,
                sprintf('%s/%s', $workspacePath, self::REQUIREMENTS_FILE_FILENAME)
            ),
            new InstallLanguageTemplatesCommand($language, $workspacePath),
        ];

        foreach ($commands as $command) {
            $this->commandBus->handle($command);
        }

        $output->writeln(
            $this->getSuccessMessage($workspacePath, $kata, $language)
        );
    }

    /**
     * @param string $workspacePath
     * @param string $kata
     * @param string $language
     *
     * @return string
     */
    private function getSuccessMessage($workspacePath, $kata, $language)
    {
        $kata = $this->kataRepository->findOneByKey($kata)->getName();
        $language = $this->languageRepository->findOneByKey($language)->getName();

        return sprintf(
            '<info>Kata workspace successfully created at <comment>%s</comment> with the kata <comment>%s</comment> using the language <comment>%s</comment></info>',
            $workspacePath,
            $kata,
            $language
        );
    }
}
