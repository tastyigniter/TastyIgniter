<?php

namespace Admin\Events\Controller;

use System\Classes\BaseEvent;

class BeforeRemap extends BaseEvent
{
    public $controller;

    public function __construct($controller)
    {
        $this->controller = $controller;

        $this->fireBackwardsCompatibleEvent('admin.controller.beforeRemap', [$this->controller]);
    }
}
