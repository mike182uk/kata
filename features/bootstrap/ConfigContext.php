<?php

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Helpers\Filesystem;
use Helpers\Path;

class ConfigContext implements Context
{
    /**
     * @Given the config file :configFile contains:
     */
    public function theConfigFileContains($configFile, PyStringNode $contents)
    {
        $configFilePath = sprintf(
            '%s/%s',
            Path::getResourcesPath(),
            $configFile
        );

        Filesystem::dumpFile($configFilePath, $contents);
    }
}
