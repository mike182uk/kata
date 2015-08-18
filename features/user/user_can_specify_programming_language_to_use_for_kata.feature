Feature: User can specify programming language to use for kata
  In order to improve my skills in a specific programming language
  As a user
  I want to be able to specify the programming language to use for the kata

  Background:
    Given the programming languages available are:
      | name | key  |
      | PHP  | php  |
    And the programming language templates available are:
      | name          | language | template_src_path           | template_dest_path |
      | composer.json | php      | templates/php/composer.json | composer.json      |

  @requiresKataFixtures
  Scenario: User specifies programming language
    When I execute the command "create:workspace" with the options "path=foo,--language=php"
    Then a new kata workspace should be created at "foo"
    And the "php" language templates should be present in the workspace

  @requiresKataFixtures
  Scenario: User specifies programming language using the shorthand language option
    When I execute the command "create:workspace" with the options "path=foo,-l=php"
    Then a new kata workspace should be created at "foo"
    And the "php" language templates should be present in the workspace

  @requiresKataFixtures
  Scenario: User specifies invalid language
    When I execute the command "create:workspace" with the options "path=foo,--language=hph"
    Then I should see in the output:
      """
      The language "hph" is not a valid language. Please specify a valid language.
      """
    And a new kata workspace should not be created at "foo"
