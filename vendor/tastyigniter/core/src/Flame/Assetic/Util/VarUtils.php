<?php

declare(strict_types=1);

namespace Igniter\Flame\Assetic\Util;

use InvalidArgumentException;

/**
 * Variable utilities.
 *
 * @author Johannes M. Schmitt <schmittjoh@gmail.com>
 */
abstract class VarUtils
{
    /**
     * Resolves variable placeholders.
     *
     * @param string $template A template string
     * @param array $vars Variable names
     * @param array $values Variable values
     *
     * @return string The resolved string
     *
     * @throws InvalidArgumentException If there is a variable with no value
     */
    public static function resolve(string $template, array $vars, array $values)
    {
        $map = [];
        foreach ($vars as $var) {
            if (!str_contains($template, '{'.$var.'}')) {
                continue;
            }

            if (!isset($values[$var])) {
                throw new InvalidArgumentException(sprintf('The template "%s" contains the variable "%s", but was not given any value for it.', $template, $var));
            }

            $map['{'.$var.'}'] = $values[$var];
        }

        return strtr($template, $map);
    }

    public static function getCombinations(array $vars, array $values)
    {
        if (empty($vars)) {
            return [[]];
        }

        $combinations = [];
        $nbValues = [];
        foreach ($values as $var => $vals) {
            if (!in_array($var, $vars, true)) {
                continue;
            }

            $nbValues[$var] = count($vals);
        }

        for ($i = array_product($nbValues), $c = $i * 2; $i < $c; $i++) {
            $k = $i;
            $combination = [];

            foreach ($vars as $var) {
                $combination[$var] = $values[$var][$k % $nbValues[$var]];
                $k = intval($k / $nbValues[$var]);
            }

            $combinations[] = $combination;
        }

        return $combinations;
    }

    /**
     * @codeCoverageIgnore
     */
    final private function __construct() {}
}
