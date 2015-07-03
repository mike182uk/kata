Feature: Developer can specify available programming languages in config file
  In order to make the application aware of the available programming languages automatically
  As a developer
  I want to be able specify the available programming languages in a config file that is loaded by the application

  Scenario: Available programming languages specified in config file
    Given the config file contains:
      """
      languages:
        -
          name: PHP
          key: php
          package_manager_install_command: composer install
        -
          name: Ruby
          key: ruby
          package_manager_install_command: bundle install
      """
    When I execute the command "list:languages"
    Then I should see in the output:
      """
      +------+------+
      | Key  | Name |
      +------+------+
      | php  | PHP  |
      | ruby | Ruby |
      +------+------+
      """
