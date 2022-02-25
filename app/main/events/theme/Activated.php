<?php

namespace Main\Events\Theme;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Activated
{
    use Dispatchable, SerializesModels;

    public $theme;

    public function __construct($theme)
    {
        $this->theme = $theme;
    }
}
