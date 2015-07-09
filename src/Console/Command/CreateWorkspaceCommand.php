<?php

namespace Mdb\Kata\Console\Command;

use League\Tactician\CommandBus;
use Mdb\Kata\Workspace\Command\CreateWorkspaceDirectoryCommand;
use Mdb\Kata\Workspace\Command\InstallDependenciesCommand;
use Mdb\Kata\Workspace\Command\InstallLanguageTemplatesCommand;
use Mdb\Kata\Workspace\Command\InstallRequirementsFileCommand;
use Mdb\Kata\Workspace\Command\OutputMessageCommand;
use Mdb\Kata\Workspace\Command\OutputWorkspaceCreationSuccessMessageCommand;
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
     * @var Kata[]
     */
    private $katas;

    /**
     * @var Language[]
     */
    private $languages;

    /**
     * @param CommandBus $commandBus
     * @param Kata[]     $katas
     * @param Language[] $languages
     */
    public function __construct(
        CommandBus $commandBus,
        array $katas,
        array $languages
    ) {
        $this->commandBus = $commandBus;
        $this->katas = $katas;
        $this->languages = $languages;

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
            ->addOption(
                'no-deps',
                null,
                InputOption::VALUE_NONE,
                'Do not install any dependencies'
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
        $noDeps = $input->getOption('no-deps');

        if (is_null($kata)) {
            $kata = $this->katas[array_rand($this->katas)]->getKey();
        }

        if (is_null($language)) {
            $language = $this->languages[array_rand($this->languages)]->getKey();
        }

        $commands = [
            new ValidateKataCommand($kata),
            new ValidateLanguageCommand($language),
            new CreateWorkspaceDirectoryCommand($workspacePath),
            new InstallRequirementsFileCommand(
                $kata,
                sprintf('%s/%s', $workspacePath, self::REQUIREMENTS_FILE_FILENAME)
            ),
            new InstallLanguageTemplatesCommand(
                $language,
                $workspacePath
            ),
            new OutputWorkspaceCreationSuccessMessageCommand(
                $workspacePath,
                $kata,
                $language,
                $output
            ),
        ];

        if (!$noDeps) {
            $commands[] = new OutputMessageCommand(
                '<info>Installing dependencies...</info>',
                $output
            );

            $commands[] = new InstallDependenciesCommand(
                $language,
                $workspacePath
            );
        }

        foreach ($commands as $command) {
            $this->commandBus->handle($command);
        }
    }
}
