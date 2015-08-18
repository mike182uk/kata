Feature: User can run package manager install command manually
  In order to specify extra dependencies required for the kata
  As a user
  I want to be able to prevent the package manager install command from running when creating the kata workspace

  Background:
    Given the programming languages available are:
      | name | key  |
      | PHP  | php  |

  @requiresKataFixtures @requiresLanguageFixtures
  Scenario: Package manager install command is not run
    When I execute the command "create:workspace" with the options "path=foo,--no-deps"
    Then a new kata workspace should be created at "foo"
    And the install command for the "php" package manager should not have been run
