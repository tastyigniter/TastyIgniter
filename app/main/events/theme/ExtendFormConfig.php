<?php

namespace Main\Events\Theme;

use Illuminate\Foundation\Events\Dispatchable;

class ExtendFormConfig
{
    use Dispatchable;

    public $directory;

    public $config;

    public function __construct($directory, $config)
    {
        $this->directory = $directory;
        $this->config = $config;
    }
}
