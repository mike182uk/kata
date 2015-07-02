Feature: Developer can specify available templates in config file
  In order to make the application aware of the available templates automatically
  As a developer
  I want to be able specify the available templates in a config file that is loaded by the application

  @requiresKataFixtures
  Scenario: Available programming languages specified in config file
    Given the config file contains:
      """
      templates:
        -
          name: composer.json
          language: php
          template_src_path: templates/php/composer.json
          template_dest_path: composer.json
        -
          name: Gemfile
          language: ruby
          template_src_path: templates/ruby/gemfile
          template_dest_path: Gemfile
      """
    And the resource files available are:
      | path                        | content                       |
      | templates/php/composer.json | {}                            |
      | templates/ruby/Gemfile      | source 'https://rubygems.org' |
    And the programming languages available are:
      | name | key  |
      | PHP  | php  |
      | Ruby | ruby |
    When I execute the command "create:workspace" with the options "path=foo,--language=php"
    Then a new kata workspace should be created at "foo"
    And the "php" language templates should be present in the workspace
