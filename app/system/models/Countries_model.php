<?php

namespace System\Models;

use Igniter\Flame\Database\Model;
use Igniter\Flame\Database\Traits\Sortable;
use Igniter\Flame\Exception\ValidationException;

/**
 * Countries Model Class
 */
class Countries_model extends Model
{
    use Sortable;

    const SORT_ORDER = 'priority';

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
        'status' => 'boolean',
        'priority' => 'integer',
    ];

    public $relation = [
        'hasOne' => [
            'currency' => 'System\Models\Currencies_model',
        ],
    ];

    public $timestamps = true;

    /**
     * @var self Default country cache.
     */
    protected static $defaultCountry;

    public static function getDropdownOptions()
    {
        return static::isEnabled()->dropdown('country_name');
    }

    public function makeDefault()
    {
        if (!$this->status) {
            throw new ValidationException(['status' => sprintf(
                lang('admin::lang.alert_error_set_default'), $this->country_name
            )]);
        }

        setting('country_id', $this->country_id);
        setting()->save();
    }

    /**
     * Returns the default currency defined.
     * @return self
     */
    public static function getDefault()
    {
        if (self::$defaultCountry !== null) {
            return self::$defaultCountry;
        }

        $defaultCountry = self::isEnabled()
            ->where('country_id', setting('country_id'))
            ->first();

        if (!$defaultCountry) {
            if ($defaultCountry = self::whereIsEnabled()->first()) {
                $defaultCountry->makeDefault();
            }
        }

        return self::$defaultCountry = $defaultCountry;
    }

    //
    // Scopes
    //

    /**
     * Scope a query to only include enabled country
     * @return $this
     */
    public function scopeIsEnabled($query)
    {
        return $query->where('status', 1);
    }
}
