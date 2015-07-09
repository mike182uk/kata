<?php

use Assert\Assertion;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Helpers\Application;
use Helpers\Path;
use Helpers\Registry;

class ConsoleContext implements Context
{
    const REGISTRY_KEY_WORKSPACE_PATH = 'console.command.create:workspace.input.option.workspace_path';
    const REGISTRY_KEY_KATA = 'console.command.create:workspace.input.option.kata';
    const REGISTRY_KEY_LANGUAGE = 'console.command.create:workspace.input.option.language';

    /**
     * @When I execute the command :command
     * @When I execute the command :command with the options :options
     */
    public function iExecuteTheCommand($command, $options = null)
    {
        $input = [
            'command' => $command,
        ];

        if ($options) {
            $options = explode(',', $options);

            foreach ($options as $option) {
                if (strpos($option, '=') !== false) {
                    list($option, $value) = explode('=', $option);
                } else {
                    $value = null;
                }

                if ($command == 'create:workspace') {
                    switch ($option) {
                        case 'path':
                            $value = Path::normalizeWorkspaceFilePath($value);
                            Registry::set(self::REGISTRY_KEY_WORKSPACE_PATH, $value);
                            break;
                        case '--kata':
                        case '-k':
                            Registry::set(self::REGISTRY_KEY_KATA, $value);
                            break;
                        case '--language':
                        case '-l':
                            Registry::set(self::REGISTRY_KEY_LANGUAGE, $value);
                            break;
                    }
                }

                $input[$option] = $value;
            }
        }

        Application::getTestApplication()->run($input);
    }

    /**
     * @Then I should see in the output:
     */
    public function iShouldSeeInTheOutput(PyStringNode $expectedOutput)
    {
        $output = Application::getTestApplication()->getDisplay();
        $expectedOutput = $this->parsePlaceholders((string) $expectedOutput);

        $outputNoWhitespace = preg_replace('/\s+/', '', $output);
        $expectedOutputNoWhitespace = preg_replace('/\s+/', '', $expectedOutput);

        Assertion::contains(
            $outputNoWhitespace,
            $expectedOutputNoWhitespace,
            sprintf("Expected to see:\n\n%s\n\nin the output:\n\n%s\n\n", $expectedOutput, $output)
        );
    }

    /**
     * @param string $content
     *
     * @return strig
     */
    private function parsePlaceholders($content)
    {
        $placeholders = [
            '%path%' => Registry::get(self::REGISTRY_KEY_WORKSPACE_PATH),
        ];

        foreach ($placeholders as $placeholder => $replacement) {
            $content = preg_replace(
                sprintf('/%s/', $placeholder),
                $replacement,
                $content
            );
        }

        return $content;
    }
}
