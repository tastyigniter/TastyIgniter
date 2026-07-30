<?php
namespace tests;

/**
 * PHPUnit has deprecated the old function `assertRegExp` for asserting regular
 * expression matches. However, the versions of PHPUnit compatible with PHP 7.2 do
 * not have the new version.
 * 
 * This trait adds a version of the method that calls the old version for PHP 7.2
 * or the new version for newer versions.
 * 
 * Can be removed once PHP 7.2 is dropped from CI.
 */
trait AssertsRegularExpressions
{
    public static function assertMatchesRegularExpression(string $pattern, string $string, string $message = ''): void
    {
        if (version_compare(phpversion(), '7.3.0', '<')) {
            self::assertRegExp($pattern, $string, $message);
            return;
        }

        parent::assertMatchesRegularExpression($pattern, $string, $message);
    }
}
