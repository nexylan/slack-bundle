# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/en/1.0.0/)
and this project adheres to [Semantic Versioning](http://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [2.2.2]
### Fixed
- PSR interfaces issues with php-http/httplug to v1 on update

## [2.2.1]
### Fixed
- Symfony 5 and nexylan/slack 3.0 support
- Rollback to the actual service id as a snake-case version

## [2.2.0]
### Added
- Add client service autowiring

## [2.1.0]
### Added
- Add `sticky_channel` option support

## [2.0.1]
### Fixed
- Symfony 4.2 support for dependency injection

## [2.0.0]
### Added
- nexylan/slack v2 support

### Changed
- PHP strict typing
- Classes are now final

### Removed
- PHP <7.1 support
- Symfony <3.3 support
- nexylan/slack <2 support

## [1.1.2] - 2018-01-18
### Fixed
- Symfony 4 support

## [1.1.1] - 2018-01-17
### Changed
- Now requiring nexylan/slack instead of abandoned maknz/slack.
It will not break anything as the codebase is exactly the same for 1.x.
