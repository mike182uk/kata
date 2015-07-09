<?php

namespace Mdb\Kata\Console;

use Mdb\Kata\Kata;
use Mdb\Kata\Language;
use Mdb\Kata\Template;
use Pimple\Container;
use Symfony\Component\Console\Application as BaseApplication;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Yaml\Yaml;

class Application extends BaseApplication
{
    const NAME = 'kata';
    const VERSION = '0.3.0';

    /**
     * @var Container
     */
    private $container;

    /**
     * @param string $resourcesPath
     * @param string $configPath
     */
    public function __construct($resourcesPath, $configPath)
    {
        $this->container = new Container();

        $this->container['path.resources'] = $resourcesPath;
        $this->container['path.config'] = $configPath;

        $containerAssembler = new ContainerAssembler();
        $containerAssembler->assemble($this->container);

        parent::__construct(self::NAME, self::VERSION);
    }

    /**
     * {@inheritdoc}
     */
    public function doRun(InputInterface $input, OutputInterface $output)
    {
        $this->loadConfiguration();
        $this->discoverCommands();

        parent::doRun($input, $output);
    }

    /**
     * @return Container
     */
    public function getContainer()
    {
        return $this->container;
    }

    private function loadConfiguration()
    {
        $configPath = $this->getContainer()['path.config'];

        if (file_exists($configPath) && $config = Yaml::parse($configPath)) {
            $this->initLanguagesRepositoryFromConfig($config);
            $this->initKatasRepositoryFromConfig($config);
            $this->initTemplateRepositoryFromConfig($config);
        }
    }

    private function discoverCommands()
    {
        foreach ($this->container->keys() as $key) {
            if (strpos($key, 'console.command.') === 0) {
                $this->add($this->container[$key]);
            }
        }
    }

    /**
     * @param array $config
     */
    private function initLanguagesRepositoryFromConfig($config)
    {
        if (!array_key_exists('languages', $config)) {
            return;
        }

        $languageRepository = $this->container['repository.languages'];

        foreach ($config['languages'] as $languageHash) {
            $language = new Language(
                $languageHash['name'],
                $languageHash['key'],
                $languageHash['package_manager_install_command']
            );

            $languageRepository->insert($language);
        }
    }

    /**
     * @param array $config
     */
    private function initKatasRepositoryFromConfig($config)
    {
        if (!array_key_exists('katas', $config)) {
            return;
        }

        $kataRepository = $this->container['repository.katas'];

        foreach ($config['katas'] as $kataHash) {
            $kata = new Kata(
                $kataHash['name'],
                $kataHash['key'],
                sprintf('%s/%s', $this->container['path.resources'], $kataHash['requirements_file_path'])
            );

            $kataRepository->insert($kata);
        }
    }

    /**
     * @param array $config
     */
    private function initTemplateRepositoryFromConfig($config)
    {
        if (!array_key_exists('templates', $config)) {
            return;
        }

        $templateRepository = $this->container['repository.templates'];

        foreach ($config['templates'] as $templateHash) {
            $template = new Template(
                $templateHash['name'],
                $templateHash['language'],
                sprintf('%s/%s', $this->container['path.resources'], $templateHash['template_src_path']),
                $templateHash['template_dest_path']
            );

            $templateRepository->insert($template);
        }
    }
}
