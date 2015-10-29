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

use Composer\Package\BasePackage;

/**
 * @covers Wikimedia\Composer\Merge\StabilityFlags
 */
class StabilityFlagsTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @dataProvider provideExplicitStability
     */
    public function testExplicitStability($version, $expect)
    {
        $fixture = new StabilityFlags();
        $got = $fixture->extractAll(array(
            'test' => $this->makeLink($version)->reveal(),
        ));
        $this->assertSame($expect, $got['test']);
    }

    public function provideExplicitStability()
    {
        return array(
            '@dev' => array('1.0@dev', BasePackage::STABILITY_DEV),
            'dev-' => array('dev-master', BasePackage::STABILITY_DEV),
            '-dev' => array('dev-master#2eb0c09', BasePackage::STABILITY_DEV),
            '@alpha' => array('1.0@alpha', BasePackage::STABILITY_ALPHA),
            '@beta' => array('1.0@beta', BasePackage::STABILITY_BETA),
            '@RC' => array('1.0@RC', BasePackage::STABILITY_RC),
            '@stable' => array('1.0@stable', BasePackage::STABILITY_STABLE),
            '-dev & stable' => array(
                '1.0-dev as 1.0.0, 2.0', BasePackage::STABILITY_DEV
            ),
            '@dev | stable' => array(
                '1.0@dev || 2.0', BasePackage::STABILITY_DEV
            ),
            '@rc | @beta' => array(
                '1.0@rc || 2.0@beta', BasePackage::STABILITY_BETA
            ),
        );
    }


    /**
     * @dataProvider provideLowestWins
     */
    public function testLowestWins($version, $default, $expect)
    {
        $fixture = new StabilityFlags(array(
            'test' => BasePackage::STABILITY_ALPHA,
        ));
        $got = $fixture->extractAll(array(
            'test' => $this->makeLink('@rc')->reveal(),
        ));
        $this->assertSame(BasePackage::STABILITY_ALPHA, $got['test']);
    }

    public function provideLowestWins()
    {
        return array(
            'default' => array(
                '1.0@RC',
                BasePackage::STABILITY_BETA,
                BasePackage::STABILITY_BETA
            ),
            'default' => array(
                '1.0@dev',
                BasePackage::STABILITY_BETA,
                BasePackage::STABILITY_DEV
            ),
        );
    }

    protected function makeLink($version)
    {
        $link = $this->prophesize('Composer\Package\Link');
        $link->getPrettyConstraint()->willReturn($version)->shouldBeCalled();
        return $link;
    }
}
// vim:sw=4:ts=4:sts=4:et:
