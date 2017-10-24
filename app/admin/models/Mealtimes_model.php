<?php namespace Admin\Models;

use Model;

/**
 * Mealtimes Model Class
 *
 * @package Admin
 */
class Mealtimes_model extends Model
{
	/**
	 * @var string The database table name
	 */
	protected $table = 'mealtimes';

	/**
	 * @var string The database table primary key
	 */
	protected $primaryKey = 'mealtime_id';

	public $casts = [
	    'start_time' => 'time',
	    'end_time' => 'time'
    ];

    public function getDropdownOptions()
    {
        $this->isEnabled()->dropdown('mealtime_name');
	}

    //
    // Scopes
    //

    public function scopeIsEnabled($query)
    {
        return $query->where('mealtime_status', 1);
	}

    //
    // Helpers
    //

    public function availableNow()
    {
        $currentTime = time();
        return (strtotime($this->start_time) <= $currentTime AND strtotime($this->end_time) >= $currentTime);
    }

    /**
	 * Return all enabled mealtimes
	 * @return array
	 */
	public function getMealtimes()
	{
		return $this->get();
	}

	/**
	 * Find a single mealtime by mealtime_id
	 *
	 * @param $mealtime_id
	 *
	 * @return object
	 */
	public function getMealtime($mealtime_id)
	{
		return $this->find($mealtime_id);
	}

	/**
	 * Create a new or update existing mealtimes
	 *
	 * @param array $mealtimes
	 *
	 * @return bool
	 */
	public function updateMealtimes($mealtimes = [])
	{
		$query = FALSE;

		if (!empty($mealtimes)) {
			foreach ($mealtimes as $mealtime) {
				$this->findOrNew($mealtime['mealtime_id'])->fill($mealtime)->save();
			}

			$query = TRUE;
		}

		return $query;
	}
}