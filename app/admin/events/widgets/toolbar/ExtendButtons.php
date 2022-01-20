<?php

namespace Admin\Events\Widgets\Toolbar;

use System\Classes\BaseEvent;

class ExtendButtons extends BaseEvent
{
    public $toolbar;
    public $buttons;

    public function __construct($toolbar, $buttons)
    {
        $this->toolbar = $toolbar;
        $this->buttons = $buttons;

        $this->fireBackwardsCompatibleEvent('admin.toolbar.extendButtons', [$this->toolbar, $this->buttons]);
    }
}
