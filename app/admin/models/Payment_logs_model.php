<?php namespace Admin\Models;

use Model;

/**
 * Payment logs Model Class
 *
 * @package Admin
 */
class Payment_logs_model extends Model
{
    const UPDATED_AT = 'date_updated';

    const CREATED_AT = 'date_added';

    /**
     * @var string The database table name
     */
    protected $table = 'payment_logs';

    /**
     * @var string The database table primary key
     */
    protected $primaryKey = 'payment_log_id';

    public $timestamps = TRUE;

    public $casts = [
        'order_id' => 'integer',
        'request' => 'array',
        'response' => 'array',
        'status' => 'boolean',
    ];

    public static function logAttempt($order, $message, $status, $request = [], $response = [])
    {
        $record = new static;
        $record->message = $message;
        $record->order_id = $order->order_id;
        $record->payment_name = $order->payment_method->code;
        $record->status = $status;
        $record->request = $request;
        $record->response = $response;

        $record->save();
    }
}