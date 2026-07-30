<?php

declare(strict_types=1);

namespace Igniter\System\Helpers;

use Illuminate\Support\Facades\View;

class ViewHelper
{
    /**
     * @var array Cache for global variables.
     */
    protected static ?array $globalVarCache = null;

    /**
     * Returns shared view variables, this should be used for simple rendering cycles.
     * Such as content blocks and mail templates.
     */
    public static function getGlobalVars(): array
    {
        if (static::$globalVarCache !== null) {
            return static::$globalVarCache;
        }

        $vars = array_filter(View::getShared(), fn($var): bool => is_scalar($var) || is_array($var));

        return static::$globalVarCache = $vars;
    }
}
