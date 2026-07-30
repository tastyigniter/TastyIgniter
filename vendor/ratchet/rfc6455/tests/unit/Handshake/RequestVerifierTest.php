<?php

namespace Ratchet\RFC6455\Test\Unit\Handshake;

use Ratchet\RFC6455\Handshake\RequestVerifier;
use PHPUnit\Framework\TestCase;

/**
 * @covers Ratchet\RFC6455\Handshake\RequestVerifier
 */
class RequestVerifierTest extends TestCase {
    /**
     * @var RequestVerifier
     */
    protected $_v;

    protected function setUp(): void {
        $this->_v = new RequestVerifier();
    }

    public static function methodProvider(): array {
        return array(
            array(true,  'GET'),
            array(true,  'get'),
            array(true,  'Get'),
            array(false, 'POST'),
            array(false, 'DELETE'),
            array(false, 'PUT'),
            array(false, 'PATCH')
        );
    }
    /**
     * @dataProvider methodProvider
     */
    public function testMethodMustBeGet(bool $result, string $in): void {
        $this->assertEquals($result, $this->_v->verifyMethod($in));
    }

    public static function httpVersionProvider(): array {
        return array(
            array(true,  1.1),
            array(true,  '1.1'),
            array(true,  1.2),
            array(true,  '1.2'),
            array(true,  2),
            array(true,  '2'),
            array(true,  '2.0'),
            array(false, '1.0'),
            array(false, 1),
            array(false, '0.9'),
            array(false, ''),
            array(false, 'hello')
        );
    }

    /**
     * @dataProvider httpVersionProvider
     */
    public function testHttpVersionIsAtLeast1Point1(bool $expected, $in): void {
        $this->assertEquals($expected, $this->_v->verifyHTTPVersion($in));
    }

    public static function uRIProvider(): array {
        return array(
            array(true, '/chat'),
            array(true, '/hello/world?key=val'),
            array(false, '/chat#bad'),
            array(false, 'nope'),
            array(false, '/ ಠ_ಠ '),
            array(false, '/✖'),
            array(false, '')
        );
    }

    /**
     * @dataProvider URIProvider
     */
    public function testRequestUri(bool $expected, string $in): void {
        $this->assertEquals($expected, $this->_v->verifyRequestURI($in));
    }

    public static function hostProvider(): array {
        return array(
            array(true, ['server.example.com']),
            array(false, [])
        );
    }

    /**
     * @dataProvider HostProvider
     */
    public function testVerifyHostIsSet(bool $expected, array $in): void {
        $this->assertEquals($expected, $this->_v->verifyHost($in));
    }

    public static function upgradeProvider(): array {
        return array(
            array(true,  ['websocket']),
            array(true,  ['Websocket']),
            array(true,  ['webSocket']),
            array(false, []),
            array(false, [''])
        );
    }

    /**
     * @dataProvider upgradeProvider
     */
    public function testVerifyUpgradeIsWebSocket(bool $expected, array $val): void {
        $this->assertEquals($expected, $this->_v->verifyUpgradeRequest($val));
    }

    public static function connectionProvider(): array {
        return array(
            array(true,  ['Upgrade']),
            array(true,  ['upgrade']),
            array(true,  ['keep-alive', 'Upgrade']),
            array(true,  ['Upgrade', 'keep-alive']),
            array(true,  ['keep-alive', 'Upgrade', 'something']),
            // as seen in Firefox 47.0.1 - see https://github.com/ratchetphp/RFC6455/issues/14
            array(true,  ['keep-alive, Upgrade']),
            array(true,  ['Upgrade, keep-alive']),
            array(true,  ['keep-alive, Upgrade, something']),
            array(true,  ['keep-alive, Upgrade', 'something']),
            array(false, ['']),
            array(false, [])
        );
    }

    /**
     * @dataProvider connectionProvider
     */
    public function testConnectionHeaderVerification(bool $expected, array $val): void {
        $this->assertEquals($expected, $this->_v->verifyConnection($val));
    }

    public static function keyProvider(): array {
        return array(
            array(true,  ['hkfa1L7uwN6DCo4IS3iWAw==']),
            array(true,  ['765vVoQpKSGJwPzJIMM2GA==']),
            array(true,  ['AQIDBAUGBwgJCgsMDQ4PEC==']),
            array(true,  ['axa2B/Yz2CdpfQAY2Q5P7w==']),
            array(false, [0]),
            array(false, ['Hello World']),
            array(false, ['1234567890123456']),
            array(false, ['123456789012345678901234']),
            array(true,  [base64_encode('UTF8allthngs+✓')]),
            array(true,  ['dGhlIHNhbXBsZSBub25jZQ==']),
            array(false, []),
            array(false, ['dGhlIHNhbXBsZSBub25jZQ==', 'Some other value']),
            array(false, ['Some other value', 'dGhlIHNhbXBsZSBub25jZQ=='])
        );
    }

    /**
     * @dataProvider keyProvider
     */
    public function testKeyIsBase64Encoded16BitNonce(bool $expected, array $val): void {
        $this->assertEquals($expected, $this->_v->verifyKey($val));
    }

    public static function versionProvider(): array {
        return array(
            array(true,  [13]),
            array(true,  ['13']),
            array(false, [12]),
            array(false, [14]),
            array(false, ['14']),
            array(false, ['hi']),
            array(false, ['']),
            array(false, [])
        );
    }

    /**
     * @dataProvider versionProvider
     */
    public function testVersionEquals13(bool $expected, array $in): void {
        $this->assertEquals($expected, $this->_v->verifyVersion($in));
    }
}
