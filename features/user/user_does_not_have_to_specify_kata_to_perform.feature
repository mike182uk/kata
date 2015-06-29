Feature: User does not have to specify kata to perform
  In order to improve my performance of any kata
  As a user
  I want a random kata to be selected for me if i do not specify a kata

  Background:
    Given the katas available are:
      | name              | key               | requirements_file_path                 |
      | Fizz Buzz         | fizz_buzz         | %resources%/katas/fizz_buzz.md         |
      | String Calculator | string_calculator | %resources%/katas/string_calculator.md |

  Scenario: User does not specify kata
    When I execute the command "create:workspace" with the options "path=foo"
    Then a new kata workspace should be created at "foo"
    And a kata requirements file for the randomly selected kata should be present in the workspace
