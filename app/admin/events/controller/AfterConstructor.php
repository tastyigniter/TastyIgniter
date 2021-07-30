<?php

namespace Admin\Events\Controller;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AfterConstructor
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $controller;

    public function __construct($controller)
    {
        $this->controller = $controller;
    }
}
