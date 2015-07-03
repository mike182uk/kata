Feature: User does not have to manually run package manager install command
  In order to speed up the time in setting up a kata workspace
  As a user
  I want the package manager for the selected language to run the install command once the kata workspace has been created

  Background:
    Given the programming languages available are:
      | name | key  | package_manager_install_command        |
      | PHP  | php  | composer install                        |
      | Ruby | ruby | bundle install --path vendor --binstubs |
    And the programming language templates available are:
      | name          | language | template_src_path           | template_dest_path |
      | composer.json | php      | templates/php/composer.json | composer.json      |
      | Gemfile       | ruby     | templates/ruby/gemfile      | Gemfile            |
    And the resource file "templates/php/composer.json" contains:
      """
      {
        "require": {
          "php": ">=5.5"
        }
      }
      """
    And the resource file "templates/ruby/Gemfile" contains:
      """
      source "https://rubygems.org"

      gem "rspec"
      """

  @requiresKataFixtures
  Scenario Outline: User does not have to manually run package manager install command when creating a new workspace
    When I execute the command "create:workspace" with the options "path=foo,--language=<language>"
    Then a new kata workspace should be created at "foo"
    And the install command for the "<language>" package manager should have been run

    Examples:
      | language |
      | php      |
      | ruby     |

  @requiresKataFixtures
  Scenario: User sees that package manager is installing dependencies
    When I execute the command "create:workspace" with the options "path=foo,--language=php"
    Then I should see in the output:
    """
    Installing dependencies...
    """
