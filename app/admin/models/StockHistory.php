<?php

namespace Admin\Models;

use Igniter\Flame\Database\Model;

/**
 * Stock History Model Class
 */
class StockHistory extends Model
{
    /**
     * @var string The database table name
     */
    protected $table = 'stock_history';

    protected $casts = [
        'stock_id' => 'integer',
        'user_id' => 'integer',
        'order_id' => 'integer',
        'quantity' => 'integer',
    ];

    protected $dates = ['occurred_at'];

    protected $guarded = [];

    protected $appends = ['staff_name', 'state_text', 'created_at_since'];

    public $relation = [
        'belongsTo' => [
            'stock' => 'Admin\Models\Stock',
            'user' => 'Admin\Models\User',
            'order' => 'Admin\Models\Order',
        ],
    ];

    public $timestamps = TRUE;

    public static function createHistory(Stock $stock, int $quantity, $state, array $options = [])
    {
        $model = new static;
        $model->stock_id = $stock->getKey();
        $model->user_id = array_get($options, 'staff_id', array_get($options, 'user_id'));
        $model->order_id = array_get($options, 'order_id');
        $model->quantity = $quantity;
        $model->state = $state;
        $model->save();

        return $model;
    }

    public function getStaffNameAttribute()
    {
        return $this->user->name ?? null;
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
