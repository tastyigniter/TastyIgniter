<?php

namespace Admin\Events\Widgets\Filter;

use System\Classes\BaseEvent;

class UpdateEvent extends BaseEvent
{
    public $filter;
    public $query;
    public $scope;

    public function __construct($filter, $query, $scope)
    {
        $this->filter = $filter;
        $this->query = $query;
        $this->scope = $scope;

        $this->fireBackwardsCompatibleEvent('admin.filter.extendQuery', [$this->filter, $this->query, $this->scope]);
    }
}
