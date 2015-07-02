Feature: User does not have to specify programming language to use for kata
  In order to improve my skills in any programming language
  As a user
  I want a random programming language to be selected for me if i do not specify a programming language

  Background:
    Given the programming languages available are:
      | name | key  |
      | PHP  | php  |
      | Ruby | ruby |
    And the programming language templates available are:
      | name          | language | template_src_path           | template_dest_path |
      | composer.json | php      | templates/php/composer.json | composer.json      |
      | Gemfile       | ruby     | templates/ruby/gemfile      | Gemfile            |

  @requiresKataFixtures
  Scenario: User does not specify programming language
    When I execute the command "create:workspace" with the options "path=foo"
    Then a new kata workspace should be created at "foo"
    And the language templates for the randomly selected language should be present in the workspace
