<?php

declare(strict_types=1);

namespace Igniter\Flame\Mixins;

use Igniter\Main\Classes\MainController;
use Illuminate\Routing\Router;

/** @mixin Router */
class RouterMixin
{
    public function pagic()
    {
        return function($uri, $name = null) {
            $route = $this->any($uri, [MainController::class, 'remap']);

            if (!is_null($name)) {
                $route->name($name);
            }

            return $route;
        };
    }
}
