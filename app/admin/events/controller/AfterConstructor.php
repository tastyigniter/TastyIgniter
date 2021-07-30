<?php

namespace Admin\Events\Controller;

class AfterConstructor extends Event
{
    public $controller;

    public function __construct($controller)
    {
        $this->controller = $controller;
    }
}
