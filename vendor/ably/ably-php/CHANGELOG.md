# Change Log

## [1.1.12](https://github.com/ably/ably-php/tree/1.1.12) (2026-06-23)

[Full Changelog](https://github.com/ably/ably-php/compare/1.1.11...1.1.12)

**Fixed bugs:**

- Function curl_close() is deprecated since PHP 8.5, as it has no effect since PHP 8.0

**Merged pull requests:**

- Prevent curl_close() deprecation on PHP 8.5 [\#220](https://github.com/ably/ably-php/pull/220) ([aleeks](https://github.com/aleeks))

## [1.1.11](https://github.com/ably/ably-php/tree/1.1.11) (2025-03-05)

[Full Changelog](https://github.com/ably/ably-php/compare/1.1.10...1.1.11)

**Closed issues:**

- PHP 8.4 Deprecations - Implicitly marking parameter $cipherParams as nullable is deprecated [\#206](https://github.com/ably/ably-php/issues/206)
- Batch publish being sent as JSON rather than msgpack [\#197](https://github.com/ably/ably-php/issues/197)

**Merged pull requests:**

- \[ECO-5183\] Added support for PHP 8.4 [\#210](https://github.com/ably/ably-php/pull/210) ([sacOO7](https://github.com/sacOO7))
- Fix batch publish [\#198](https://github.com/ably/ably-php/pull/198) ([sacOO7](https://github.com/sacOO7))

## [1.1.10](https://github.com/ably/ably-php/tree/1.1.10) (2024-03-22)

[Full Changelog](https://github.com/ably/ably-php/compare/1.1.9...1.1.10)

**Implemented enhancements:**

- update to protocol 2.0 [\#190](https://github.com/ably/ably-php/issues/190)
- Add support for PHP 8.3 [\#187](https://github.com/ably/ably-php/issues/187)

**Closed issues:**

- Fix idempotent rest publishing  [\#192](https://github.com/ably/ably-php/issues/192)
- Laravel notification support [\#39](https://github.com/ably/ably-php/issues/39)

**Merged pull requests:**

- Support protocol 2.0 and php 8.3 [\#191](https://github.com/ably/ably-php/pull/191) ([sacOO7](https://github.com/sacOO7))
- Improve PHP 8.2 compatibility and testing [\#173](https://github.com/ably/ably-php/pull/173) ([AndyTWF](https://github.com/AndyTWF))
- Change nonAESEncryption algorithm in CryptoTest.php [\#171](https://github.com/ably/ably-php/pull/171) ([AmirQSD](https://github.com/AmirQSD))
- Update readme, laravel section [\#170](https://github.com/ably/ably-php/pull/170) ([sacOO7](https://github.com/sacOO7))

## [1.1.9](https://github.com/ably/ably-php/tree/1.1.9) (2022-09-15)

[Full Changelog](https://github.com/ably/ably-php/compare/1.1.8...1.1.9)

**Implemented enhancements:**

- Add support for PHP 8.2 [\#167](https://github.com/ably/ably-php/pulls/167) ([driesvints](https://github.com/driesvints))

## [1.1.8](https://github.com/ably/ably-php/tree/1.1.8) (2022-07-27)

[Full Changelog](https://github.com/ably/ably-php/compare/1.1.7...1.1.8)

**Implemented enhancements:**

- Add support to get channel lifecycle status  [\#155](https://github.com/ably/ably-php/issues/155)
- Add support for MsgPack [\#161](https://github.com/ably/ably-php/pull/161) ([AmirQSD](https://github.com/AmirQSD))

**Merged pull requests:**

- Add support for MsgPack [\#161](https://github.com/ably/ably-php/pull/161) ([AmirQSD](https://github.com/AmirQSD))
- Channel status [\#159](https://github.com/ably/ably-php/pull/159) ([sacOO7](https://github.com/sacOO7))
- Refactor code [\#152](https://github.com/ably/ably-php/pull/152) ([sacOO7](https://github.com/sacOO7))

## [1.1.7](https://github.com/ably/ably-php/tree/1.1.7) (2022-05-19)
[Full Changelog](https://github.com/ably/ably-php/compare/1.1.6...1.1.7)

**Implemented enhancements:**

- Defaults: Generate environment fallbacks [\#87](https://github.com/ably/ably-php/issues/87)

**Fixed bugs:**

- Fallback not being used with SSL timeouts [\#85](https://github.com/ably/ably-php/issues/85)

**Closed issues:**

- php Update urls in readme [\#148](https://github.com/ably/ably-php/issues/148)
- Add support for RSC15e, d, f \(Host Fallback \) [\#111](https://github.com/ably/ably-php/issues/111)
- Implement remembering fallback host during failures [\#107](https://github.com/ably/ably-php/issues/107)

## [1.1.6](https://github.com/ably/ably-php/tree/1.1.6) (2022-03-30)
[Full Changelog](https://github.com/ably/ably-php/compare/1.1.5...1.1.6)

**Implemented enhancements:**

- Implement RSC7d \(Ably-Agent header\) [\#104](https://github.com/ably/ably-php/issues/104)
- Add support for PHP 8.1

**Closed issues:**

- X-Ably-Lib header not being set correctly [\#132](https://github.com/ably/ably-php/issues/132)

**Merged pull requests:**

- PHP 8.1 [\#138](https://github.com/ably/ably-php/pull/138) ([sacOO7](https://github.com/sacOO7))
- Feature/rsc7d ably agent header [\#137](https://github.com/ably/ably-php/pull/137) ([sacOO7](https://github.com/sacOO7))
- Add case insensitive method to http request [\#135](https://github.com/ably/ably-php/pull/135) ([andydunstall](https://github.com/andydunstall))

## [1.1.5](https://github.com/ably/ably-php/tree/1.1.5) (2022-02-23)
[Full Changelog](https://github.com/ably/ably-php/compare/1.1.4...1.1.5)

**Fixed bugs:**

- Using a clientId should no longer be forcing token auth in the 1.1 spec [\#74](https://github.com/ably/ably-php/issues/74)

**Closed issues:**

- Installing removes Symfony-Packages [\#106](https://github.com/ably/ably-php/issues/106)
- The library should not be throwing an exception when a message is sent with different `clientId` from `auth.clientId` [\#101](https://github.com/ably/ably-php/issues/101)
- TokenRequest: timestamp is integer in PHPDoc, string at runtime, Flutter expects int [\#99](https://github.com/ably/ably-php/issues/99)
- Batch Mode, sending multiple messages to multiple channels [\#98](https://github.com/ably/ably-php/issues/98)

**Merged pull requests:**

- Fix setting X-Ably-\* and Accept headers [\#133](https://github.com/ably/ably-php/pull/133) ([lmars](https://github.com/lmars))
- RSL1m4 If clientId is different, error from server [\#103](https://github.com/ably/ably-php/pull/103) ([jdavid](https://github.com/jdavid))
- Allow basic auth with clientId [\#102](https://github.com/ably/ably-php/pull/102) ([jdavid](https://github.com/jdavid))
- Now TokenRequest.timestamp is an integer [\#100](https://github.com/ably/ably-php/pull/100) ([jdavid](https://github.com/jdavid))
- Conform license and copyright [\#97](https://github.com/ably/ably-php/pull/97) ([QuintinWillison](https://github.com/QuintinWillison))

## [1.1.4](https://github.com/ably/ably-php/tree/1.1.4) (2021-03-10)
[Full Changelog](https://github.com/ably/ably-php/compare/1.1.3...1.1.4)

**Implemented enhancements:**

- PHP 8.0 support [\#88](https://github.com/ably/ably-php/issues/88)
- Support Channel\#publish\(Message, params\) [\#83](https://github.com/ably/ably-php/issues/83)

**Fixed bugs:**

- Need to support Push payloads in  publish\(\) [\#82](https://github.com/ably/ably-php/issues/82)

**Closed issues:**

- Trying to get property 'items' of non-object [\#92](https://github.com/ably/ably-php/issues/92)

**Merged pull requests:**

- Support PHP 8.0; Drop 5.6, 7.0 & 7.1 [\#96](https://github.com/ably/ably-php/pull/96) ([jdavid](https://github.com/jdavid))
- Fix test case in local environment [\#95](https://github.com/ably/ably-php/pull/95) ([jdavid](https://github.com/jdavid))
- Amend workflow branch name [\#94](https://github.com/ably/ably-php/pull/94) ([owenpearson](https://github.com/owenpearson))
- Fix parsePaginationHeaders [\#93](https://github.com/ably/ably-php/pull/93) ([jdavid](https://github.com/jdavid))
- Replace Travis with GitHub workflow [\#91](https://github.com/ably/ably-php/pull/91) ([QuintinWillison](https://github.com/QuintinWillison))
- Add maintainers file [\#90](https://github.com/ably/ably-php/pull/90) ([niksilver](https://github.com/niksilver))
- Rename master to main [\#86](https://github.com/ably/ably-php/pull/86) ([QuintinWillison](https://github.com/QuintinWillison))
- RSH1b2 list pagination, test next\(\) [\#81](https://github.com/ably/ably-php/pull/81) ([jdavid](https://github.com/jdavid))

## [1.1.3](https://github.com/ably/ably-php/tree/1.1.3) (2019-10-04)
[Full Changelog](https://github.com/ably/ably-php/compare/1.1.2...1.1.3)

**Implemented enhancements:**

- Add support for extras in publish [\#82](https://github.com/ably/ably-php/issues/82)

## [1.1.2](https://github.com/ably/ably-php/tree/1.1.2) (2019-06-27)
[Full Changelog](https://github.com/ably/ably-php/compare/1.1.1...1.1.2)

**Implemented enhancements:**

- Add support for remembered REST fallback host  [\#60](https://github.com/ably/ably-php/issues/60)

**Merged pull requests:**

- Push [\#80](https://github.com/ably/ably-php/pull/80) ([jdavid](https://github.com/jdavid))
- RSH1c4 and RSH1c5 [\#78](https://github.com/ably/ably-php/pull/78) ([jdavid](https://github.com/jdavid))
- RSH1c2 push-\>admin-\>channelSubscriptions-\>listChannels [\#77](https://github.com/ably/ably-php/pull/77) ([jdavid](https://github.com/jdavid))
- RSH1c1 New push-\>admin-\>channelSubscriptions-\>list\_ [\#76](https://github.com/ably/ably-php/pull/76) ([jdavid](https://github.com/jdavid))
- RSH1c3 New push-\>admin-\>channelSubscriptions-\>save [\#75](https://github.com/ably/ably-php/pull/75) ([jdavid](https://github.com/jdavid))
- RSH1b5 New push.admin.device\_registrations.removeWhere [\#73](https://github.com/ably/ably-php/pull/73) ([jdavid](https://github.com/jdavid))

## [1.1.1](https://github.com/ably/ably-php/tree/1.1.1) (2019-02-19)
[Full Changelog](https://github.com/ably/ably-php/compare/1.1.0...1.1.1)

**Merged pull requests:**

- Known Limitations [\#71](https://github.com/ably/ably-php/pull/71) ([Srushtika](https://github.com/Srushtika))
- Use "https\_proxy" env variable if defined to set the CURLOPT\_PROXY option. [\#54](https://github.com/ably/ably-php/pull/54) ([DamienHarper](https://github.com/DamienHarper))

## [1.1.0](https://github.com/ably/ably-php/tree/1.1.0) (2019-02-13)
[Full Changelog](https://github.com/ably/ably-php/compare/1.0.1...1.1.0)

**Implemented enhancements:**

- Ensure request method accepts UPDATE, PATCH & DELETE verbs [\#57](https://github.com/ably/ably-php/issues/57)

**Closed issues:**

- cURL error: Operation timed out after 10001 milliseconds with 0 out of -1 bytes received [\#62](https://github.com/ably/ably-php/issues/62)
- Idempotent publishing is not enabled in the upcoming 1.1 release [\#61](https://github.com/ably/ably-php/issues/61)
- Add idempotent REST publishing [\#56](https://github.com/ably/ably-php/issues/56)
- Ability to subscribe from the server [\#47](https://github.com/ably/ably-php/issues/47)

**Merged pull requests:**

- RSH1b4 New push.admin.device\_registrations.remove [\#69](https://github.com/ably/ably-php/pull/69) ([jdavid](https://github.com/jdavid))
- RSH1b2 New push.admin.device\_registrations.list\_ [\#68](https://github.com/ably/ably-php/pull/68) ([jdavid](https://github.com/jdavid))
- RSC15f Support for remembered REST fallback host [\#67](https://github.com/ably/ably-php/pull/67) ([jdavid](https://github.com/jdavid))
- New RSH1b1 New push.admin.device\_registrations.get [\#66](https://github.com/ably/ably-php/pull/66) ([jdavid](https://github.com/jdavid))
- RHS1b3 New push.admin.device\_registrations.save [\#65](https://github.com/ably/ably-php/pull/65) ([jdavid](https://github.com/jdavid))
- Add patch [\#64](https://github.com/ably/ably-php/pull/64) ([jdavid](https://github.com/jdavid))
- Idempotent only enabled in 1.2 [\#63](https://github.com/ably/ably-php/pull/63) ([jdavid](https://github.com/jdavid))
- RSH1a New push.admin.publish [\#59](https://github.com/ably/ably-php/pull/59) ([jdavid](https://github.com/jdavid))
- Idempotent [\#58](https://github.com/ably/ably-php/pull/58) ([jdavid](https://github.com/jdavid))
- Add missing `$` to presence history example [\#55](https://github.com/ably/ably-php/pull/55) ([Quezler](https://github.com/Quezler))
- Fix failing tests [\#53](https://github.com/ably/ably-php/pull/53) ([funkyboy](https://github.com/funkyboy))
- Use "http\_proxy" env variable if defined to set the CURLOPT\_PROXY opt… [\#51](https://github.com/ably/ably-php/pull/51) ([DamienHarper](https://github.com/DamienHarper))
- Add supported platforms to README [\#49](https://github.com/ably/ably-php/pull/49) ([funkyboy](https://github.com/funkyboy))
- WIP: Update PHP versions tested on Travis [\#48](https://github.com/ably/ably-php/pull/48) ([funkyboy](https://github.com/funkyboy))

## [1.0.1](https://github.com/ably/ably-php/tree/1.0.1) (2017-05-16)
[Full Changelog](https://github.com/ably/ably-php/compare/1.0.0...1.0.1)

**Implemented enhancements:**

- Fix HttpRequest & HttpRetry timeouts [\#42](https://github.com/ably/ably-php/issues/42)

**Closed issues:**

- 0.9: implement TM3; TP4 \(fromEncoded, fromEncodedArray\) [\#40](https://github.com/ably/ably-php/issues/40)

**Merged pull requests:**

- v1.0.1 update [\#45](https://github.com/ably/ably-php/pull/45) ([jdavid](https://github.com/jdavid))
- Fixes issues \#40 and \#42 [\#44](https://github.com/ably/ably-php/pull/44) ([jdavid](https://github.com/jdavid))

## [1.0.0](https://github.com/ably/ably-php/tree/1.0.0) (2017-03-07)
[Full Changelog](https://github.com/ably/ably-php/compare/0.9.0...1.0.0)

### v1.0 release and upgrade notes from v0.8

- See https://github.com/ably/docs/issues/235

**Implemented enhancements:**

- PaginatedResult hasNext and isLast are attributes [\#41](https://github.com/ably/ably-php/issues/41)

**Closed issues:**

- 1.0 version bump [\#43](https://github.com/ably/ably-php/issues/43)

## [0.9.0](https://github.com/ably/ably-php/tree/0.9.0) (2016-08-12)
[Full Changelog](https://github.com/ably/ably-php/compare/0.8.4...0.9.0)

**Fixed bugs:**

- cURL error: SSL certificate problem: self signed certificate in certificate chain  [\#32](https://github.com/ably/ably-php/issues/32)

**Closed issues:**

- connectionKey attribute for messages [\#35](https://github.com/ably/ably-php/issues/35)
- Add Laravel support [\#33](https://github.com/ably/ably-php/issues/33)

**Merged pull requests:**

- 0.9 compatibility - version HTTP headers, fallbackHosts, request\(\) and decoding interop. test [\#37](https://github.com/ably/ably-php/pull/37) ([bladeSk](https://github.com/bladeSk))
- Added connectionKey to Message, updated README [\#36](https://github.com/ably/ably-php/pull/36) ([bladeSk](https://github.com/bladeSk))

## [0.8.4](https://github.com/ably/ably-php/tree/0.8.4) (2016-03-23)
[Full Changelog](https://github.com/ably/ably-php/compare/0.8.3...0.8.4)

**Implemented enhancements:**

- Review PHP docs [\#30](https://github.com/ably/ably-php/issues/30)
- New Crypto Spec [\#29](https://github.com/ably/ably-php/issues/29)

**Fixed bugs:**

- Mac mismatch - possible timezone issue? [\#26](https://github.com/ably/ably-php/issues/26)
- Spec references [\#19](https://github.com/ably/ably-php/issues/19)

**Merged pull requests:**

- Updated Crypto and CipherParams [\#31](https://github.com/ably/ably-php/pull/31) ([bladeSk](https://github.com/bladeSk))

## [0.8.3](https://github.com/ably/ably-php/tree/0.8.3) (2016-02-17)
[Full Changelog](https://github.com/ably/ably-php/compare/0.8.2...0.8.3)

**Fixed bugs:**

- Token reissue bug fix [\#25](https://github.com/ably/ably-php/issues/25)

**Merged pull requests:**

- Fixed bug with createTokenRequest not working on some PHP configs [\#28](https://github.com/ably/ably-php/pull/28) ([bladeSk](https://github.com/bladeSk))

## [0.8.2](https://github.com/ably/ably-php/tree/0.8.2) (2016-01-14)
[Full Changelog](https://github.com/ably/ably-php/compare/0.8.1...0.8.2)

**Implemented enhancements:**

- Travis version support [\#21](https://github.com/ably/ably-php/issues/21)
- 0.8.x finalisation [\#20](https://github.com/ably/ably-php/issues/20)
- Switch arity of auth methods [\#16](https://github.com/ably/ably-php/issues/16)

**Fixed bugs:**

- Do not persist authorise attributes force & timestamp  [\#23](https://github.com/ably/ably-php/issues/23)
- Travis version support [\#21](https://github.com/ably/ably-php/issues/21)
- Switch arity of auth methods [\#16](https://github.com/ably/ably-php/issues/16)

**Merged pull requests:**

- Moved `force` parameter out of authorise\(\) to AuthOptions [\#24](https://github.com/ably/ably-php/pull/24) ([bladeSk](https://github.com/bladeSk))
- Fixed clientId handling [\#22](https://github.com/ably/ably-php/pull/22) ([bladeSk](https://github.com/bladeSk))

## [0.8.1](https://github.com/ably/ably-php/tree/0.8.1) (2015-12-15)
[Full Changelog](https://github.com/ably/ably-php/compare/0.8.0...0.8.1)

**Implemented enhancements:**

- Bring inline with latest 0.8.\* spec [\#15](https://github.com/ably/ably-php/issues/15)
- Spec validation [\#10](https://github.com/ably/ably-php/issues/10)
- Consistent README [\#8](https://github.com/ably/ably-php/issues/8)
- API changes Apr 2015 [\#7](https://github.com/ably/ably-php/issues/7)

**Fixed bugs:**

- Presence test is failing [\#13](https://github.com/ably/ably-php/issues/13)
- API changes Apr 2015 [\#7](https://github.com/ably/ably-php/issues/7)

**Closed issues:**

- Support message encoding/decoding [\#1](https://github.com/ably/ably-php/issues/1)

**Merged pull requests:**

- V0.8 spec update [\#18](https://github.com/ably/ably-php/pull/18) ([bladeSk](https://github.com/bladeSk))
- Updates to exactly match the new 0.8 spec [\#17](https://github.com/ably/ably-php/pull/17) ([bladeSk](https://github.com/bladeSk))

## [0.8.0](https://github.com/ably/ably-php/tree/0.8.0) (2015-05-18)
**Implemented enhancements:**

- Rename to ably-php-rest [\#4](https://github.com/ably/ably-php/issues/4)

**Merged pull requests:**

- Demo, bug fixes, Heroku [\#12](https://github.com/ably/ably-php/pull/12) ([bladeSk](https://github.com/bladeSk))
- More tweaks to match the spec [\#11](https://github.com/ably/ably-php/pull/11) ([bladeSk](https://github.com/bladeSk))
- Complete functionality [\#9](https://github.com/ably/ably-php/pull/9) ([bladeSk](https://github.com/bladeSk))
- ably-common integration [\#6](https://github.com/ably/ably-php/pull/6) ([bladeSk](https://github.com/bladeSk))
- PresenceMessage decoding and tests + namespace/Composer rewrite [\#5](https://github.com/ably/ably-php/pull/5) ([bladeSk](https://github.com/bladeSk))
- Update readme and add travis [\#3](https://github.com/ably/ably-php/pull/3) ([kouno](https://github.com/kouno))
- Presence tests and channel pagination [\#2](https://github.com/ably/ably-php/pull/2) ([bladeSk](https://github.com/bladeSk))



\* *This Change Log was automatically generated by [github_changelog_generator](https://github.com/skywinder/Github-Changelog-Generator)*
