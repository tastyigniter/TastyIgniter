<?php

namespace Admin\Events\Widgets\Table;

use System\Classes\BaseEvent;

class GetRecords extends BaseEvent
{
    public $table;
    public $offset;
    public $endAt;
    public $search;
    public $results;

    public function __construct($widget, $offset, $limit, $search, $results)
    {
        $this->table = $widget;
        $this->offset = $offset;
        $this->limit = $limit;
        $this->search = $search;
        $this->results = $results;

        $this->fireBackwardsCompatibleEvent('table.getRecords', [$startAt, $endAt, $events, $results]);
    }
}
