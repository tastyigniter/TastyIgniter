<?php

namespace Admin\Events\Menu;

use System\Classes\BaseEvent;

class StockUpdates extends BaseEvent
{
    public $model;
    public $quantity;
    public $subtract;

    public function __construct($model, $quantity, $subtract)
    {
        $this->model = $model;
        $this->quantity = $quantity;
        $this->subtract = $subtract;

        $this->fireBackwardsCompatibleEvent('admin.menu.stockUpdated', [$this->model, $this->quantity, $this->subtract]);
    }
}
