<?php

namespace Admin\Models;

use Igniter\Flame\Database\Model;

/**
 * Stock History Model Class
 */
class Stock_history_model extends Model
{
    /**
     * @var string The database table name
     */
    protected $table = 'stock_history';

    protected $casts = [
        'stock_id' => 'integer',
        'staff_id' => 'integer',
        'order_id' => 'integer',
        'quantity' => 'integer',
    ];

    protected $dates = ['occurred_at'];

    protected $guarded = [];

    protected $appends = ['staff_name', 'state_text', 'created_at_since'];

    public $relation = [
        'belongsTo' => [
            'stock' => 'Admin\Models\Stocks_model',
            'staff' => 'Admin\Models\Staffs_model',
            'order' => 'Admin\Models\Orders_model',
        ],
    ];

    public $timestamps = true;

    public static function createHistory(Stocks_model $stock, int $quantity, $state, array $options = [])
    {
        $model = new static;
        $model->stock_id = $stock->getKey();
        $model->staff_id = array_get($options, 'staff_id');
        $model->order_id = array_get($options, 'order_id');
        $model->quantity = $quantity;
        $model->state = $state;
        $model->save();

        return $model;
    }

    public function getStaffNameAttribute()
    {
        return ($this->staff && $this->staff->exists) ? $this->staff->staff_name : null;
    }

    public function getStateTextAttribute()
    {
        return lang('admin::lang.stocks.text_action_'.$this->state);
    }

    public function getCreatedAtSinceAttribute()
    {
        return $this->created_at ? time_elapsed($this->created_at) : null;
    }
}
