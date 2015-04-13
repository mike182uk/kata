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
    private $description;

    /**
     * @var string
     */
    private $requirementsFilePath;

    /**
     * @param string $name
     * @param string $key
     * @param string $description
     * @param string $requirementsFilePath
     */
    public function __construct($name, $key, $description, $requirementsFilePath)
    {
        $this->name = $name;
        $this->key = $key;
        $this->description = $description;
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
    public function getSummary()
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getRequirementsFilePath()
    {
        return $this->requirementsFilePath;
    }
}
