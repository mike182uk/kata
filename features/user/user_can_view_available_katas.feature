Feature: User can view available katas
  In order to know what katas can be performed
  As a user
  I want to be able to view the available katas

  Background:
    Given the katas available are:
      | name              | key               |
      | Fizz Buzz         | fizz_buzz         |
      | String Calculator | string_calculator |

  Scenario: User views available katas
    When I execute the command "list:katas"
    Then I should see in the output:
      """
      +-------------------+-------------------+
      | Key               | Name              |
      +-------------------+-------------------+
      | fizz_buzz         | Fizz Buzz         |
      | string_calculator | String Calculator |
      +-------------------+-------------------+
      """
