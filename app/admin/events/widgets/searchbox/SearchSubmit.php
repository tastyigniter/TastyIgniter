<?php

namespace Admin\Events\Widgets\Searchbox;

use System\Classes\BaseEvent;

class SearchSubmit extends BaseEvent
{
    public $widget;
    public $params;
    public $result;

    public function __construct($widget, $params, $result)
    {
        $this->widget = $widget;
        $this->params = $params;
        $this->result = $result;

        $this->fireBackwardsCompatibleEvent('search.submit', [$this->widget, $this->params]);
    }
}
