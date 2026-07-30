<?php
namespace tests;
use Ably\Defaults;
use Ably\Models\ClientOptions;
use http\Env;

/**
 * @testdox RSC15b
 */
class ClientOptionsTest extends \PHPUnit\Framework\TestCase {
    /**
     * @testdox RSC15e RSC15g3
     */
    public function testWithDefaultOptions() {
        $clientOptions = new ClientOptions();
        self::assertEquals('rest.ably.io', $clientOptions->getPrimaryRestHost());
        self::assertTrue($clientOptions->tls);
        self::assertEquals(443, $clientOptions->tlsPort);
        $fallbackHosts = $clientOptions->getFallbackHosts();
        sort($fallbackHosts);
        $this->assertEquals(Defaults::$fallbackHosts, $fallbackHosts);
    }

    /**
     * @testdox RSC15h
     */
    public function testWithProductionEnvironment() {
        $clientOptions = new ClientOptions();
        $clientOptions->environment = "Production";
        self::assertEquals('rest.ably.io', $clientOptions->getPrimaryRestHost());
        self::assertTrue($clientOptions->tls);
        self::assertEquals(443, $clientOptions->tlsPort);
        $fallbackHosts = $clientOptions->getFallbackHosts();
        sort($fallbackHosts);
        $this->assertEquals(Defaults::$fallbackHosts, $fallbackHosts);
    }

    /**
     * @testdox RSC15g2 RTC1e
     */
    public function testWithCustomEnvironment() {
        $clientOptions = new ClientOptions();
        $clientOptions->environment = "sandbox";
        self::assertEquals('sandbox-rest.ably.io', $clientOptions->getPrimaryRestHost());
        self::assertTrue($clientOptions->tls);
        self::assertEquals(443, $clientOptions->tlsPort);
        $fallbackHosts = $clientOptions->getFallbackHosts();
        sort($fallbackHosts);
        $this->assertEquals(Defaults::getEnvironmentFallbackHosts('sandbox'), $fallbackHosts);
    }

    /**
     * @testdox RSC11b RTN17b RTC1e
     */
    public function testWithCustomEnvironmentAndNonDefaultPorts() {
        $clientOptions = new ClientOptions();
        $clientOptions->environment = "local";
        $clientOptions->port = 8080;
        $clientOptions->tlsPort = 8081;
        self::assertEquals('local-rest.ably.io', $clientOptions->getPrimaryRestHost());
        self::assertEquals(8080, $clientOptions->port);
        self::assertEquals(8081, $clientOptions->tlsPort);
        self::assertTrue($clientOptions->tls);
        $fallbackHosts = $clientOptions->getFallbackHosts();
        self::assertEmpty($fallbackHosts);
    }

    /**
     * @testdox RSC11
     */
    public function testWithCustomRestHost() {
        $clientOptions = new ClientOptions();
        $clientOptions->restHost = "test.org";
        self::assertEquals('test.org', $clientOptions->getPrimaryRestHost());
        self::assertEquals(80, $clientOptions->port);
        self::assertEquals(443, $clientOptions->tlsPort);
        self::assertTrue($clientOptions->tls);
        $fallbackHosts = $clientOptions->getFallbackHosts();
        self::assertEmpty($fallbackHosts);
    }

    /**
     * @testdox RSC15g1
     */
    public function testWithFallbacks() {
        $clientOptions = new ClientOptions();
        $clientOptions->fallbackHosts = ["a.example.com", "b.example.com"];
        self::assertEquals('rest.ably.io', $clientOptions->getPrimaryRestHost());
        self::assertTrue($clientOptions->tls);
        self::assertEquals(443, $clientOptions->tlsPort);
        $fallbackHosts = $clientOptions->getFallbackHosts();
        sort($fallbackHosts);
        self::assertEquals(["a.example.com", "b.example.com"], $fallbackHosts);
    }
}
