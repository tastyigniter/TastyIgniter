<?php

declare(strict_types=1);

namespace Igniter\Flame\Mixins;

use Illuminate\Support\Str;

/** @mixin Str */
class StringMixin
{
    /**
     * Converts number to its ordinal English form.
     *
     * This method converts 13 to 13th, 2 to 2nd ...
     */
    public function ordinal()
    {
        return function(int|string $number): string {
            if (in_array($number % 100, range(11, 13))) {
                return $number.'th';
            }

            return match ($number % 10) {
                1 => $number.'st',
                2 => $number.'nd',
                3 => $number.'rd',
                default => $number.'th',
            };
        };
    }

    /**
     * Converts line breaks to a standard \r\n pattern.
     */
    public function normalizeEol()
    {
        return fn($string): ?string => preg_replace('~\R~u', "\r\n", (string)$string);
    }

    /**
     * Removes the starting slash from a class namespace \
     */
    public function normalizeClassName()
    {
        return function($name): string {
            if (is_object($name)) {
                $name = $name::class;
            }

            return '\\'.ltrim($name, '\\');
        };
    }

    /**
     * Generates a class ID from either an object or a string of the class name.
     */
    public function getClassId()
    {
        return function($name): string {
            if (is_object($name)) {
                $name = $name::class;
            }

            $name = ltrim($name, '\\');
            $name = str_replace('\\', '_', $name);

            return strtolower($name);
        };
    }

    /**
     * Returns a class namespace
     */
    public function getClassNamespace()
    {
        return function($name): string {
            $name = Str::normalizeClassName($name);

            return substr($name, 0, strrpos($name, '\\'));
        };
    }

    /**
     * If $string begins with any number of consecutive symbols,
     * returns the number, otherwise returns 0
     */
    public function getPrecedingSymbols()
    {
        return fn($string, $symbol): int => strlen((string)$string) - strlen(ltrim((string)$string, $symbol));
    }
}
