Feature: User can see details of the newly created kata workspace
  In order to know that the kata workspace was created successfully
  As a user
  I want to see details of kata when the newly created kata workspace is created

  Background:
    Given the katas available are:
      | name              | key               | requirements_file_path     |
      | Fizz Buzz         | fizz_buzz         | katas/fizz_buzz.md         |
      | String Calculator | string_calculator | katas/string_calculator.md |
    And the programming languages available are:
      | name | key  |
      | PHP  | php  |
    And the programming language templates available are:
      | name          | language | template_src_path           | template_dest_path |
      | composer.json | php      | templates/php/composer.json | composer.json      |

  Scenario: User sees details of newly created kata workspace
    When I execute the command "create:workspace" with the options "path=foo,--kata=fizz_buzz,--language=php"
    Then I should see in the output:
    """
    Kata workspace successfully created at %path% with the kata Fizz Buzz using the language PHP
    """

