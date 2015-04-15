Feature: Developer can specify available templates in config file
  In order to make the application aware of the available templates automatically
  As a developer
  I want to be able specify the katas in a config file that is loaded by the application

  @requiresKataFixtures
  Scenario: Available programming languages specified in config file
    Given the config file "config.yml" contains:
      """
      templates:
        - { name: composer.json, language: php, template_src_path: %resources%/templates/php/composer.json, template_dest_path: %workspace%/composer.json }
        - { name: Gemfile, language: ruby, template_src_path: %resources%/templates/ruby/gemfile, template_dest_path: %workspace%/Gemfile }
      """
    And the resource files exist:
      | path                                    | content                       |
      | %resources%/templates/php/composer.json | {}                            |
      | %resources%/templates/ruby/Gemfile      | source 'https://rubygems.org' |
    And the programming languages available are:
      | name | key  |
      | PHP  | php  |
      | Ruby | ruby |
    When I execute the command "create:workspace" with the options "path=foo,--language=php"
    Then a new kata workspace should be created at "foo"
    And the "php" language templates should be present in the workspace
