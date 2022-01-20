<?php

namespace Admin\Events\Model;

use System\Classes\BaseEvent;

class ExtendListFrontEndQuery extends BaseEvent
{
    public $model;
    public $query;

    public function __construct($model, $query)
    {
        $this->model = $model;
        $this->query = $query;

        $this->fireBackwardsCompatibleEvent('model.extendListFrontEndQuery', [$this->model, $this->query]);
    }
}
