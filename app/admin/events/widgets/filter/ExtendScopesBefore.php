<?php

namespace Admin\Events\Widgets\Filter;

use System\Classes\BaseEvent;

class ExtendScopesBefore extends BaseEvent
{
    public $filter;

    public function __construct($filter)
    {
        $this->filter = $filter;

        $this->fireBackwardsCompatibleEvent('admin.filter.extendScopesBefore', [$this->filter]);
    }
}
