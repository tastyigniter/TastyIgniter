<?php

namespace Main\Events\Router;

use System\Classes\BaseEvent;

class BeforeRoute extends BaseEvent
{
    public $router;
    public $url;
    public $result;

    public function __construct($router, $url, $result)
    {
        $this->router = $router;
        $this->url = $url;
        $this->result = $result;

        $this->fireBackwardsCompatibleEvent('router.beforeRoute', [$this->url, $this->router]);
    }
}
