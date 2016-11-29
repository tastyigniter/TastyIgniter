<?php
/**
 * TastyIgniter
 *
 * An open source online ordering, reservation and management system for restaurants.
 *
 * @package       TastyIgniter
 * @author        SamPoyigi
 * @copyright (c) 2013 - 2016. TastyIgniter
 * @link          http://tastyigniter.com
 * @license       http://opensource.org/licenses/GPL-3.0 The GNU GENERAL PUBLIC LICENSE
 * @since         File available since Release 1.0
 */
defined('BASEPATH') or exit('No direct script access allowed');

use TastyIgniter\Database\Model;

/**
 * Layout modules Model Class
 *
 * @category       Models
 * @package        TastyIgniter\Models\Layout_modules_model.php
 * @link           http://docs.tastyigniter.com
 */
class Layout_modules_model extends Model
{
	/**
	 * @var string The database table name
	 */
	protected $table = 'layout_modules';

	protected $primaryKey = 'layout_module_id';

	protected $casts = [
		'options' => 'array',
	];

	/**
	 * Return all layout modules
	 *
	 * @param int $layout_id
	 *
	 * @return array
	 */
	public function getLayoutModules()
	{
		$result = [];

		if ($modules = $this->getAsArray()) {
			foreach ($modules as $row) {
				$options = $row['options'];
				$row['title'] = isset($options['title']) ? htmlspecialchars_decode($options['title']) : '';
				$row['fixed'] = isset($options['fixed']) ? $options['fixed'] : '';
				$row['fixed_top_offset'] = isset($options['fixed_top_offset']) ? $options['fixed_top_offset'] : '';
				$row['fixed_bottom_offset'] = isset($options['fixed_bottom_offset']) ? $options['fixed_bottom_offset'] : '';

				$result[$row['layout_id']][] = $row;
			}
		}

		return $result;
	}

	public function createLayoutModules($layout_id, $modules = [])
	{
		if (empty($modules))
			return FALSE;

		$priority = 1;
		foreach ($modules as $module) {
			if (!empty($module) AND is_array($module)) {
				$options['title'] = isset($module['title']) ? htmlspecialchars($module['title']) : '';
				$options['fixed'] = isset($module['fixed']) ? $module['fixed'] : '';
				$options['fixed_top_offset'] = isset($module['fixed_top_offset']) ? $module['fixed_top_offset'] : '';
				$options['fixed_bottom_offset'] = isset($module['fixed_bottom_offset']) ? $module['fixed_bottom_offset'] : '';

				$query = $this->Layout_modules_model->create([
					'layout_id'   => $layout_id,
					'module_code' => $module['module_code'],
					'partial'     => $module['partial'],
					'priority'    => $priority,
					'options'     => $options,
					'status'      => $module['status'],
				]);

				$priority++;
			}
		}

		return $query;
	}
}

/* End of file Layout_modules_model.php */
/* Location: ./system/tastyigniter/models/Layout_modules_model.php */