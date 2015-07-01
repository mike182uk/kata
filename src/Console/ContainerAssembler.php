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
use Mdb\Kata\Workspace\Handler\InstallLanguageTemplatesHandler;
use Mdb\Kata\Workspace\Handler\InstallRequirementsFileHandler;
use Mdb\Kata\Workspace\Handler\ValidateKataHandler;
use Mdb\Kata\Workspace\Handler\ValidateLanguageHandler;
use Pimple\Container;
use Symfony\Component\Filesystem\Filesystem;

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

    private function defineUtilites($container)
    {
        $container['utility.filesystem'] = function ($c) {
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
        $container['repository.katas'] = function ($c) {
            return new KataRepository();
        };

        $container['repository.languages'] = function ($c) {
            return new LanguageRepository();
        };

        $container['repository.templates'] = function ($c) {
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
                $c['repository.katas'],
                $c['repository.languages']
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
    }
}
