<?php

namespace Main\Events\Theme;

use System\Classes\BaseEvent;

class ExtendFormConfig extends BaseEvent
{
    public $directory;
    public $config;

    public function __construct($directory, $config)
    {
        $this->directory = $directory;
        $this->config = $config;

        $this->fireBackwardsCompatibleEvent('main.theme.extendFormConfig', [$this->directory, $this->config]);
    }
}
