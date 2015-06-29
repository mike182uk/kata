Feature: User can view available katas
  In order to know what katas can be performed
  As a user
  I want to be able to view the available katas

  Background:
    Given the katas available are:
      | name              | key               | summary                |
      | Fizz Buzz         | fizz_buzz         | Fizz Buzz Kata         |
      | String Calculator | string_calculator | String Calculator Kata |

  Scenario: User views available katas
    When I execute the command "list:katas"
    Then I should see in the output:
      """
      +-------------------+-------------------+------------------------+
      | Key               | Name              | Summary                |
      +-------------------+-------------------+------------------------+
      | fizz_buzz         | Fizz Buzz         | Fizz Buzz Kata         |
      | string_calculator | String Calculator | String Calculator Kata |
      +-------------------+-------------------+------------------------+
      """
