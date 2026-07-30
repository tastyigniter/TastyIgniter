<?php

declare(strict_types=1);

namespace Igniter\System\Models;

use Igniter\Flame\Database\Builder;
use Igniter\Flame\Database\Factories\HasFactory;
use Igniter\Flame\Database\Model;
use Igniter\Flame\Database\Traits\Sortable;
use Igniter\System\Models\Concerns\Defaultable;
use Igniter\System\Models\Concerns\Switchable;
use Illuminate\Support\Carbon;

/**
 * Country Model Class
 *
 * @property int $country_id
 * @property string $country_name
 * @property string|null $iso_code_2
 * @property string|null $iso_code_3
 * @property string|null $format
 * @property int $status
 * @property int $priority
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property bool $is_default
 * @method static Builder<static>|Country applyDefaultable(bool $default = true)
 * @method static Builder<static>|Country applyFilters(array $options = [])
 * @method static Builder<static>|Country applySorts(array $sorts = [])
 * @method static Builder<static>|Country applySwitchable(bool $switch = true)
 * @method static Builder<static>|Country isEnabled()
 * @method static Builder<static>|Country listFrontEnd(array $options = [])
 * @method static Builder<static>|Country newModelQuery()
 * @method static Builder<static>|Country newQuery()
 * @method static Builder<static>|Country query()
 * @method static Builder<static>|Country sorted()
 * @method static Builder<static>|Country whereIsDisabled()
 * @method static Builder<static>|Country whereIsEnabled()
 * @method static Builder<static>|Country whereNotDefault()
 * @mixin \Illuminate\Database\Eloquent\Model
 */
class Country extends Model
{
    use Defaultable;
    use HasFactory;
    use Sortable;
    use Switchable;

    public const string SORT_ORDER = 'priority';

    /**
     * @var string The database table name
     */
    protected $table = 'countries';

    /**
     * @var string The database table primary key
     */
    protected $primaryKey = 'country_id';

    protected $guarded = [];

    protected $casts = [
        'priority' => 'integer',
    ];

    public $relation = [
        'hasOne' => [
            'currency' => Currency::class,
        ],
    ];

    public $timestamps = true;

    public static function getDropdownOptions()
    {
        return static::whereIsEnabled()->dropdown('country_name');
    }

    public function defaultableName()
    {
        return $this->country_name;
    }
}
