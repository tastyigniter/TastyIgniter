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
 * @coversDefaultClass Wikimedia\Composer\Merge\NestedArray
 */
class NestedArrayTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers ::mergeDeep
     * @covers ::mergeDeepArray
     */
    public function testMergeDeepArray()
    {
        $link_options_1 = array(
            'fragment' => 'x',
            'attributes' => array('title' => 'X', 'class' => array('a', 'b')),
            'language' => 'en',
        );
        $link_options_2 = array(
            'fragment' => 'y',
            'attributes' => array('title' => 'Y', 'class' => array('c', 'd')),
            'absolute' => true,
        );
        $expected = array(
            'fragment' => 'y',
            'attributes' => array(
                'title' => 'Y', 'class' => array('a', 'b', 'c', 'd')
            ),
            'language' => 'en',
            'absolute' => true,
        );
        $this->assertSame(
            $expected,
            NestedArray::mergeDeepArray(
                array($link_options_1, $link_options_2)
            ),
            'NestedArray::mergeDeepArray() returned a properly merged array.'
        );
        // Test wrapper function, NestedArray::mergeDeep().
        $this->assertSame(
            $expected,
            NestedArray::mergeDeep($link_options_1, $link_options_2),
            'NestedArray::mergeDeep() returned a properly merged array.'
        );
    }

    /**
     * Tests that arrays with implicit keys are appended, not merged.
     *
     * @covers ::mergeDeepArray
     */
    public function testMergeImplicitKeys()
    {
        $a = array(
            'subkey' => array('X', 'Y'),
        );
        $b = array(
            'subkey' => array('X'),
        );
        // Drupal core behavior.
        $expected = array(
            'subkey' => array('X', 'Y', 'X'),
        );
        $actual = NestedArray::mergeDeepArray(array($a, $b));
        $this->assertSame(
            $expected,
            $actual,
            'mergeDeepArray creates new numeric keys in the implicit sequence.'
        );
    }

    /**
     * Tests that even with explicit keys, values are appended, not merged.
     *
     * @covers ::mergeDeepArray
     */
    public function testMergeExplicitKeys()
    {
        $a = array(
            'subkey' => array(
                0 => 'A',
                1 => 'B',
            ),
        );
        $b = array(
            'subkey' => array(
                0 => 'C',
                1 => 'D',
            ),
        );
        // Drupal core behavior.
        $expected = array(
            'subkey' => array(
                0 => 'A',
                1 => 'B',
                2 => 'C',
                3 => 'D',
            ),
        );
        $actual = NestedArray::mergeDeepArray(array($a, $b));
        $this->assertSame(
            $expected,
            $actual,
            'mergeDeepArray creates new numeric keys in the explicit sequence.'
        );
    }

    /**
     * Tests that array keys values on the first array are ignored when merging.
     *
     * Even if the initial ordering would place the data from the second array
     * before those in the first one, they are still appended, and the keys on
     * the first array are deleted and regenerated.
     *
     * @covers ::mergeDeepArray
     */
    public function testMergeOutOfSequenceKeys()
    {
        $a = array(
            'subkey' => array(
                10 => 'A',
                30 => 'B',
            ),
        );
        $b = array(
            'subkey' => array(
                20 => 'C',
                0 => 'D',
            ),
        );
        // Drupal core behavior.
        $expected = array(
            'subkey' => array(
                0 => 'A',
                1 => 'B',
                2 => 'C',
                3 => 'D',
            ),
        );
        $actual = NestedArray::mergeDeepArray(array($a, $b));
        $this->assertSame(
            $expected,
            $actual,
            'mergeDeepArray ignores numeric key order when merging.'
        );
    }
}
// vim:sw=4:ts=4:sts=4:et:
