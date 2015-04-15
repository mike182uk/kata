<?php

use Behat\Behat\Context\Context;
use Helpers\Application;

class ApplicationContext implements Context
{
    /**
     * @afterScenario
     */
    public function resetApplication()
    {
        Application::resetApplication();
    }
}
