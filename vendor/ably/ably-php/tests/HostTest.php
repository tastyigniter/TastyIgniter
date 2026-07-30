<?php
namespace tests;

use Ably\Host;
use Ably\Models\ClientOptions;

/**
 * @testdox RSC15
 */
class HostTest extends \PHPUnit\Framework\TestCase {

    /**
     * @testdox RSA15a, RSC15b, RSC15e
     */
    public function testFallbacksInRandomOrder() {
        $clientOptions = new ClientOptions();
        $restHosts = new Host($clientOptions);
        // All expected hosts supposed to be tried upon
        $expectedFallbackHosts = [
			"a.ably-realtime.com",
			"b.ably-realtime.com",
			"c.ably-realtime.com",
			"d.ably-realtime.com",
			"e.ably-realtime.com",
		];

        $prefHost = $restHosts->getPreferredHost();
        self::assertEquals("rest.ably.io", $prefHost);

        $fallbacks = iterator_to_array($restHosts->fallbackHosts($prefHost));
        self::assertNotEquals($expectedFallbackHosts, $fallbacks);

        sort($fallbacks);
        self::assertEquals($expectedFallbackHosts, $fallbacks);
    }

    /**
     * @testdox RSC15a, RSA15e, RSC15f
     */
    public function testFallbacksOtherThanPreferredHost() {
        $clientOptions = new ClientOptions();
        $restHosts = new Host($clientOptions);
        // All expected hosts supposed to be tried upon
        $expectedFallbackHosts = [
            "rest.ably.io",
            "a.ably-realtime.com",
            "c.ably-realtime.com",
            "d.ably-realtime.com",
            "e.ably-realtime.com",
        ];

        $restHosts->setPreferredHost("b.ably-realtime.com");

        $prefHost = $restHosts->getPreferredHost();
        self::assertEquals("b.ably-realtime.com", $prefHost);

        $fallbacks = iterator_to_array($restHosts->fallbackHosts($prefHost));
        self::assertEquals("rest.ably.io", $fallbacks[0]);

        sort($fallbacks);
        sort($expectedFallbackHosts);
        self::assertEquals($expectedFallbackHosts, $fallbacks);
    }

    /**
     * @testdox RSC15a
     */
    public function testGetAllFallbacksWithNoPreferredHost() {
        $clientOptions = new ClientOptions();
        $restHosts = new Host($clientOptions);
        // All expected hosts supposed to be tried upon
        $expectedFallbackHosts = [
            "rest.ably.io",
            "b.ably-realtime.com",
            "a.ably-realtime.com",
            "c.ably-realtime.com",
            "d.ably-realtime.com",
            "e.ably-realtime.com",
        ];

        $fallbacks = iterator_to_array($restHosts->fallbackHosts(""));
        self::assertEquals("rest.ably.io", $fallbacks[0]);

        sort($fallbacks);
        sort($expectedFallbackHosts);
        self::assertEquals($expectedFallbackHosts, $fallbacks);
    }

    /**
     * @testdox RSC15e
     */
    public function testGetPrimaryHostIfNothingIsCached() {
        $clientOptions = new ClientOptions();
        $restHosts = new Host($clientOptions);
        $prefHost = $restHosts->getPreferredHost();
        self::assertEquals("rest.ably.io", $prefHost);
    }
}

