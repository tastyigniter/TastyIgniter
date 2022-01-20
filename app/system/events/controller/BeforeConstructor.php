<?php

namespace System\Events\Controller;

use System\Classes\BaseEvent;

class BeforeConstructor extends BaseEvent
{
    public $controller;

    public function __construct($controller)
    {
        $this->controller = $controller;

        $this->fireBackwardsCompatibleEvent('controller.beforeConstructor', [$this->controller]);
    }
}
