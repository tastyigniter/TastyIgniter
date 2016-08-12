<?php
/**
 * TastyIgniter
 *
 * An open source online ordering, reservation and management system for restaurants.
 *
 * @package   TastyIgniter
 * @author    SamPoyigi
 * @copyright TastyIgniter
 * @link      http://tastyigniter.com
 * @license   http://opensource.org/licenses/GPL-3.0 The GNU GENERAL PUBLIC LICENSE
 * @since     File available since Release 2.2
 */
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Layout modules Model Class
 *
 * @category       Models
 * @package        TastyIgniter\Models\Layout_modules_model.php
 * @link           http://docs.tastyigniter.com
 */
class Layout_modules_model extends TI_Model
{
	/**
	 * @var string The database table name
	 */
	protected $table_name = 'layout_modules';

	protected $primary_key = 'layout_module_id';

	/**
	 * Return all layout modules
	 *
	 * @param int $layout_id
	 *
	 * @return array
	 */
	public function getLayoutModules() {
		$result = array();

		if ($modules = $this->find_all()) {
			foreach ($modules as $row) {
				$row['options'] = $options = !empty($row['options']) ? unserialize($row['options']) : array();
				$row['title'] = isset($options['title']) ? htmlspecialchars_decode($options['title']) : '';
				$row['fixed'] = isset($options['fixed']) ? $options['fixed'] : '';
				$row['fixed_top_offset'] = isset($options['fixed_top_offset']) ? $options['fixed_top_offset'] : '';
				$row['fixed_bottom_offset'] = isset($options['fixed_bottom_offset']) ? $options['fixed_bottom_offset'] : '';

				$result[$row['layout_id']][] = $row;
			}
		}

		return $result;
	}
}

/* End of file Layout_modules_model.php */
/* Location: ./system/tastyigniter/models/Layout_modules_model.php */