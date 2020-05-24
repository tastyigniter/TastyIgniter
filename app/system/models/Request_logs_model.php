<?php namespace System\Models;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Request;
use Model;

/**
 * RequestLogs Model Class
 * @package System
 */
class Request_logs_model extends Model
{
    /**
     * @var string The database table name
     */
    protected $table = 'request_logs';

    protected $guarded = [];

    /**
     * @var array The model table column to convert to dates on insert/update
     */
    public $timestamps = TRUE;

    public $casts = [
        'referrer' => 'json',
    ];

    public static function createLog($statusCode = 404)
    {
        if (!App::hasDatabase())
            return;

        if (!setting('enable_request_log', TRUE))
            return;

        $url = Request::fullUrl();
        $referrer = Request::header('referer');

        $record = self::firstOrNew([
            'url' => substr($url, 0, 191),
            'status_code' => $statusCode,
        ]);

        if (strlen($referrer)) {
            $referrers = (array)$record->referrer ?: [];
            $referrers[] = $referrer;
            $record->referrer = $referrers;
        }

        $record->addLog();

        return $record;
    }

    public function addLog()
    {
        if (!$this->exists) {
            $this->count = 1;
            $this->save();
        }
        else {
            $this->increment('count');
        }

        return $this;
    }
}