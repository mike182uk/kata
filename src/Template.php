<?php

namespace Mdb\Kata;

class Template
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $language;

    /**
     * @var string
     */
    private $srcFilePath;

    /**
     * @var string
     */
    private $destFilePath;

    /**
     * @param string $name
     * @param string $language
     * @param string $srcFilePath
     * @param string $destFilePath
     */
    public function __construct($name, $language, $srcFilePath, $destFilePath)
    {
        $this->name = $name;
        $this->language = $language;
        $this->srcFilePath = $srcFilePath;
        $this->destFilePath = $destFilePath;
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
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * @return string
     */
    public function getSrcFilePath()
    {
        return $this->srcFilePath;
    }

    /**
     * @return string
     */
    public function getDestFilePath()
    {
        return $this->destFilePath;
    }
}
