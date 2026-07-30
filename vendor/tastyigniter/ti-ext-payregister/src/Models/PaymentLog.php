<?php

declare(strict_types=1);

namespace Igniter\PayRegister\Models;

use Igniter\Cart\Models\Order;
use Igniter\Flame\Database\Factories\HasFactory;
use Igniter\Flame\Database\Model;
use Igniter\Flame\Database\Traits\Validation;
use Igniter\PayRegister\Events\OrderBeforeRefundProcessedEvent;
use Igniter\PayRegister\Events\OrderRefundProcessedEvent;
use Illuminate\Support\Carbon;

/**
 * PaymentLog Model Class
 *
 * @property int $payment_log_id
 * @property int $order_id
 * @property string|null $payment_name
 * @property string $message
 * @property array|null $request
 * @property array|null $response
 * @property bool $is_success
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string $payment_code
 * @property bool $is_refundable
 * @property Carbon|null $refunded_at
 * @property-read mixed $date_added_since
 * @property null|Order $order
 * @property null|Payment $payment_method
 * @mixin Model
 */
class PaymentLog extends Model
{
    use HasFactory;
    use Validation;

    /**
     * @var string The database table name
     */
    protected $table = 'payment_logs';

    /**
     * @var string The database table primary key
     */
    protected $primaryKey = 'payment_log_id';

    protected $appends = ['date_added_since'];

    public $timestamps = true;

    public $relation = [
        'belongsTo' => [
            'order' => [Order::class],
            'payment_method' => [Payment::class, 'foreignKey' => 'payment_code', 'otherKey' => 'code'],
        ],
    ];

    public $rules = [
        'message' => 'string',
        'order_id' => 'integer',
        'payment_code' => 'string',
        'payment_name' => 'string',
        'is_success' => 'boolean',
        'request' => 'array',
        'response' => 'array',
        'is_refundable' => 'boolean',
    ];

    protected $casts = [
        'order_id' => 'integer',
        'request' => 'array',
        'response' => 'array',
        'is_success' => 'boolean',
        'is_refundable' => 'boolean',
        'refunded_at' => 'datetime',
    ];

    public static function logAttempt($order, $message, $isSuccess, $request = [], $response = [], $isRefundable = false): void
    {
        $record = new self;
        $record->message = $message;
        $record->order_id = $order->order_id;
        $record->payment_code = $order->payment_method->code;
        $record->payment_name = $order->payment_method->name;
        $record->is_success = $isSuccess;
        $record->request = $request;
        $record->response = $response;
        $record->is_refundable = $isRefundable;

        $record->save();
    }

    public function getDateAddedSinceAttribute($value): ?string
    {
        return $this->created_at ? time_elapsed($this->created_at) : null;
    }

    public function markAsRefundProcessed(): bool
    {
        if (is_null($this->refunded_at)) {
            OrderBeforeRefundProcessedEvent::dispatch($this);

            $this->refunded_at = Carbon::now();
            $this->saveQuietly();

            OrderRefundProcessedEvent::dispatch($this);
        }

        return true;
    }
}
