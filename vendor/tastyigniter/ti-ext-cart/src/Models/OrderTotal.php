<?php

declare(strict_types=1);

namespace Igniter\Cart\Models;

use Igniter\Flame\Database\Model;

/**
 * OrderTotal Model
 *
 * @property int $order_total_id
 * @property int $order_id
 * @property string $code
 * @property string $title
 * @property float $value
 * @property int $priority
 * @property bool $is_summable
 * @mixin Model
 */
class OrderTotal extends Model
{
    protected $table = 'order_totals';

    /**
     * @var string The database table primary key
     */
    protected $primaryKey = 'order_total_id';

    public $guarded = [];

    protected $casts = [
        'order_id' => 'integer',
        'value' => 'float',
        'priority' => 'integer',
        'is_summable' => 'boolean',
    ];

    public $relation = [
        'belongsTo' => [
            'order' => Order::class,
        ],
    ];
}
