<?php

namespace Admin\Models;

use Admin\Traits\Locationable;
use Igniter\Flame\Database\Model;
use System\Traits\SendsMailTemplate;

/**
 * Stocks Model Class
 */
class Stocks_model extends Model
{
    use Locationable;
    use SendsMailTemplate;

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
        'low_stock_alert_sent' => 'boolean',
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

    public $timestamps = true;

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

            if (in_array($state, [self::STATE_IN_STOCK, self::STATE_RESTOCK, self::STATE_RECOUNT]))
                $this->low_stock_alert_sent = false;

            $this->quantity = $stockQty;
            $this->saveQuietly();

            if ($this->hasLowStock() && $this->shouldAlertOnLowStock($state)) {
                $this->mailSend('admin::_mail.low_stock_alert', 'location');

                // Prevent duplicate low stock alerts
                $this->updateQuietly(['low_stock_alert_sent' => true]);
            }

            $this->fireSystemEvent('admin.stock.updated', [$history, $stockQty]);
        }

        return true;
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
            return true;

        return $this->quantity >= $quantity;
    }

    public function outOfStock()
    {
        return $this->is_tracked && $this->quantity <= 0;
    }

    public function hasLowStock()
    {
        return $this->low_stock_threshold && $this->low_stock_threshold >= $this->quantity;
    }

    protected function shouldUpdateStock($state)
    {
        if (!$this->is_tracked)
            return false;

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

    protected function shouldAlertOnLowStock()
    {
        if (!$this->low_stock_alert)
            return false;

        return !$this->low_stock_alert_sent;
    }

    public function mailGetRecipients($type)
    {
        return [
            [$this->location->location_email, $this->location->location_name],
        ];
    }

    public function mailGetData()
    {
        return [
            'stock_name' => $this->stockable->getStockableName(),
            'location_name' => $this->location->location_name,
            'quantity' => $this->quantity,
            'low_stock_threshold' => $this->low_stock_threshold,
            'stock' => $this,
        ];
    }
}
