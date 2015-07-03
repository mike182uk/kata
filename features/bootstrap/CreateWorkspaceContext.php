<?php

use Assert\Assertion;
use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Helpers\Filesystem;
use Helpers\Fixture;
use Helpers\Path;
use Helpers\Registry;
use Mdb\Kata\Console\Command\CreateWorkspaceCommand;

class CreateWorkspaceContext implements Context, SnippetAcceptingContext
{
    /**
     * @Given The path :path already exists
     */
    public function thePathAlreadyExists($path)
    {
        $path = Path::normalizeWorkspaceFilePath($path);

        Filesystem::mkdir($path);

        Path::registerCreatedPath($path);
    }

    /**
     * @Then a new kata workspace should be created at :workspacePath
     */
    public function aNewKataWorkspaceShouldBeCreatedAt($workspacePath)
    {
        $normalizedWorkspacePath = Path::normalizeWorkspaceFilePath($workspacePath);

        Assertion::directory($normalizedWorkspacePath);
    }

    /**
     * @Then a new kata workspace should not be created at :workspacePath
     */
    public function aNewKataWorkspaceShouldNotBeCreatedAt($workspacePath)
    {
        $normalizedWorkspacePath = Path::normalizeWorkspaceFilePath($workspacePath);

        Assertion::false(is_dir($normalizedWorkspacePath));
    }

    /**
     * @Then the kata requirements file should be present in the workspace
     */
    public function theKataRequirementsFileShouldBePresentInTheWorkspace()
    {
        $selectedKataKey = Registry::get(ConsoleContext::REGISTRY_KEY_KATA);
        $workspacePath = Registry::get(ConsoleContext::REGISTRY_KEY_WORKSPACE_PATH);
        $kata = Fixture::getKataRepository()->findOneByKey($selectedKataKey);
        $kataRequirementsFile = $kata->getRequirementsFilePath();

        $expectedFile = sprintf(
            '%s/%s',
            $workspacePath,
            CreateWorkspaceCommand::REQUIREMENTS_FILE_FILENAME
        );

        Assertion::file($expectedFile);
        Assertion::file($kataRequirementsFile);

        $kataRequirementsFileContents = file_get_contents($kataRequirementsFile);
        $expectedFileContents = file_get_contents($expectedFile);

        Assertion::same($kataRequirementsFileContents, $expectedFileContents);
    }

    /**
     * @Then a kata requirements file for the randomly selected kata should be present in the workspace
     */
    public function aKataRequirementsFileForTheRandomlySelectedKataShouldBePresentInTheWorkspace()
    {
        $kataRequirementsFilePresent = false;
        $workspacePath = Registry::get(ConsoleContext::REGISTRY_KEY_WORKSPACE_PATH);
        $katas = Fixture::getKataRepository()->findAll();

        $expectedFile = sprintf(
            '%s/%s',
            $workspacePath,
            CreateWorkspaceCommand::REQUIREMENTS_FILE_FILENAME
        );

        Assertion::file($expectedFile);

        foreach ($katas as $kata) {
            $kataRequirementsFile = $kata->getRequirementsFilePath();
            $kataRequirementsFileContents = file_get_contents($kataRequirementsFile);
            $expectedFileContents = file_get_contents($expectedFile);

            if ($kataRequirementsFileContents == $expectedFileContents) {
                $kataRequirementsFilePresent = true;
                break;
            }
        }

        Assertion::true($kataRequirementsFilePresent);
    }

    /**
     * @Then the language templates for the randomly selected language should be present in the workspace
     */
    public function theLanguageTemplatesForTheRandomlySelectedLanguageShouldBePresentInTheWorkspace()
    {
        $templatesPresent = false;

        $templateRepository = Fixture::getTemplateRepository();
        $languages = Fixture::getLanguageRepository()->findAll();

        foreach ($languages as $language) {
            $templates = $templateRepository->findAllByLanguage($language->getKey());
            $templatesForCurrentLanguagePresent = true;

            foreach ($templates as $template) {
                $templatePath = $template->getSrcFilePath();
                $templatePathContents = file_get_contents($templatePath);

                $destinationPath = Path::getWorkspaceFilePath(
                    Registry::get(ConsoleContext::REGISTRY_KEY_WORKSPACE_PATH),
                    $template->getDestFilePath()
                );

                // first check that the destination file exists
                if (!Filesystem::exists($destinationPath)) {
                    $templatesForCurrentLanguagePresent = false;
                } else {
                    // then make sure the contents of the file match
                    $destinationPathContents = file_get_contents($destinationPath);

                    if ($destinationPathContents !== $templatePathContents) {
                        $templatesForCurrentLanguagePresent = false;
                    }
                }
            }

            if ($templatesForCurrentLanguagePresent) {
                $templatesPresent = true;
                break;
            }
        }

        Assertion::true($templatesPresent);
    }

    /**
     * @Then the :language language templates should be present in the workspace
     */
    public function theLanguageTemplatesShouldBePresentInTheWorkspace($language)
    {
        $templates = Fixture::getTemplateRepository()->findAllByLanguage($language);
        $templatesPresent = true;

        foreach ($templates as $template) {
            $templatePath = $template->getSrcFilePath();
            $templatePathContents = file_get_contents($templatePath);

            $destinationPath = Path::getWorkspaceFilePath(
                Registry::get(ConsoleContext::REGISTRY_KEY_WORKSPACE_PATH),
                $template->getDestFilePath()
            );

            // first check that the destination file exists
            if (!Filesystem::exists($destinationPath)) {
                $templatesPresent = false;
            } else {
                // then make sure the contents of the file match
                $destinationPathContents = file_get_contents($destinationPath);

                if ($destinationPathContents !== $templatePathContents) {
                    $templatesPresent = false;
                }
            }
        }

        Assertion::true($templatesPresent);
    }

    /**
     * @Then the install command for the :language package manager should have been run
     */
    public function theInstallCommandForThePackageManagerShouldHaveBeenRun($language)
    {
        switch ($language) {
            case 'php':
                $fileToCheck = Path::getWorkspaceFilePath(
                    Registry::get(ConsoleContext::REGISTRY_KEY_WORKSPACE_PATH),
                    'composer.lock'
                );
                break;
            case 'ruby':
                $fileToCheck = Path::getWorkspaceFilePath(
                    Registry::get(ConsoleContext::REGISTRY_KEY_WORKSPACE_PATH),
                    '.bundle/config'
                );
        }

        Assertion::file($fileToCheck);
    }

    /**
     * @afterScenario
     */
    public function cleanUpTempWorkspacePaths()
    {
        $workspacePath = Registry::get(ConsoleContext::REGISTRY_KEY_WORKSPACE_PATH);

        if ($workspacePath) {
            Filesystem::remove($workspacePath);
        }

        foreach (Path::getCreatedPaths() as $path) {
            Filesystem::remove($path);
        }
    }
}
