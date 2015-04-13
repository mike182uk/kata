Feature: User can view available programming languages
  In order to know what programming languages a kata can be performed in
  As a user
  I want to be able to view the available programming languages

  Background:
    Given the programming languages available are:
      | name | key  |
      | PHP  | php  |
      | Ruby | ruby |

  Scenario: User views available programming languages
    When I execute the command "list:languages"
    Then I should see in the output:
      """
      +------+------+
      | Name | Key  |
      +------+------+
      | PHP  | php  |
      | Ruby | ruby |
      +------+------+
      """
