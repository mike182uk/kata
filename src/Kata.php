<?php

namespace Mdb\Kata;

class Kata
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
    private $requirementsFilePath;

    /**
     * @param string $name
     * @param string $key
     * @param string $requirementsFilePath
     */
    public function __construct($name, $key, $requirementsFilePath)
    {
        $this->name = $name;
        $this->key = $key;
        $this->requirementsFilePath = $requirementsFilePath;
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
    public function getRequirementsFilePath()
    {
        return $this->requirementsFilePath;
    }
}
