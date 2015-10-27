<?php
/**
 * This file is part of the Composer Merge plugin.
 *
 * Copyright (C) 2015 Bryan Davis, Wikimedia Foundation, and contributors
 *
 * This software may be modified and distributed under the terms of the MIT
 * license. See the LICENSE file for details.
 */

namespace Wikimedia\Composer;

use Composer\IO\IOInterface;
use Prophecy\Argument;

/**
 * @covers Wikimedia\Composer\Logger
 */
class LoggerTest extends \PHPUnit_Framework_TestCase
{

    public function testVeryVerboseDebug()
    {
        $output = array();
        $io = $this->prophesize('Composer\IO\IOInterface');
        $io->isVeryVerbose()->willReturn(true)->shouldBeCalled();
        $io->writeError(Argument::type('string'))->will(
            function ($args) use (&$output) {
                $output[] = $args[0];
            }
        )->shouldBeCalled();
        $io->write(Argument::type('string'))->shouldNotBeCalled();

        $fixture = new Logger('test', $io->reveal());
        $fixture->debug('foo');
        $this->assertEquals(1, count($output));
        $this->assertContains('<info>[test]</info>', $output[0]);
    }

    public function testNotVeryVerboseDebug()
    {
        $output = array();
        $io = $this->prophesize('Composer\IO\IOInterface');
        $io->isVeryVerbose()->willReturn(false)->shouldBeCalled();
        $io->writeError(Argument::type('string'))->shouldNotBeCalled();
        $io->write(Argument::type('string'))->shouldNotBeCalled();

        $fixture = new Logger('test', $io->reveal());
        $fixture->debug('foo');
    }

    public function testVerboseInfo()
    {
        $output = array();
        $io = $this->prophesize('Composer\IO\IOInterface');
        $io->isVerbose()->willReturn(true)->shouldBeCalled();
        $io->writeError(Argument::type('string'))->will(
            function ($args) use (&$output) {
                $output[] = $args[0];
            }
        )->shouldBeCalled();
        $io->write(Argument::type('string'))->shouldNotBeCalled();

        $fixture = new Logger('test', $io->reveal());
        $fixture->info('foo');
        $this->assertEquals(1, count($output));
        $this->assertContains('<info>[test]</info>', $output[0]);
    }

    public function testNotVerboseInfo()
    {
        $output = array();
        $io = $this->prophesize('Composer\IO\IOInterface');
        $io->isVerbose()->willReturn(false)->shouldBeCalled();
        $io->writeError(Argument::type('string'))->shouldNotBeCalled();
        $io->write(Argument::type('string'))->shouldNotBeCalled();

        $fixture = new Logger('test', $io->reveal());
        $fixture->info('foo');
    }

    public function testWarning()
    {
        $output = array();
        $io = $this->prophesize('Composer\IO\IOInterface');
        $io->writeError(Argument::type('string'))->will(
            function ($args) use (&$output) {
                $output[] = $args[0];
            }
        )->shouldBeCalled();
        $io->write(Argument::type('string'))->shouldNotBeCalled();

        $fixture = new Logger('test', $io->reveal());
        $fixture->warning('foo');
        $this->assertEquals(1, count($output));
        $this->assertContains('<error>[test]</error>', $output[0]);
    }
}
// vim:sw=4:ts=4:sts=4:et:
