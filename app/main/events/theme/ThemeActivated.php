<?php

namespace Main\Events\Theme;

use System\Classes\BaseEvent;

class ThemeActivated extends BaseEvent
{
    public $theme;

    public function __construct($theme)
    {
        $this->theme = $theme;

        $this->fireBackwardsCompatibleEvent('main.theme.activated', [$this->theme]);
    }
}
