<?php

namespace Main\Events\Controller;

use System\Classes\BaseEvent;

class BeforeRemap extends BaseEvent
{
    public $controller;

    public function __construct($controller)
    {
        $this->controller = $controller;

        $this->fireBackwardsCompatibleEvent('main.controller.beforeRemap', [$this->controller]);
    }
}
