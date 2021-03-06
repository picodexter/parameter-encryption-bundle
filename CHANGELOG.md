# Changelog

This project adheres to [Semantic Versioning](http://semver.org/).

## (Unreleased)

### Added

*   (empty)

### Changed

*   PHP CS Fixer: Replaced rule sets "@PHP70Migration" and "@PHP70Migration:risky" with "@PHP71Migration" and
    "@PHP71Migration:risky"

### Deprecated

*   (empty)

### Removed

*   (empty)

### Fixed

*   (empty)

### Security

*   (empty)

## 1.2.0 (2019-01-14)

### Added

*   Added Composer dev package "symfony/phpunit-bridge" to enable deprecation notices for tests
*   Added strict typing

### Changed

*   Made minor improvements in Travis CI configuration
*   PHP CS Fixer: Replaced rule set PHP56Migration with PHP70Migration and PHP70Migration:risky
*   Set error_reporting level for tests to -1
*   Updated Travis CI configuration for PHP 5.6 (end of life), PHP 7.0 (end of life), PHP 7.3 (new default) and HHVM (no longer supports PHP)
*   Updated Travis CI configuration to use new Coveralls Composer package and version (2.1)
*   Upgraded to PHPUnit 6.2+

### Removed

*   Removed support for PHP 5.6 and 7.0 (reached end of life)

### Fixed

*   Fixed deprecations when instantiating TreeBuilder in Configuration
*   PHP CS Fixer: Applied native constant invocation and native function invocation

## 1.1.1 (2018-03-06)

### Added

*   Added support for resolving Symfony parameters using environment placeholders (Symfony 3.2+)
*   Added rewriting Doctrine configuration key "url" (Symfony 4.0+)
*   Added Composer scripts for PHPUnit
*   Added Composer scripts for PHP CS Fixer

## 1.1.0 (2018-01-20)

### Added

*   Added support for Symfony version 4.x
*   Added support for symfony/console version 4.x

## 1.0.2 (2018-01-20)

### Fixed

*   Set visibility for console command services to public to prevent an exception in older Symfony versions when
    executing the commands

## 1.0.1 (2017-07-05)

### Added

*   Added Bundle Configuration Service Definition Rewriting feature to replace encrypted parameters in service
    definitions, which originally got their arguments from bundle configurations, with their decrypted counterparts.

    You can find more on this topic in the new
    [Bundle Configuration Service Definition Rewriting documentation page](Resources/doc/bundle-configuration-service-definition-rewriting.rst).

### Removed

*   Removed PHP CS Fixer dist config file from Git exports
*   Removed PHPUnit dist config file from Git exports

### Fixed

*   Fixed interpretation of priority value for service tag "pcdx_parameter_encryption.crypto.key_must_not_be_empty"

## 1.0.0 (2017-06-21)

*   Initial release
