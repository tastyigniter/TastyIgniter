<?php

namespace Admin\Events\Widgets\Toolbar;

use System\Classes\BaseEvent;

class ExtendButtonsBefore extends BaseEvent
{
    public $toolbar;

    public function __construct($toolbar)
    {
        $this->toolbar = $toolbar;

        $this->fireBackwardsCompatibleEvent('admin.toolbar.extendButtonsBefore', [$this->toolbar]);
    }
}
