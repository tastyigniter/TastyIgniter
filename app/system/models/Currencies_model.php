<?php namespace System\Models;

use Igniter\Flame\Currency\Models\Currency;

/**
 * Currencies Model Class
 * @package System
 */
class Currencies_model extends Currency
{
    const CREATED_AT = null;

    const UPDATED_AT = 'date_modified';

    /**
     * @var string The database table name
     */
    protected $table = 'currencies';

    /**
     * @var string The database table primary key
     */
    protected $primaryKey = 'currency_id';

    /**
     * @var array The model table column to convert to dates on insert/update
     */
    public $timestamps = TRUE;

    public $casts = [
        'country_id' => 'integer',
        'currency_rate' => 'float',
        'symbol_position' => 'boolean',
        'currency_status' => 'boolean',
    ];

    public $relation = [
        'belongsTo' => [
            'country' => 'System\Models\Countries_model',
        ],
    ];

    public static function getDropdownOptions()
    {
        return static::select(['currency_id', 'currencies.country_id', 'priority'])
                     ->selectRaw("CONCAT_WS(' - ', country_name, currency_code, currency_symbol) as name")
                     ->leftJoin('countries', 'currencies.country_id', '=', 'countries.country_id')
                     ->orderBy('priority')
                     ->where('currency_status', 1)
                     ->dropdown('name', 'currency_id');
    }

    public static function getConverterDropdownOptions()
    {
        return [
            'openexchangerates' => 'lang:system::lang.settings.text_openexchangerates',
            'fixerio' => 'lang:system::lang.settings.text_fixerio',
        ];
    }

    protected function afterSave()
    {
        app('currency')->clearCache();
    }

    protected function afterDelete()
    {
        app('currency')->clearCache();
    }

    public function updateRate($currencyRate)
    {
        $this->currency_rate = $currencyRate;
        $this->save();
    }

    public function scopeWhereIsEnabled($query)
    {
        return $query->where('currency_status', 1);
    }

    //
    //
    //

    public function getId()
    {
        return $this->currency_id;
    }

    public function getName()
    {
        return $this->currency_name;
    }

    public function getCode()
    {
        return $this->currency_code;
    }

    public function getSymbol()
    {
        return $this->currency_symbol;
    }

    public function getSymbolPosition()
    {
        return $this->symbol_position;
    }

    public function getFormat()
    {
        $format = $this->thousand_sign.'0'.$this->decimal_sign;
        $format .= str_repeat('0', $this->decimal_position);

        return $this->getSymbolPosition()
            ? '1'.$format.$this->getSymbol()
            : $this->getSymbol().'1'.$format;
    }

    public function getRate()
    {
        return $this->currency_rate;
    }

    public function isEnabled()
    {
        return $this->currency_status;
    }
}