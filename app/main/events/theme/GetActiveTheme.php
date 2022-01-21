<?php

namespace Main\Events\Theme;

use System\Classes\BaseEvent;

class GetActiveTheme extends BaseEvent
{
    public $result;

    public function __construct($result)
    {
        $this->result = $result;

        $this->fireBackwardsCompatibleEvent('theme.getActiveTheme', [$this->result]);
    }
}
