<?php

namespace Mdb\Kata;

class Language
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $key;

    /**
     * @var string
     */
    private $packageManagerInstallCommand;

    /**
     * @param string $name
     * @param string $key
     * @param string $packageManagerInstallCommand
     */
    public function __construct($name, $key, $packageManagerInstallCommand)
    {
        $this->name = $name;
        $this->key = $key;
        $this->packageManagerInstallCommand = $packageManagerInstallCommand;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @return string
     */
    public function getPackageManagerInstallCommand()
    {
        return $this->packageManagerInstallCommand;
    }
}
