<?php

namespace Mdb\Kata\Console;

use Mdb\Kata\Console\Command\CreateWorkspaceCommand;
use Mdb\Kata\Console\Command\ListKatasCommand;
use Mdb\Kata\Console\Command\ListLanguagesCommand;
use Mdb\Kata\KataRepository;
use Mdb\Kata\LanguageRepository;
use Mdb\Kata\TemplateRepository;
use Pimple\Container;
use Symfony\Component\Filesystem\Filesystem;

class ContainerAssembler
{
    /**
     * @param Container $container
     */
    public function assemble(Container $container)
    {
        $this->defineRepositories($container);
        $this->defineConsoleCommands($container);
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
                new Filesystem(),
                $c['repository.katas'],
                $c['repository.languages'],
                $c['repository.templates'],
                $c['path.resources']
            );
        };
    }
}
