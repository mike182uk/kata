Feature: Developer can specify available katas in config file
  In order to make the application aware of the available katas automatically
  As a developer
  I want to be able specify the available katas in a config file that is loaded by the application

  Scenario: Available katas specified in config file
    Given the config file contains:
      """
      katas:
        -
          name: Fizz Buzz
          key: fizz_buzz
          requirements_file_path: katas/fizz_buzz.md
        -
          name: String Calculator
          key: string_calculator
          requirements_file_path: katas/string_calculator.md
      """
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
