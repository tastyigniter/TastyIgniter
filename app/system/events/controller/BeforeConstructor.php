<?php

namespace System\Events\Controller;

use Event;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BeforeConstructor
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $controller;

    public function __construct($controller)
    {
        $this->controller = $controller;

        // deprecate on next major release
        Event::fire('controller.beforeConstructor', [$this->controller]);
    }
}
