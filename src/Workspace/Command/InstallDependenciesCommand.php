<?php

namespace Mdb\Kata\Workspace\Command;

class InstallDependenciesCommand
{
    /**
     * @var string
     */
    private $language;

    /**
     * @var string
     */
    private $workspacePath;

    /**
     * @param string $lanuage
     * @param string $workspacePath
     */
    public function __construct($lanuage, $workspacePath)
    {
        $this->language = $lanuage;
        $this->workspacePath = $workspacePath;
    }

    /**
     * @return string
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * @return string
     */
    public function getWorkspacePath()
    {
        return $this->workspacePath;
    }
}
