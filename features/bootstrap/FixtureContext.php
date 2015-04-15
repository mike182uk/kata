<?php

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
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
                $kataHash['summary'],
                $kataHash['requirements_file_path']
            );

            if ($kataHash['requirements_file_path'] != '') {
                $path = Path::getResourceFilePath($kataHash['requirements_file_path']);

                Filesystem::dumpFile($path, uniqid());
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
                $templateHash['template_src_path'],
                $templateHash['template_dest_path']
            );

            if ($templateHash['template_src_path'] != '') {
                $path = Path::getResourceFilePath($templateHash['template_src_path']);

                Filesystem::dumpFile($path, uniqid());
            }

            $templateRepository->insert($template);
        }
    }

    /**
     * @Given the resource files exist:
     */
    public function theResourceFilesExist(TableNode $table)
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
            new Kata('Foo Kata', 'foo', 'Foo Kata', '%resources%/katas/foo.md'),
            new Kata('Bar Kata', 'bar', 'Bar Kata', '%resources%/katas/bar.md'),
        ];

        foreach ($katas as $kata) {
            $requirementsFilePath = Path::getResourceFilePath($kata->getRequirementsFilePath());

            Filesystem::dumpFile($requirementsFilePath, uniqid());

            $kataRepository->insert($kata);
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
        \Helpers\Application::resetApplication();
    }
}
