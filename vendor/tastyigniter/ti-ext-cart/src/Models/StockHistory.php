<?php

declare(strict_types=1);

namespace Igniter\Cart\Models;

use Igniter\Flame\Database\Factories\HasFactory;
use Igniter\Flame\Database\Model;
use Igniter\User\Models\User;
use Illuminate\Support\Carbon;

/**
 * Stock History Model Class
 *
 * @property int $id
 * @property int $stock_id
 * @property int|null $user_id
 * @property int|null $order_id
 * @property string $state
 * @property int $quantity
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read mixed $created_at_since
 * @property-read mixed $staff_name
 * @property-read mixed $state_text
 * @mixin Model
 */
class StockHistory extends Model
{
    use HasFactory;

    /**
     * @var string The database table name
     */
    protected $table = 'stock_history';

    protected $casts = [
        'stock_id' => 'integer',
        'user_id' => 'integer',
        'order_id' => 'integer',
        'quantity' => 'integer',
        'occurred_at' => 'datetime',
    ];

    protected $guarded = [];

    protected $appends = ['staff_name', 'state_text', 'created_at_since'];

    public $relation = [
        'belongsTo' => [
            'stock' => Stock::class,
            'user' => User::class,
            'order' => Order::class,
        ],
    ];

    public $timestamps = true;

    public static function createHistory(Stock $stock, int $quantity, $state, array $options = []): static
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

    public function getStateTextAttribute(): string
    {
        return lang('igniter.cart::default.stocks.text_action_'.$this->state);
    }

    public function getCreatedAtSinceAttribute(): ?string
    {
        return $this->created_at ? time_elapsed($this->created_at) : null;
    }
}
