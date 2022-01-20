<?php

namespace Admin\Events\Navigation;

use System\Classes\BaseEvent;

class ExtendUserMenuLinks extends BaseEvent
{
    public $links;

    public function __construct($links)
    {
        $this->links = $links;

        $this->fireBackwardsCompatibleEvent('admin.menu.extendUserMenuLinks', [$this->links]);
    }
}
