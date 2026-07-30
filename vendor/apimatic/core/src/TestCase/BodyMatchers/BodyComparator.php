<?php

declare(strict_types=1);

namespace Core\TestCase\BodyMatchers;

use Core\Utils\CoreHelper;

class BodyComparator
{
    private $allowExtra;
    private $isOrdered;
    private $checkValues;
    private $nativeMatching;

    /**
     * @param bool  $allowExtra     Are extra elements allowed in right array?
     * @param bool  $isOrdered      Should elements in right array be compared in order to the left array?
     * @param bool  $checkValues    Check primitive values for equality?
     * @param bool  $nativeMatching Should check arrays natively? i.e. allowExtra can be applied
     *                              on either expected list or actual list
     */
    public function __construct(
        bool $allowExtra = true,
        bool $isOrdered = false,
        bool $checkValues = true,
        bool $nativeMatching = false
    ) {
        $this->allowExtra = $allowExtra;
        $this->isOrdered = $isOrdered;
        $this->checkValues = $checkValues;
        $this->nativeMatching = $nativeMatching;
    }

    /**
     * Recursively check whether the expected value is a proper subset of the right value
     *
     * @param mixed $expected Expected value
     * @param mixed $actual   Actual value
     *
     * @return bool True if Expected is a subset of Actual
     */
    public function compare($expected, $actual): bool
    {
        $bothNull = $this->checkForNull($expected, $actual);
        if (isset($bothNull)) {
            return !$this->checkValues || $bothNull;
        }
        $expected = $this->convertObjectToArray($expected);
        $actual = $this->convertObjectToArray($actual);
        $bothEqualPrimitive = $this->checkForPrimitive($expected, $actual);
        if (isset($bothEqualPrimitive)) {
            return !$this->checkValues || $bothEqualPrimitive;
        }
        // Return false if size different and checking was strict
        if (!$this->allowExtra && count($expected) != count($actual)) {
            return false;
        }
        if (!CoreHelper::isAssociative($expected)) {
            // If expected array is indexed, actual array should also be indexed
            if (CoreHelper::isAssociative($actual)) {
                return !$this->checkValues;
            }
            if ($this->nativeMatching && $this->allowExtra && count($expected) > count($actual)) {
                // Special IndexedArray case:
                // replacing expected with actual, as expected array has more
                // elements and can not be proper subset of actual array
                $tempLeft = $expected;
                $expected = $actual;
                $actual = $tempLeft;
            }
            return !$this->checkValues || $this->isListProperSubsetOf($expected, $actual);
        }
        // If expected value is tree, actual value should also be tree
        if (!CoreHelper::isAssociative($actual)) {
            return !$this->checkValues;
        }
        $actualKeyNumber = 0;
        $success = true;
        array_walk($expected, function ($expectedInner, $key) use ($actual, &$actualKeyNumber, &$success): void {
            if (!$success) {
                return;
            }
            // Check if key exists
            if (!array_key_exists($key, $actual)) {
                $success = false;
                return;
            }
            if ($this->isOrdered) {
                $actualKeys = array_keys($actual);
                // When $isOrdered, check if key exists at some next position
                if (!in_array($key, array_slice($actualKeys, $actualKeyNumber), true)) {
                    $success = false;
                    return;
                }
                $actualKeyNumber = array_search($key, $actualKeys, true);
            }
            $actualInner = $actual[$key];
            $actualKeyNumber += 1;
            if (!$this->compare($expectedInner, $actualInner)) {
                $success = false;
            }
        });
        return $success;
    }

    /**
     * Return True, if both are null, False if anyone is null, Null otherwise
     */
    private function checkForNull($left, $right): ?bool
    {
        if (is_null($left)) {
            if (is_null($right)) {
                return true;
            }
            return false;
        }
        if (is_null($right)) {
            return false;
        }
        return null;
    }

    /**
     * Return True, if both are equal primitive, False if anyone is primitive, Null otherwise
     */
    private function checkForPrimitive($left, $right): ?bool
    {
        if (!is_array($left)) {
            if (!is_array($right)) {
                return $left === $right;
            }
            return false;
        }
        if (!is_array($right)) {
            return false;
        }
        return null;
    }

    /**
     * Check whether the list is a subset of another list.
     *
     * @param array $leftList  Expected left list
     * @param array $rightList Right List to check
     *
     * @return bool True if $leftList is a subset of $rightList
     */
    private function isListProperSubsetOf(array $leftList, array $rightList): bool
    {
        if ($this->isOrdered) {
            if ($this->allowExtra) {
                return $leftList === array_slice($rightList, 0, count($leftList));
            }
            return $leftList === $rightList;
        }
        return $leftList == $this->intersectArrays($leftList, $rightList);
    }

    /**
     * Computes the intersection of arrays, even for arrays of arrays
     *
     * @param array $leftList  The array with main values to check
     * @param array $rightList An array to compare values against
     *
     * @return array An array containing all the values in the leftList
     *               which are also present in the rightList
     */
    private function intersectArrays(array $leftList, array $rightList): array
    {
        $commonList = [];
        foreach ($leftList as $leftVal) {
            foreach ($rightList as $rightVal) {
                if ($this->compare($leftVal, $rightVal)) {
                    $commonList[] = $leftVal;
                    array_splice($rightList, array_search($rightVal, $rightList, true), 1);
                    break;
                }
            }
        }
        return $commonList;
    }

    /**
     * If passed instance is an object, cast it as an array
     */
    private function convertObjectToArray($value)
    {
        if (is_object($value)) {
            return array_map([$this, 'convertObjectToArray'], (array) $value);
        }
        if (is_array($value)) {
            return array_map([$this, 'convertObjectToArray'], $value);
        }
        return $value;
    }
}
