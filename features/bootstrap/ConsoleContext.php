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
                list($option, $value) = explode('=', $option);

                if ($command == 'create:workspace') {
                    switch ($option) {
                        case 'path':
                            Registry::set(self::REGISTRY_KEY_WORKSPACE_PATH, $value);
                            $value = Path::normalizeWorkspaceFilePath($value);
                            break;
                        case '--kata':
                            Registry::set(self::REGISTRY_KEY_KATA, $value);
                            break;
                        case '--language':
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

        Assertion::contains(
            $output,
            (string) $expectedOutput,
            sprintf("Expected to see:\n\n%s\n\nin the output:\n\n%s\n\n", $output, $expectedOutput)
        );
    }
}
