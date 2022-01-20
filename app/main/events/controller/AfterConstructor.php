<?php

namespace Main\Events\Controller;

use System\Classes\BaseEvent;

class AfterConstructor extends BaseEvent
{
    public $controller;

    public function __construct($controller)
    {
        $this->controller = $controller;

        $this->fireBackwardsCompatibleEvent('controller.afterContructor', [$this->controller]);
    }
}
