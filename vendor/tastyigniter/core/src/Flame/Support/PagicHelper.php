<?php

declare(strict_types=1);

namespace Igniter\Flame\Support;

/**
 * Pagic helper class
 */
class PagicHelper
{
    /**
     * Parses supplied Blade contents, with supplied variables.
     * @param string $contents Blade contents to parse.
     * @param array $vars Context variables.
     * @return string
     */
    public static function parse($contents, $vars = [])
    {
        $template = resolve('pagic')->createTemplate($contents);

        return $template->render($vars);
    }
}
