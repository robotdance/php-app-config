# PHP-App-Config

[![Code Climate](https://codeclimate.com/github/robotdance/php-app-config/badges/gpa.svg)](https://codeclimate.com/github/robotdance/php-app-config)
[![Test Coverage](https://codeclimate.com/github/robotdance/php-app-config/badges/coverage.svg)](https://codeclimate.com/github/robotdance/php-app-config/coverage)
[![Issue Count](https://codeclimate.com/github/robotdance/php-app-config/badges/issue_count.svg)](https://codeclimate.com/github/robotdance/php-app-config)

PHP-app-config is a component to store application/package settings, also capable of storing it per environment if necessary.

## Setup

PHP-app-config uses [Composer](http://getcomposer.org) as dependency management tool.

`$ composer install`

## Use

Create a folder called `config/` at your app/package, and put your YAML `config.yml` file there.
(an example of valid YAML file can found in the source). Then call `Config::get`, in one of the ways below.

### YAML Config file structure

Your YAML config.yml file may look like this:

```yaml
some_setting:
  development: some setting development
  test: some setting test
  production: some setting production

another_setting: another setting without environment
```
This way you can store settings depending on environment or not. Your choice.
In order to have environment specific settings, you must set an environment variable called "ENVIRONMENT",
with a value that can be found at your config file.

### Example

The example below will try to find the key `variable_name.[environment]` at `/config/config.yml`:

```php
use robotdance\Config;
...
$value = Config::get('variable_name');
```

## Running tests

`$ ./bin/phpunit`

## Contribute

Fork, write tests, code, submit pull request. Coverage must remains at 100%.
