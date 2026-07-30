# CHANGELOG

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [6.10.0] - 2026-06-16

### Added
- feat: Add Draft-2019-09 ([#885](https://github.com/jsonrainbow/json-schema/pull/885))


## [6.9.0] - 2026-06-05

### Fixed
- fix: allow "#", "?", and "?#" as valid URI references per RFC 3986 ([#910](https://github.com/jsonrainbow/json-schema/pull/910))
- fix: annotate resolved schemas with dialect-aware id keyword ([#912](https://github.com/jsonrainbow/json-schema/pull/912))

### Added
- fix: treat optional JSON Schema test suite cases as real tests (#913) ([#915](https://github.com/jsonrainbow/json-schema/pull/915))
- feat: add bin/run-test-case to run a single test suite case by description ([#914](https://github.com/jsonrainbow/json-schema/pull/914))


## [6.8.2] - 2026-05-05

### Fixed
- Update to json schema test suite main branch ([#906](https://github.com/jsonrainbow/json-schema/pull/906))

## [6.8.1] - 2026-05-04

### Fixed
- Bump actions/checkout from v4 to v5 was re-applied due to PR merge issues with GitHub ([#902](https://github.com/jsonrainbow/json-schema/pull/902))

## [6.8.0] - 2026-04-02

### Added
- Bump actions/checkout from v4 to v5 ([#902](https://github.com/jsonrainbow/json-schema/pull/902))
- Update readme for draft 7 ([#899](https://github.com/jsonrainbow/json-schema/pull/899))
- ci: Add Copilot setup steps ([#892](https://github.com/jsonrainbow/json-schema/pull/892))

### Fixed
- Fix shell injection in update-changelog workflow for PR titles with backticks ([#897](https://github.com/jsonrainbow/json-schema/pull/897))
- Remove `v` prefix from release tags and GitHub releases ([#895](https://github.com/jsonrainbow/json-schema/pull/895))

### Deprecated
- Deprecate `Constraint::CHECK_MODE_NONE` ([#896](https://github.com/jsonrainbow/json-schema/pull/896))


## [6.7.2] - 2026-02-15

### Fixed
- Fix idn_to_ascii deprecation warning by using INTL_IDNA_VARIANT_UTS46 ([#887](https://github.com/jsonrainbow/json-schema/pull/887))


## [6.7.1] - 2026-02-13

### Fixed
- Fix TypeError in pattern property validation with integer keys ([#880](https://github.com/jsonrainbow/json-schema/pull/880))


## [6.7.0] - 2026-02-13
### Fixed
- Enforce RFC 1035 hostname label length limits in draft 3/4 ([#878](https://github.com/jsonrainbow/json-schema/pull/878))
- UriRetriever: Include actual media type in InvalidSchemaMediaTypeException message ([#872](https://github.com/jsonrainbow/json-schema/pull/872))
- docs: Correct trailing spaces in Markdown ([#873](https://github.com/jsonrainbow/json-schema/pull/873))

### Added
- Feat: Add Draft-07 support ([#847](https://github.com/jsonrainbow/json-schema/pull/847))
- Automate changelog updates on PR merge ([#874](https://github.com/jsonrainbow/json-schema/pull/874))

### Changed
- Add automated release workflow with changelog integration ([#879](https://github.com/jsonrainbow/json-schema/pull/879))
- Fix welcome workflow permission errors from forked PRs ([#875](https://github.com/jsonrainbow/json-schema/pull/875))


## [6.6.4] - 2025-12-19
### Changed
- ci: Run workflows against 5.x.x branches ([#859](https://github.com/jsonrainbow/json-schema/pull/859))
### Fixed
- UriValidator: Allow `file:/` and `file:///` ([#856](https://github.com/jsonrainbow/json-schema/discussions/856))
- Fix .php-cs-fixer.dist.php export-ignore ([#861](https://github.com/jsonrainbow/json-schema/discussions/861))

## [6.6.3] - 2025-12-02
### Changed
- Restricted `mark-mabe/php-enum` dependency to `^4.4` due to lower versions emitting a warning on PHP 8 ([#854](https://github.com/jsonrainbow/json-schema/pull/854))

## [6.6.2] - 2025-11-28
### Changed
- Move PHP 8.5 to default add PHP 8.6 as experimental ([#852](https://github.com/jsonrainbow/json-schema/pull/852))
### Fixed
- Allow underscore and tilde in URI hostnames as per RFC 3986 ([#853](https://github.com/jsonrainbow/json-schema/pull/853))

## [6.6.1] - 2025-11-07
### Changed
- Rename master to main ([#848](https://github.com/jsonrainbow/json-schema/pull/848))
### Fixed
- Don't skip ref expanding for property called enum when child of property called properties ([#851](https://github.com/jsonrainbow/json-schema/pull/851))

## [6.6.0] - 2025-10-10
### Added
- Add lint check for class autoloading PSR compliance ([#845](https://github.com/jsonrainbow/json-schema/pull/845))
- add implementation for strict fully validating using draft-06 schema ([#843](https://github.com/jsonrainbow/json-schema/pull/835))

## [6.5.2] - 2025-09-09
### Fixed
- Fix issue when http headers are already present ([#843](https://github.com/jsonrainbow/json-schema/pull/843))

## [6.5.1] - 2025-08-29
### Changed
- ci: Add PHP 8.5 to pipeline, ignoring dependencies and as experimental ([#842](https://github.com/jsonrainbow/json-schema/pull/842))

## [6.5.0] - 2025-08-29
### Changed
- Update test case to current (PHP) standards ([#831](https://github.com/jsonrainbow/json-schema/pull/831))
- Upgrade test suite to use generators ([#834](https://github.com/jsonrainbow/json-schema/pull/834))
- update to latest json schema test suite ([#821](https://github.com/jsonrainbow/json-schema/pull/821))
### Fixed
- Fix PHP 8.5 $http_response_header deprecation ([#840](https://github.com/jsonrainbow/json-schema/pull/840))

## [6.4.2] - 2025-06-03
### Fixed
- Fix objects are non-unique despite key order ([#819](https://github.com/jsonrainbow/json-schema/pull/819))
- Id's not being resolved and id property affects sibling ref which it should not do ([#828](https://github.com/jsonrainbow/json-schema/pull/828))

### Changed
- Added extra breaking change to UPDATE-6.0.md regarding BaseConstraint::addError signature change ([#823](https://github.com/jsonrainbow/json-schema/pull/823))
- Update constraint class to PHP 7.2 language level ([#824](https://github.com/jsonrainbow/json-schema/pull/824))
- Update base constraint class to PHP 7.2 language level ([#826](https://github.com/jsonrainbow/json-schema/pull/826))

### Added
- Introduce 32 bits CI workflow on latest php version ([#825](https://github.com/jsonrainbow/json-schema/pull/825))

## [6.4.1] - 2025-04-04
### Fixed
- Fix support for 32bits PHP ([#817](https://github.com/jsonrainbow/json-schema/pull/817))

## [6.4.0] - 2025-04-01
### Added
- Run PHPStan using the lowest and highest php version ([#811](https://github.com/jsonrainbow/json-schema/pull/811))
### Fixed
- Use parallel-lint and cs2pr for improved feedback on linting errors ([#812](https://github.com/jsonrainbow/json-schema/pull/812))
- Array with number values with mathematical equality are considered valid ([#813](https://github.com/jsonrainbow/json-schema/pull/813))
### Changed
- Correct PHPStan findings in validator ([#808](https://github.com/jsonrainbow/json-schema/pull/808))
- Add cs2pr handling for php-cs-fixer; avoid doing composer install ([#814](https://github.com/jsonrainbow/json-schema/pull/814))
- prepare PHP 8.5 in CI ([#815](https://github.com/jsonrainbow/json-schema/pull/815))

## [6.3.1] - 2025-03-18
### Fixed
- ensure numeric issues in const are correctly evaluated ([#805](https://github.com/jsonrainbow/json-schema/pull/805))
- fix 6.3.0 regression with comparison of null values during validation ([#806](https://github.com/jsonrainbow/json-schema/issues/806))

## [6.3.0] - 2025-03-14
### Fixed
- only check minProperties or maxProperties on objects ([#802](https://github.com/jsonrainbow/json-schema/pull/802))
- replace filter_var for uri and uri-reference to userland code to be RFC 3986 compliant ([#800](https://github.com/jsonrainbow/json-schema/pull/800))
- avoid duplicate workflow runs ([#804](https://github.com/jsonrainbow/json-schema/pull/804))

## Changed
- replace icecave/parity with custom deep comparator ([#803](https://github.com/jsonrainbow/json-schema/pull/803))

## [6.2.1] - 2025-03-06
### Fixed
- allow items: true to pass validation ([#801](https://github.com/jsonrainbow/json-schema/pull/801))

### Changed
- Include actual count in collection constraint errors ([#797](https://github.com/jsonrainbow/json-schema/pull/797))

## [6.2.0] - 2025-02-26
### Added
- Welcome first time contributors ([#782](https://github.com/jsonrainbow/json-schema/pull/782))

### Fixed
- Add required permissions for welcome action ([#789](https://github.com/jsonrainbow/json-schema/pull/789))
- Upgrade php cs fixer to latest ([#783](https://github.com/jsonrainbow/json-schema/pull/783))
- Create deep copy before checking each sub schema in oneOf ([#791](https://github.com/jsonrainbow/json-schema/pull/791))
- Create deep copy before checking each sub schema in anyOf ([#792](https://github.com/jsonrainbow/json-schema/pull/792))
- Correctly set the schema ID when passing it as assoc array ([#794](https://github.com/jsonrainbow/json-schema/pull/794))
- Create deep copy before checking each sub schema in oneOf when only check_mode_apply_defaults is set ([#795](https://github.com/jsonrainbow/json-schema/pull/795))
- Additional property casted into int when actually is numeric string ([#784](https://github.com/jsonrainbow/json-schema/pull/784))

### Changed
- Used PHPStan's int-mask-of<T> type where applicable ([#779](https://github.com/jsonrainbow/json-schema/pull/779))
- Fixed some PHPStan errors ([#781](https://github.com/jsonrainbow/json-schema/pull/781))
- Cleanup redundant checks ([#796](https://github.com/jsonrainbow/json-schema/pull/796))

## [6.1.0] - 2025-02-04
### Added
- Add return types in the test suite ([#748](https://github.com/jsonrainbow/json-schema/pull/748))
- Add test case for validating array of strings with objects ([#704](https://github.com/jsonrainbow/json-schema/pull/704))
- Add contributing information, contributor recognition and security information ([#771](https://github.com/jsonrainbow/json-schema/pull/771))

### Fixed
- Correct misconfigured mocks in JsonSchema\Tests\Uri\UriRetrieverTest ([#741](https://github.com/jsonrainbow/json-schema/pull/741))
- Fix pugx badges in README ([#742](https://github.com/jsonrainbow/json-schema/pull/742))
- Add missing property in UriResolverTest ([#743](https://github.com/jsonrainbow/json-schema/pull/743))
- Correct casing of paths used in tests ([#745](https://github.com/jsonrainbow/json-schema/pull/745))
- Resolve deprecations of optional parameter ([#752](https://github.com/jsonrainbow/json-schema/pull/752))
- Fix wrong combined paths when traversing upward, fixes #557 ([#652](https://github.com/jsonrainbow/json-schema/pull/652))
- Correct PHPStan baseline ([#764](https://github.com/jsonrainbow/json-schema/pull/764))
- Correct spacing issue in `README.md` ([#763](https://github.com/jsonrainbow/json-schema/pull/763))
- Format attribute: do not validate data instances that aren't the instance type to validate ([#773](https://github.com/jsonrainbow/json-schema/pull/773))

### Changed
- Bump to minimum PHP 7.2 ([#746](https://github.com/jsonrainbow/json-schema/pull/746))
- Replace traditional syntax array with short syntax array ([#747](https://github.com/jsonrainbow/json-schema/pull/747))
- Increase phpstan level to 8 with baseline to swallow existing errors ([#673](https://github.com/jsonrainbow/json-schema/pull/673))
- Add ext-json to composer.json to ensure JSON extension available  ([#759](https://github.com/jsonrainbow/json-schema/pull/759))
- Add visibility modifiers to class constants ([#757](https://github.com/jsonrainbow/json-schema/pull/757))
- Include PHP 8.4 in workflow ([#765](https://github.com/jsonrainbow/json-schema/pull/765))
- Add `strict_types=1` to all classes in ./src ([#758](https://github.com/jsonrainbow/json-schema/pull/758))
- Raise minimum level of marc-mabe/php-enum ([#766](https://github.com/jsonrainbow/json-schema/pull/766))
- Cleanup test from @param annotations ([#768](https://github.com/jsonrainbow/json-schema/pull/768))
- Remove obsolete PHP 7.1 version check ([#772](https://github.com/jsonrainbow/json-schema/pull/772))

## [6.0.0] - 2024-07-30
### Added
- Add URI translation, package:// URI scheme & bundle spec schemas ([#362](https://github.com/jsonrainbow/json-schema/pull/362))
- Add quiet option ([#382](https://github.com/jsonrainbow/json-schema/pull/382))
- Add option to disable validation of "format" constraint ([#383](https://github.com/jsonrainbow/json-schema/pull/383))
- Add more unit tests ([#366](https://github.com/jsonrainbow/json-schema/pull/366))
- Reset errors prior to validation ([#386](https://github.com/jsonrainbow/json-schema/pull/386))
- Allow the schema to be an associative array ([#389](https://github.com/jsonrainbow/json-schema/pull/389))
- Enable FILTER_FLAG_EMAIL_UNICODE for email format if present ([#398](https://github.com/jsonrainbow/json-schema/pull/398))
- Add enum wrapper ([#375](https://github.com/jsonrainbow/json-schema/pull/375))
- Add option to validate the schema ([#357](https://github.com/jsonrainbow/json-schema/pull/357))
- Add support for "const" ([#507](https://github.com/jsonrainbow/json-schema/pull/507))
- Added note about supported Draft versions ([#620](https://github.com/jsonrainbow/json-schema/pull/620))
- Add linting GH action
### Changed
- Centralize errors ([#364](https://github.com/jsonrainbow/json-schema/pull/364))
- Revert "An email is a string, not much else." ([#373](https://github.com/jsonrainbow/json-schema/pull/373))
- Improvements to type coercion ([#384](https://github.com/jsonrainbow/json-schema/pull/384))
- Don't add a file:// prefix to URI that already have a scheme ([#455](https://github.com/jsonrainbow/json-schema/pull/455))
- Enhancement: Normalize` composer.json` ([#505](https://github.com/jsonrainbow/json-schema/pull/505))
- Correct echo `sprintf` for `printf` ([#634](https://github.com/jsonrainbow/json-schema/pull/634))
- Streamline validation of Regex ([#650](https://github.com/jsonrainbow/json-schema/pull/650))
- Streamline validation of patternProperties Regex ([#653](https://github.com/jsonrainbow/json-schema/pull/653))
- Switch to GH Actions ([#670](https://github.com/jsonrainbow/json-schema/pull/670))
- Updated PHPStan
- Remove unwanted whitespace ([#700](https://github.com/jsonrainbow/json-schema/pull/700))
- Bump to v4 versions of GitHub actions ([#722](https://github.com/jsonrainbow/json-schema/pull/722))
- Update references to jsonrainbow ([#725](https://github.com/jsonrainbow/json-schema/pull/725))
### Deprecated
- Mark check() and coerce() as deprecated ([#476](https://github.com/jsonrainbow/json-schema/pull/476))
### Removed
- Remove stale files from #357 (obviated by #362) ([#400](https://github.com/jsonrainbow/json-schema/pull/400))
- Remove unnecessary fallbacks when args accept null
- Removed unused variable in UndefinedConstraint ([#698](https://github.com/jsonrainbow/json-schema/pull/698))
- Remove dead block of code ([#710](https://github.com/jsonrainbow/json-schema/pull/710))
### Fixed
- Add use line for InvalidArgumentException ([#370](https://github.com/jsonrainbow/json-schema/pull/370))
- Add use line for InvalidArgumentException & adjust scope ([#372](https://github.com/jsonrainbow/json-schema/pull/372))
- Add provided schema under a dummy / internal URI (fixes #376) ([#378](https://github.com/jsonrainbow/json-schema/pull/378))
- Don't throw exceptions until after checking anyOf / oneOf ([#394](https://github.com/jsonrainbow/json-schema/pull/394))
- Fix infinite recursion on some schemas when setting defaults (#359) ([#365](https://github.com/jsonrainbow/json-schema/pull/365))
- Fix autoload to work properly with composer dependencies ([#401](https://github.com/jsonrainbow/json-schema/pull/401))
- Ignore $ref siblings & abort on infinite-loop references ([#437](https://github.com/jsonrainbow/json-schema/pull/437))
- Don't cast multipleOf to be an integer for the error message ([#471](https://github.com/jsonrainbow/json-schema/pull/471))
- Strict Enum/Const Object Checking ([#518](https://github.com/jsonrainbow/json-schema/pull/518))
- Return original value when no cast ([#535](https://github.com/jsonrainbow/json-schema/pull/535))
- Allow `marc-mabe/php-enum` v2.x and v3.x. ([#464](https://github.com/jsonrainbow/json-schema/pull/464))
- Deprecated warning message on composer install command ([#614](https://github.com/jsonrainbow/json-schema/pull/614))
- Allow `marc-mabe/php-enum` v4.x ([#629](https://github.com/jsonrainbow/json-schema/pull/629))
- Fixed method convertJsonPointerIntoPropertyPath in wrong class ([#655](https://github.com/jsonrainbow/json-schema/pull/655))
- Fix type validation failing for "any" and false-y type wording ([#686](https://github.com/jsonrainbow/json-schema/pull/686))
- Correct code style
- Fix: Clean up `.gitattributes` ([#687](https://github.com/jsonrainbow/json-schema/pull/687))
- Fix: Order `friendsofphp/php-cs-fixer` rules ([#688](https://github.com/jsonrainbow/json-schema/pull/688))
- HTTP to HTTPS redirection breaks remote reference resolution ([#709](https://github.com/jsonrainbow/json-schema/pull/709))
- Corrected several typos and code style issues
