<?php

namespace Admin\Models;

use Admin\Traits\Locationable;
use Igniter\Flame\Database\Model;

/**
 * Stocks Model Class
 */
class Stocks_model extends Model
{
    use Locationable;

    public const STATE_NONE = 'none';
    public const STATE_IN_STOCK = 'in_stock';
    public const STATE_RECOUNT = 'recount';
    public const STATE_RESTOCK = 'restock';
    public const STATE_SOLD = 'sold';
    public const STATE_RETURNED = 'returned';
    public const STATE_WASTE = 'waste';

    /**
     * @var string The database table name
     */
    protected $table = 'stocks';

    protected $guarded = ['quantity'];

    protected $casts = [
        'location_id' => 'integer',
        'related_id' => 'integer',
        'quantity' => 'integer',
        'low_stock_alert' => 'boolean',
        'low_stock_threshold' => 'integer',
        'is_tracked' => 'boolean',
    ];

    public $relation = [
        'belongsTo' => [
            'location' => 'Admin\Models\Locations_model',
        ],
        'hasMany' => [
            'history' => 'Admin\Models\Stock_history_model',
        ],
        'morphTo' => [
            'stockable' => [],
        ],
    ];

    public $timestamps = TRUE;

    public function getStockActionOptions()
    {
        return [
            self::STATE_NONE => 'lang:admin::lang.stocks.text_action_none',
            self::STATE_IN_STOCK => 'lang:admin::lang.stocks.text_action_in_stock',
            self::STATE_RETURNED => 'lang:admin::lang.stocks.text_action_returned',
            self::STATE_WASTE => 'lang:admin::lang.stocks.text_action_waste',
            self::STATE_RESTOCK => 'lang:admin::lang.stocks.text_action_restock',
            self::STATE_RECOUNT => 'lang:admin::lang.stocks.text_action_recount',
        ];
    }

    //
    // Scopes
    //

    public function scopeApplyStockable($query, $model)
    {
        return $query->where('stockable_type', $model->getMorphClass())
            ->where('stockable_id', $model->getKey());
    }

    //
    // Helpers
    //

    public function updateStock(int $quantity, $state = null, array $options = [])
    {
        if ($this->shouldUpdateStock($state)) {
            $stockQty = $this->computeStockQuantity($state, $quantity);

            $history = Stock_history_model::createHistory($this, $quantity, $state, $options);

            // Update using query to prevent model events from firing
            $this->newQuery()
                ->where($this->getKeyName(), $this->getKey())
                ->update(['quantity' => $stockQty]);

            $this->fireSystemEvent('admin.stock.updated', [$history, $stockQty]);
        }

        return TRUE;
    }

    public function updateStockSold(int $orderId, int $quantity)
    {
        return $this->updateStock($quantity, self::STATE_SOLD, [
            'order_id' => $orderId,
        ]);
    }

    public function checkStock(int $quantity)
    {
        if (!$this->is_tracked)
            return TRUE;

        return $this->quantity >= $quantity;
    }

    public function outOfStock()
    {
        return $this->is_tracked && $this->quantity <= 0;
    }

    protected function shouldUpdateStock($state)
    {
        if (!$this->is_tracked)
            return FALSE;

        return strlen($state) && $state !== self::STATE_NONE;
    }

    protected function computeStockQuantity($state, int $quantity)
    {
        $stockQty = 0;
        switch ($state) {
            case self::STATE_IN_STOCK:
            case self::STATE_RESTOCK:
                $stockQty = $this->quantity + $quantity;
                break;
            case self::STATE_RECOUNT:
                $stockQty = $quantity;
                break;
            case self::STATE_SOLD:
            case self::STATE_RETURNED:
            case self::STATE_WASTE:
                $stockQty = $this->quantity - $quantity;
                break;
        }

        return max($stockQty, 0);
    }
}
