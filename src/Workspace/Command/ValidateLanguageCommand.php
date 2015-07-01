<?php

namespace Mdb\Kata\Workspace\Command;

class ValidateLanguageCommand
{
    /**
     * @var string
     */
    private $language;

    /**
     * @param string $language
     */
    public function __construct($language)
    {
        $this->language = $language;
    }

    /**
     * @return string
     */
    public function getLanguage()
    {
        return $this->language;
    }
}
