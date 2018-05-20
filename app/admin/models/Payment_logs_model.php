<?php namespace Admin\Models;

use Model;

/**
 * Payment logs Model Class
 *
 * @package Admin
 */
class Payment_logs_model extends Model
{
    /**
     * @var string The database table name
     */
    protected $table = 'payment_logs';

    /**
     * @var string The database table primary key
     */
    protected $primaryKey = 'payment_log_id';

    public $casts = [
        'request'  => 'array',
        'response' => 'array',
    ];
}