<?php

namespace Helpers;

use Mdb\Kata\Console\Application as ConsoleApplication;
use Mdb\Kata\Console\Command\CreateWorkspaceCommand;
use Mdb\Kata\Console\Command\ListKatasCommand;
use Mdb\Kata\Console\Command\ListLanguagesCommand;
use Symfony\Component\Console\Tester\ApplicationTester;
use Symfony\Component\Filesystem\Filesystem as sfFilesystem;

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

        $listKatasCommand = new ListKatasCommand(Fixture::getKataRepository());
        $listLanguagesCommand = new ListLanguagesCommand(Fixture::getLanguageRepository());
        $createWorkspaceCommand = new CreateWorkspaceCommand(
            new sfFilesystem(),
            Fixture::getKataRepository(),
            Fixture::getLanguageRepository(),
            Fixture::getTemplateRepository(),
            Path::getResourcesPath()
        );

        $application->add($listKatasCommand);
        $application->add($listLanguagesCommand);
        $application->add($createWorkspaceCommand);

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
