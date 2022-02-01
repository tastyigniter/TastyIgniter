<?php

namespace Admin\Events\Widgets\Table;

use System\Classes\BaseEvent;

class GetRecords extends BaseEvent
{
    public $table;
    public $columnName;
    public $rowData;
    public $results;

    public function __construct($widget, $columnName, $rowData, $results)
    {
        $this->table = $widget;
        $this->columnName = $columnName;
        $this->rowData = $rowData;
        $this->results = $results;

        $this->fireBackwardsCompatibleEvent('table.getDropdownOptions', [$columnName, $rowData, $results]);
    }
}
