Feature: User can specify kata to perform
  In order to improve my performance of a specific kata
  As a user
  I want to be able to specify the kata i want to undertake

  Background:
    Given the katas available are:
      | name              | key               | requirements_file_path                 |
      | Fizz Buzz         | fizz_buzz         | %resources%/katas/fizz_buzz.md         |
      | String Calculator | string_calculator | %resources%/katas/string_calculator.md |

  Scenario: User specifies kata
    When I execute the command "create:workspace" with the options "path=foo,--kata=fizz_buzz"
    Then a new kata workspace should be created at "foo"
    And the kata requirements file should be present in the workspace

  Scenario: User specifies kata using the shorthand kata option
    When I execute the command "create:workspace" with the options "path=foo,-k=fizz_buzz"
    Then a new kata workspace should be created at "foo"
    And the kata requirements file should be present in the workspace

  Scenario: User specifies invalid kata
    When I execute the command "create:workspace" with the options "path=foo,--kata=bucks_fizz"
    Then I should see in the output:
      """
      The kata "bucks_fizz" is not a valid kata. Please specify a valid kata.
      """
    And a new kata workspace should not be created at "foo"
