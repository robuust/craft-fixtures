## 1.1.2 - 2020-06-21
### Changed
- Added PHP8 support

## 1.1.1 - 2019-04-24
### Fixed
- Fixtures that had any other status than enabled/live did not unload.

## 1.1.0 - 2019-04-17
### Added
- Makes site id a primary key for all fixtures

## 1.0.17 - 2019-04-17
### Added
- Added ways to get site id's in fixtures

## 1.0.16 - 2019-04-16
### Fixed
- Fixed issue with multisite Singles

## 1.0.15 - 2019-03-27
### Fixed
- Fixed issue with Assets in tests

## 1.0.14 - 2019-03-27
### Changed
- Also hard delete from fixtures store, for tests

## 1.0.13 - 2019-03-27
### Added
- Added Product Variant errors when saving Product fixtures

## 1.0.12 - 2019-03-26
### Changed
- Only hard delete via controller actions, not directly in fixture itself

## 1.0.11 - 2019-03-13
### Fixed
- Make sure product variants are always fully unloaded

## 1.0.10 - 2019-03-11
### Added
- Added support for Commerce Product fixtures

## 1.0.9 - 2019-02-08
### Added
- Added ways to get volume/folder id's in Asset fixtures

### Fixed
- Register before delete event listener only once
- Added compatibility for Craft 3.0.x

## 1.0.8 - 2019-02-08
### Fixed
- Force hard delete when deleting elements

## 1.0.7 - 2019-02-04
### Added
- Added support for User fixtures

## 1.0.6 - 2018-11-15
### Added
- Added support for Tag fixtures

## 1.0.5 - 2018-11-15
### Added
- Added support for GlobalSet fixtures

## 1.0.4 - 2018-11-13
### Added
- Extracted saveElement and deleteElement into methods

### Fixed
- Escape comma's when looking up elements so it is always an exact match

## 1.0.3 - 2018-10-01
### Added
- Added Codeception 2.5 compatibility

## 1.0.2 - 2018-08-25
### Added
- Added test helpers

## 1.0.1 - 2018-08-17
### Added
- The plugin now registers the necessary console controllers
- Added plugin icon
- Improved README

## 1.0.0 - 2018-08-16
### Added
- Initial release
