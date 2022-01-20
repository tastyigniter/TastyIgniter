<?php

namespace Admin\Events\Widgets\Filter;

use System\Classes\BaseEvent;

class FilterSubmit extends BaseEvent
{
    public $filter;
    public $params;
    public $result;

    public function __construct($filter, $params, $result)
    {
        $this->filter = $filter;
        $this->params = $params;
        $this->result = $result;

        $this->fireBackwardsCompatibleEvent('filter.submit', [$this->filter, $this->params, $this->result]);
    }
}
