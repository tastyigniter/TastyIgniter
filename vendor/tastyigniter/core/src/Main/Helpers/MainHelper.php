<?php

declare(strict_types=1);

namespace Igniter\Main\Helpers;

use Igniter\Flame\Pagic\Router;
use Illuminate\Support\Facades\URL;

class MainHelper
{
    public static function pageUrl(?string $path = null, array $params = []): string
    {
        if (!is_null($path)) {
            $path = resolve(Router::class)->pageUrl($path, $params);
        }

        return URL::to($path);
    }
}
