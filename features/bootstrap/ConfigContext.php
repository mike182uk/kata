<?php

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Helpers\Application;
use Helpers\Filesystem;

class ConfigContext implements Context
{
    /**
     * @Given the config file contains:
     */
    public function theConfigFileContains(PyStringNode $contents)
    {
        Filesystem::dumpFile(Application::getConfigPath(), $contents);
    }
}
