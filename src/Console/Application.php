<?php

namespace Mdb\Kata\Console;

use Mdb\Kata\Kata;
use Mdb\Kata\Language;
use Mdb\Kata\Template;
use Pimple\Container;
use Symfony\Component\Console\Application as BaseApplication;
use Symfony\Component\Yaml\Yaml;

class Application extends BaseApplication
{
    /**
     * @var Container
     */
    private $container;

    /**
     * {@inheritdoc}
     */
    public function __construct()
    {
        $this->container = new Container();

        $containerAssembler = new ContainerAssembler();
        $containerAssembler->assemble($this->container);

        parent::__construct('kata', '0.0.1');
    }

    /**
     * @return Container
     */
    public function getContainer()
    {
        return $this->container;
    }

    public function discoverCommands()
    {
        foreach ($this->container->keys() as $key) {
            if (strpos($key, 'console.command.') === 0) {
                $this->add($this->container[$key]);
            }
        }
    }

    /**
     * @param string $configPath
     */
    public function loadConfiguration($configPath)
    {
        if (file_exists($configPath) && $config = Yaml::parse($configPath)) {
            $this->parseConfiguration($config);
        }
    }

    /**
     * @param array $config
     */
    private function parseConfiguration($config)
    {
        if (array_key_exists('languages', $config)) {
            $languageRepository = $this->container['repository.languages'];

            foreach ($config['languages'] as $languageHash) {
                $language = new Language(
                    $languageHash['name'],
                    $languageHash['key']
                );

                $languageRepository->insert($language);
            }
        }

        if (array_key_exists('katas', $config)) {
            $kataRepository = $this->container['repository.katas'];

            foreach ($config['katas'] as $kataHash) {
                $kata = new Kata(
                    $kataHash['name'],
                    $kataHash['key'],
                    $kataHash['summary'],
                    $kataHash['requirements_file_path']
                );

                $kataRepository->insert($kata);
            }
        }

        if (array_key_exists('templates', $config)) {
            $templateRepository = $this->container['repository.templates'];

            foreach ($config['templates'] as $templateHash) {
                $template = new Template(
                    $templateHash['name'],
                    $templateHash['language'],
                    $templateHash['template_src_path'],
                    $templateHash['template_dest_path']
                );

                $templateRepository->insert($template);
            }
        }
    }
}
