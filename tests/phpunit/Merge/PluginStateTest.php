<?php
/**
 * This file is part of the Composer Merge plugin.
 *
 * Copyright (C) 2015 Bryan Davis, Wikimedia Foundation, and contributors
 *
 * This software may be modified and distributed under the terms of the MIT
 * license. See the LICENSE file for details.
 */

namespace Wikimedia\Composer\Merge;

use Composer\Composer;

/**
 * @covers Wikimedia\Composer\Merge\PluginState
 */
class PluginStateTest extends \PHPUnit_Framework_TestCase
{

    public function testLocked()
    {
        $composer = $this->prophesize('Composer\Composer')->reveal();
        $fixture = new PluginState($composer);

        $this->assertFalse($fixture->isLocked());
        $this->assertTrue($fixture->forceUpdate());

        $fixture->setLocked(true);
        $this->assertTrue($fixture->isLocked());
        $this->assertFalse($fixture->forceUpdate());
    }

    public function testDumpAutoloader()
    {
        $composer = $this->prophesize('Composer\Composer')->reveal();
        $fixture = new PluginState($composer);

        $this->assertFalse($fixture->shouldDumpAutoloader());

        $fixture->setDumpAutoloader(true);
        $this->assertTrue($fixture->shouldDumpAutoloader());
    }

    public function testOptimizeAutoloader()
    {
        $composer = $this->prophesize('Composer\Composer')->reveal();
        $fixture = new PluginState($composer);

        $this->assertFalse($fixture->shouldOptimizeAutoloader());

        $fixture->setOptimizeAutoloader(true);
        $this->assertTrue($fixture->shouldOptimizeAutoloader());
    }
}
// vim:sw=4:ts=4:sts=4:et:
