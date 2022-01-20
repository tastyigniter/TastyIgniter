<?php

namespace Admin\Events\Navigation;

use System\Classes\BaseEvent;

class ExtendItems extends BaseEvent
{
    public $navigation;

    public function __construct($navigation)
    {
        $this->navigation = $navigation;

        $this->fireBackwardsCompatibleEvent('admin.navigation.extendItems', [$this->navigation]);
    }
}
