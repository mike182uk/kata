Feature: User does not have to manually run package manager install command
  In order to speed up the time in setting up a kata workspace
  As a user
  I want the package manager for the selected language to run the install command once the kata workspace has been created

  Background:
    Given the programming languages available are:
      | name | key  | package_manager_install_command |
      | PHP  | php  | composer install                |
    And the programming language templates available are:
      | name          | language | template_src_path           | template_dest_path |
      | composer.json | php      | templates/php/composer.json | composer.json      |
    And the resource file "templates/php/composer.json" contains:
      """
      {
        "require": {
          "php": ">=5.5"
        }
      }
      """

  @requiresKataFixtures
  Scenario: User does not have to manually run package manager install command when creating a new workspace
    When I execute the command "create:workspace" with the options "path=foo,--language=php"
    Then a new kata workspace should be created at "foo"
    And the install command for the "php" package manager should have been run

  @requiresKataFixtures
  Scenario: User sees that package manager is installing dependencies
    When I execute the command "create:workspace" with the options "path=foo,--language=php"
    Then I should see in the output:
    """
    Installing dependencies...
    """
