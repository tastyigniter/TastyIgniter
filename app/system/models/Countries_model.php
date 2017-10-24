<?php namespace System\Models;

use Admin\Models\Image_tool_model;
use Model;

/**
 * Countries Model Class
 *
 * @package System
 */
class Countries_model extends Model
{
	/**
	 * @var string The database table name
	 */
	protected $table = 'countries';

	/**
	 * @var string The database table primary key
	 */
	protected $primaryKey = 'country_id';

	protected $fillable = ['country_id', 'country_name', 'iso_code_2', 'iso_code_3', 'format', 'status', 'flag'];

	public $relation = [
        'hasOne' => [
            'currency' => 'System\Models\Currencies_model',
        ]
	];

    public static function getDropdownOptions()
    {
        return static::isEnabled()->dropdown('country_name');
	}

    //
    // Accessors & Mutators
    //

    public function getFlagUrlAttribute($value)
    {
        return Image_tool_model::resize($this->flag, ['default' => 'flags/no_flag.png']);
	}

    //
    // Scopes
    //

    /**
	 * Scope a query to only include enabled country
	 *
	 * @return $this
	 */
    public function scopeIsEnabled($query)
    {
        return $query->where('status', 1);
    }

	/**
	 * Filter database records
	 *
	 * @param $query
	 * @param array $filter an associative array of field/value pairs
	 *
	 * @return $this
	 */
	public function scopeFilter($query, $filter = [])
	{
		if (isset($filter['filter_search']) AND is_string($filter['filter_search'])) {
			$query->search($filter['filter_search'], ['country_name']);
		}

		if (isset($filter['filter_status']) AND is_numeric($filter['filter_status'])) {
			$query->where('status', $filter['filter_status']);
		}

		return $query;
	}

    //
    // Helpers
    //

    /**
	 * Return all countries from the database
	 *
	 * @return array
	 */
	public function getCountries()
	{
		return $this->orderBy('country_name')->get();
	}

	/**
	 * Find a single country by country_id
	 *
	 * @param int $country_id
	 *
	 * @return array
	 */
	public function getCountry($country_id)
	{
		return $this->find($country_id);
	}

	/**
	 * Create a new or update existing country
	 *
	 * @param int $country_id
	 * @param array $save
	 *
	 * @return bool|int The $country_id of the affected row, or FALSE on failure
	 */
	public function saveCountry($country_id, $save = [])
	{
		if (empty($save)) return FALSE;

		$countryModel = $this->findOrNew($country_id);

		$saved = $countryModel->fill($save)->save();

		return $saved ? $countryModel->getKey() : $saved;
	}

	/**
	 * Delete a single or multiple country by country_id
	 *
	 * @param string|array $country_id
	 *
	 * @return int The number of deleted rows
	 */
	public function deleteCountry($country_id)
	{
		if (is_numeric($country_id)) $country_id = [$country_id];

		if (!empty($country_id) AND ctype_digit(implode('', $country_id))) {
			return $this->whereIn('country_id', $country_id)->delete();
		}
	}
}