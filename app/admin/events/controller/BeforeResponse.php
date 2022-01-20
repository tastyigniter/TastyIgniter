<?php

namespace Admin\Events\Controller;

use System\Classes\BaseEvent;

class BeforeResponse extends BaseEvent
{
    public $controller;
    public $action;
    public $params;
    public $response;

    public function __construct($controller, $action, $params, $response)
    {
        $this->controller = $controller;
        $this->action = $action;
        $this->params = $params;
        $this->response = $response;

        $this->fireBackwardsCompatibleEvent('admin.controller.beforeResponse', [$this->controller, $this->action, $this->params, $this->response]);
    }
}
