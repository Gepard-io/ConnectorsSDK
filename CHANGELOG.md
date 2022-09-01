# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/en/1.0.0/)

## [0.2.0] - 2022-08-31

### Added

- `AssertHelper` class with callbacks that can be used in connector/query/command string settings to throw exception for
  empty string value if it is not expected.
- Integration tests with example of the library usage by integration public Cat API.

### Changed

- Tests split among "unit" and "integration" ones.
- `productAdded` and `productUpdated` are not set to current date by default and can be changed by Product Builder.
- `releaseDate` is `null` by default.

### Fixed

- **[Breaking change]** Each product feature can contain one or several values (for features with
  type `TYPE_MULTI_SELECT`). Updated `FeatureL10n` class to have `array $values` instead of `string $value`. For feature
  with one value it should contain array with single string value.


## [0.1.0] - 2022-06-29

First public release.
