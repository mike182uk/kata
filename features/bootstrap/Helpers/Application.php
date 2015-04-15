<?php

namespace Helpers;

use Mdb\Kata\Console\Application as ConsoleApplication;
use Symfony\Component\Console\Tester\ApplicationTester;

class Application
{
    /**
     * @var ConsoleApplication
     */
    private static $application;

    /**
     * @var ApplicationTester
     */
    private static $testApplication;

    /**
     * @return ConsoleApplication
     */
    public static function getApplication()
    {
        if (!self::$application instanceof ConsoleApplication) {
            self::initApplication();
        }

        return self::$application;
    }

    /**
     * @return ApplicationTester
     */
    public static function getTestApplication()
    {
        if (!self::$testApplication instanceof ApplicationTester) {
            self::initTestApplication();
        }

        return self::$testApplication;
    }

    public static function resetApplication()
    {
        self::$application = null;
        self::$testApplication = null;
    }

    /**
     * @return string
     */
    public static function getConfigPath()
    {
        return Path::getResourceFilePath('%resources%/config.yml');
    }

    private static function initApplication()
    {
        $resourcesPath = Path::getResourcesPath();

        $application = new ConsoleApplication($resourcesPath);
        $application->setAutoExit(false);

        $container = $application->getContainer();

        $container->extend('repository.katas', function () { return Fixture::getKataRepository(); });
        $container->extend('repository.languages', function () { return Fixture::getLanguageRepository(); });
        $container->extend('repository.templates', function () { return Fixture::getTemplateRepository(); });

        $application->loadConfiguration(self::getConfigPath());
        $application->discoverCommands();

        self::$application = $application;
    }

    private static function initTestApplication()
    {
        if (!self::$application instanceof ApplicationTester) {
            self::initApplication();
        }

        self::$testApplication = new ApplicationTester(self::$application);
    }
}
