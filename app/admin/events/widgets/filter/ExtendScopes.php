<?php

namespace Admin\Events\Widgets\Filter;

use System\Classes\BaseEvent;

class ExtendScopes extends BaseEvent
{
    public $filter;
    public $scopes;

    public function __construct($filter, $scopes)
    {
        $this->filter = $filter;
        $this->scopes = $scopes;

        $this->fireBackwardsCompatibleEvent('admin.filter.extendScopes', [$this->filter, $this->scopes]);
    }
}
