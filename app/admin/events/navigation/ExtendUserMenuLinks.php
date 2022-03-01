<?php

namespace Admin\Events\Navigation;

use Illuminate\Foundation\Events\Dispatchable;

class ExtendUserMenuLinks
{
    use Dispatchable;

    public $links;

    public function __construct($links)
    {
        $this->links = $links;
    }
}
