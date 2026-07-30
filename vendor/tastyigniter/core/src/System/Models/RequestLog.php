<?php

declare(strict_types=1);

namespace Igniter\System\Models;

use Igniter\Flame\Database\Model;
use Igniter\Flame\Support\Facades\Igniter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Prunable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Request;

/**
 * RequestLog Model Class
 *
 * @property int $id
 * @property string|null $url
 * @property int|null $status_code
 * @property array<array-key, mixed>|null $referrer
 * @property int $count
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder<static>|RequestLog applyFilters(array $options = [])
 * @method static Builder<static>|RequestLog applySorts(array $sorts = [])
 * @method static Builder<static>|RequestLog listFrontEnd(array $options = [])
 * @method static Builder<static>|RequestLog newModelQuery()
 * @method static Builder<static>|RequestLog newQuery()
 * @method static Builder<static>|RequestLog query()
 * @mixin \Illuminate\Database\Eloquent\Model
 */
class RequestLog extends Model
{
    use Prunable;

    /**
     * @var string The database table name
     */
    protected $table = 'request_logs';

    protected $guarded = [];

    public $timestamps = true;

    protected $casts = [
        'referrer' => 'json',
    ];

    public static function createLog($statusCode = 404)
    {
        if (!Igniter::hasDatabase()) {
            return null;
        }

        if (!setting('enable_request_log', true)) {
            return null;
        }

        $url = Request::fullUrl();
        $referrer = Request::header('referer');

        /** @var RequestLog $record */
        $record = self::firstOrNew([
            'url' => substr($url, 0, 191),
            'status_code' => $statusCode,
        ]);

        if ($referrer) {
            $referrers = (array)$record->referrer;
            $referrers[] = $referrer;
            $record->referrer = $referrers;
        }

        $record->addLog();

        return $record;
    }

    public function addLog(): static
    {
        if (!$this->exists) {
            $this->count = 1;
            $this->save();
        } else {
            $this->increment('count');
        }

        return $this;
    }

    //
    // Concerns
    //

    public function prunable(): Builder
    {
        return static::query()->where('created_at', '<=', now()->subDays(setting('activity_log_timeout', 60)));
    }
}
