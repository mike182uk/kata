Feature: Developer can specify available programming languages in config file
  In order to make the application aware of the available programming languages automatically
  As a developer
  I want to be able specify the katas in a config file that is loaded by the application

  Scenario: Available programming languages specified in config file
    Given the config file "config.yml" contains:
      """
      languages:
        - { name: PHP, key: php }
        - { name: Ruby, key: ruby }
      """
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
