<?php

namespace System\Events\Assets;

use System\Classes\BaseEvent;

class BeforePrepare extends BaseEvent
{
    public $controller;
    public $assets;

    public function __construct($controller, $assets)
    {
        $this->controller = $controller;
        $this->assets = $assets;

        $this->fireBackwardsCompatibleEvent('assets.combiner.beforePrepare', [$this->controller, $this->assets]);
    }
}
