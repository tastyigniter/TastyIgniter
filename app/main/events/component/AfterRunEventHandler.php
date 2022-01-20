<?php

namespace Main\Events\Component;

use System\Classes\BaseEvent;

class AfterRunEventHandler extends BaseEvent
{
    public $component;
    public $handler;
    public $result;

    public function __construct($component, $handler, $result)
    {
        $this->component = $component;
        $this->handler = $handler;
        $this->result = $result;

        $this->fireBackwardsCompatibleEvent('main.component.afterRunEventHandler', [$this->component, $this->handler, $this->result]);
    }
}
