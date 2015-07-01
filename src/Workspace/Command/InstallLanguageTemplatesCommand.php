<?php

namespace Mdb\Kata\Workspace\Command;

class InstallLanguageTemplatesCommand
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
     * @param string $language
     * @param string $workspacePath
     */
    public function __construct($language, $workspacePath)
    {
        $this->language = $language;
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
