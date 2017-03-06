<?php
defined('BASEPATH') or exit('No direct script access allowed');

use TastyIgniter\Database\Model;

class Page_anywhere_model extends Model
{
	/**
	 * @var string The database table name
	 */
	protected $table = 'page_anywhere_ref';

	/**
	 * @var string The database table primary key
	 */
	protected $primaryKey = 'pa_id';

	protected $fillable = ['layout_id', 'page_id', 'partial', 'status'];

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
		return $query;
	}

	/**
	 * Return all page_anywhere_refs from the database
	 *
	 * @return array
	 */
	public function getPageAnywhereRefs()
	{
		return $this->getAsArray();
	}

	/**
	 * Create a new or update existing pageref
	 *
	 * @param int $pa_id
	 * @param array $save input post data
	 *
	 * @return bool|int The $pa_id of the affected row, or FALSE on failure
	 */
	public function savePageAnywhereRef($pa_id, $save = [])
	{
		if (empty($save)) return FALSE;

		$pageRefModel = $this->findOrNew($pa_id);

		$pageRefModel->fill($save)->save();
	}

	public function savePageAnywhereRefs($paRefs)
	{
		if (empty($paRefs)) return FALSE;

		foreach ($paRefs as $value){
			$this->savePageAnywhereRef($value['pa_id'], $value);
		}

		return TRUE;
	}

	/**
	 * Delete a multiple page_refs by pa_id
	 *
	 * @param array $page_refs
	 *
	 * @return true if done
	 */
	public function deletePageAnywhereRefs($deleteRequests)
	{
		if ($deleteRequests) {
			foreach($deleteRequests as $pa_id) {
				if (is_numeric($pa_id)) {
					$this->find($pa_id)->delete();
				}
			}
		}

		return true;
	}
}

/* End of file Page_anywhere_model.php */
/* Location: ./system/tastyigniter/models/Page_anywhere_model.php */