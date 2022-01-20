<?php

namespace Admin\Events\Controller;

use System\Classes\BaseEvent;

class BeforeInitialize extends BaseEvent
{
    public $controller;

    public function __construct($controller)
    {
        $this->controller = $controller;

        $this->fireBackwardsCompatibleEvent('admin.controller.beforeInit', [$this->controller]);
    }
}
