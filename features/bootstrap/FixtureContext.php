<?php

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Helpers\Application;
use Helpers\Filesystem;
use Helpers\Fixture;
use Helpers\Path;
use Mdb\Kata\Kata;
use Mdb\Kata\Language;
use Mdb\Kata\Template;

class FixtureContext implements Context
{
    /**
     * @Given the katas available are:
     */
    public function theKatasAvailableAre(TableNode $table)
    {
        $kataRepository = Fixture::getKataRepository();

        foreach ($table->getHash() as $kataHash) {
            // we dont always need to show the "requirements_file_path" field in the feature file
            // so if it is not specified, set it to an empty string so the object can still be constructed
            if (!array_key_exists('requirements_file_path', $kataHash)) {
                $kataHash['requirements_file_path'] = '';
            }

            $kata = new Kata(
                $kataHash['name'],
                $kataHash['key'],
                Path::getResourceFilePath($kataHash['requirements_file_path'])
            );

            if ($kata->getRequirementsFilePath() != '') {
                Filesystem::dumpFile(
                    $kata->getRequirementsFilePath(),
                    uniqid()
                );
            }

            $kataRepository->insert($kata);
        }
    }

    /**
     * @Given the programming languages available are:
     */
    public function theProgrammingLanguagesAvailableAre(TableNode $table)
    {
        $languageRepository = Fixture::getLanguageRepository();

        foreach ($table->getHash() as $language) {
            $language = new Language(
                $language['name'],
                $language['key']
            );

            $languageRepository->insert($language);
        }
    }

    /**
     * @Given the programming language templates available are:
     */
    public function theLanguageTemplatesAvailableAre(TableNode $table)
    {
        $templateRepository = Fixture::getTemplateRepository();

        foreach ($table->getHash() as $templateHash) {
            $template = new Template(
                $templateHash['name'],
                $templateHash['language'],
                Path::getResourceFilePath($templateHash['template_src_path']),
                $templateHash['template_dest_path']
            );

            if ($template->getSrcFilePath() != '') {
                Filesystem::dumpFile($template->getSrcFilePath(), uniqid());
            }

            $templateRepository->insert($template);
        }
    }

    /**
     * @Given the resource files available are:
     */
    public function theResourceFilesAvailableAre(TableNode $table)
    {
        foreach ($table->getHash() as $fileHash) {
            $path = Path::getResourceFilePath($fileHash['path']);

            Filesystem::dumpFile($path, $fileHash['content']);
        }
    }

    /**
     * @beforeScenario @requiresKataFixtures
     */
    public function generateKataFixtures()
    {
        $kataRepository = Fixture::getKataRepository();

        $katas = [
            new Kata('Foo', 'foo', Path::getResourceFilePath('%resources%/katas/foo.md')),
            new Kata('Bar', 'bar', Path::getResourceFilePath('%resources%/katas/bar.md')),
        ];

        foreach ($katas as $kata) {
            Filesystem::dumpFile($kata->getRequirementsFilePath(), uniqid());

            $kataRepository->insert($kata);
        }
    }

    /**
     * @beforeScenario @requiresLanguageFixtures
     */
    public function generateLanguageFixtures()
    {
        $languageRepository = Fixture::getLanguageRepository();

        $languages = [
            new Language('Foo', 'foo'),
            new Language('Bar', 'bar'),
        ];

        foreach ($languages as $language) {
            $languageRepository->insert($language);
        }
    }

    /**
     * @afterScenario
     */
    public function clearRepositories()
    {
        Fixture::getKataRepository()->clear();
        Fixture::getLanguageRepository()->clear();
        Fixture::getTemplateRepository()->clear();
    }

    /**
     * @afterScenario
     */
    public function resetApplication()
    {
        Application::resetApplication();
    }
}
