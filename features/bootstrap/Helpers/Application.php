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

    private static function initApplication()
    {
        $application = new ConsoleApplication();
        $application->setAutoExit(false);

        $container = $application->getContainer();

        $container['path.resources'] = Path::getResourcesPath();
        $container['repository.katas'] = Fixture::getKataRepository();
        $container['repository.languages'] = Fixture::getLanguageRepository();
        $container['repository.templates'] = Fixture::getTemplateRepository();

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
