<?php

namespace Main\Events\Controller;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use System\Traits\DispatchesLegacyEvent;

class AfterConstructor
{
    use Dispatchable, DispatchesLegacyEvent, InteractsWithSockets, SerializesModels;

    public $controller;

    public function __construct($controller)
    {
        $this->controller = $controller;

        $this->fireBackwardsCompatibleEvent('controller.afterContructor', [$this->controller]);
    }
}
