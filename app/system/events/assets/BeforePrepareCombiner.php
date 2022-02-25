<?php

namespace System\Events\Assets;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BeforePrepareCombiner
{
    use Dispatchable, SerializesModels;

    public $controller;

    public $assets;

    public function __construct($controller, $assets)
    {
        $this->controller = $controller;
        $this->assets = $assets;
    }
}
