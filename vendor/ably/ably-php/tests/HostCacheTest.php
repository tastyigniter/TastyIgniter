<?php
namespace tests;

use Ably\Defaults;
use Ably\HostCache;

/**
 * @testdox RSC15f
 */
class HostCacheTest extends \PHPUnit\Framework\TestCase {

    /**
     * @testdox RSC15f
     */
    public function testHost() {
        $hostCache = new HostCache(3000);
        $hostCache->put(Defaults::$restHost);
        self::assertEquals("rest.ably.io", $hostCache->get());
    }

    /**
     * @testdox RSC15f
     */
    public function testExpiredHost() {
        $hostCache = new HostCache(999);
        $hostCache->put(Defaults::$restHost);
        sleep(1);
        self::assertEquals("", $hostCache->get());
    }
}
