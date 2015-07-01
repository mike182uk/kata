Feature: User can specify path to kata workspace
  In order to know where the kata workspace will be created
  As a user
  I want to be able to specify the path for the kata workspace

  Background:
    Given the katas available are:
      | name              | key               | requirements_file                      |
      | Fizz Buzz         | fizz_buzz         | %resources%/katas/fizz_buzz.md         |
      | String Calculator | string_calculator | %resources%/katas/string_calculator.md |

  @requiresLanguageFixtures
  Scenario: User specifies path for kata workspace
    When I execute the command "create:workspace" with the options "path=foo,--kata=fizz_buzz"
    Then a new kata workspace should be created at "foo"

  @requiresLanguageFixtures
  Scenario: User specifies path that already exists for kata workspace
    Given The path "foo" already exists
    When I execute the command "create:workspace" with the options "path=foo,--kata=fizz_buzz"
    Then I should see in the output:
      """
      The path you have specified already exists. Please specify an alternative workspace path.
      """
