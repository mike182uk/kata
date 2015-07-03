<?php

namespace Mdb\Kata\Console;

use League\Tactician\CommandBus;
use League\Tactician\Handler\CommandHandlerMiddleware;
use League\Tactician\Handler\MethodNameInflector\HandleInflector;
use Mdb\Kata\CommandBus\ClassNameWithoutSuffixExtractor;
use Mdb\Kata\CommandBus\HandlerContainerLocator;
use Mdb\Kata\Console\Command\CreateWorkspaceCommand;
use Mdb\Kata\Console\Command\ListKatasCommand;
use Mdb\Kata\Console\Command\ListLanguagesCommand;
use Mdb\Kata\KataRepository;
use Mdb\Kata\LanguageRepository;
use Mdb\Kata\TemplateRepository;
use Mdb\Kata\Workspace\Handler\CreateWorkspaceDirectoryHandler;
use Mdb\Kata\Workspace\Handler\InstallDependenciesHandler;
use Mdb\Kata\Workspace\Handler\InstallLanguageTemplatesHandler;
use Mdb\Kata\Workspace\Handler\InstallRequirementsFileHandler;
use Mdb\Kata\Workspace\Handler\OutputMessageHandler;
use Mdb\Kata\Workspace\Handler\OutputWorkspaceCreationSuccessMessageHandler;
use Mdb\Kata\Workspace\Handler\ValidateKataHandler;
use Mdb\Kata\Workspace\Handler\ValidateLanguageHandler;
use Pimple\Container;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Process\ProcessBuilder;

class ContainerAssembler
{
    /**
     * @param Container $container
     */
    public function assemble(Container $container)
    {
        $this->defineUtilites($container);
        $this->defineRepositories($container);
        $this->defineConsoleCommands($container);
        $this->defineWorkspaceCommandHandlers($container);
    }

    /**
     * @param Container $container
     */
    private function defineUtilites(Container $container)
    {
        $container['utility.filesystem'] = function () {
            return new Filesystem();
        };

        $container['utility.create_workspace_command_bus'] = function ($c) {
            $middleware = new CommandHandlerMiddleware(
                new ClassNameWithoutSuffixExtractor('Command'),
                new HandlerContainerLocator(
                    $c,
                    'workspace.command_handler.'
                ),
                new HandleInflector()
            );

            return new CommandBus([$middleware]);
        };
    }

    /**
     * @param Container $container
     */
    private function defineRepositories($container)
    {
        $container['repository.katas'] = function () {
            return new KataRepository();
        };

        $container['repository.languages'] = function () {
            return new LanguageRepository();
        };

        $container['repository.templates'] = function () {
            return new TemplateRepository();
        };
    }

    /**
     * @param Container $container
     */
    private function defineConsoleCommands($container)
    {
        $container['console.command.list:katas'] = function ($c) {
            return new ListKatasCommand(
                $c['repository.katas']
            );
        };

        $container['console.command.list:languages'] = function ($c) {
            return new ListLanguagesCommand(
                $c['repository.languages']
            );
        };

        $container['console.command.create:workspace'] = function ($c) {
            return new CreateWorkspaceCommand(
                $c['utility.create_workspace_command_bus'],
                $c['path.resources'],
                $c['repository.katas']->findAll(),
                $c['repository.languages']->findAll()
            );
        };
    }

    /**
     * @param Container $container
     */
    private function defineWorkspaceCommandHandlers($container)
    {
        $container['workspace.command_handler.ValidateKata'] = function ($c) {
            return new ValidateKataHandler(
                $c['repository.katas']
            );
        };

        $container['workspace.command_handler.ValidateLanguage'] = function ($c) {
            return new ValidateLanguageHandler(
                $c['repository.languages']
            );
        };

        $container['workspace.command_handler.CreateWorkspaceDirectory'] = function ($c) {
            return new CreateWorkspaceDirectoryHandler(
                $c['utility.filesystem']
            );
        };

        $container['workspace.command_handler.InstallRequirementsFile'] = function ($c) {
            return new InstallRequirementsFileHandler(
                $c['utility.filesystem'],
                $c['repository.katas']
            );
        };

        $container['workspace.command_handler.InstallLanguageTemplates'] = function ($c) {
            return new InstallLanguageTemplatesHandler(
                $c['utility.filesystem'],
                $c['repository.templates']
            );
        };

        $container['workspace.command_handler.OutputWorkspaceCreationSuccessMessage'] = function ($c) {
            return new OutputWorkspaceCreationSuccessMessageHandler(
                $c['repository.katas'],
                $c['repository.languages']
            );
        };

        $container['workspace.command_handler.InstallDependencies'] = function ($c) {
            return new InstallDependenciesHandler(
                $c['repository.languages'],
                new ProcessBuilder()
            );
        };

        $container['workspace.command_handler.OutputMessage'] = function () {
            return new OutputMessageHandler();
        };
    }
}
