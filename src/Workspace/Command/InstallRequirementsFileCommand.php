<?php

namespace Mdb\Kata\Workspace\Command;

class InstallRequirementsFileCommand
{
    /**
     * @var string
     */
    private $kata;

    /**
     * @var string
     */
    private $installLocation;

    /**
     * @param string $kata
     * @param string $installLocation
     */
    public function __construct($kata, $installLocation)
    {
        $this->kata = $kata;
        $this->installLocation = $installLocation;
    }

    /**
     * @return string
     */
    public function getKata()
    {
        return $this->kata;
    }

    /**
     * @return string
     */
    public function getInstallLocation()
    {
        return $this->installLocation;
    }
}
