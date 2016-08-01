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
 * @since     File available since Release 1.0
 */
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Menu_options Model Class
 *
 * @category       Models
 * @package        TastyIgniter\Models\Menu_options_model.php
 * @link           http://docs.tastyigniter.com
 */
class Menu_options_model extends TI_Model
{
	/**
	 * @var string The database table name
	 */
	protected $table_name = 'options';

	/**
	 * @var string The database table primary key
	 */
	protected $primary_key = 'option_id';

	/**
	 * Count the number of records
	 *
	 * @param array $filter
	 *
	 * @return int
	 */
	public function getCount($filter = array()) {
		return $this->filter($filter)->count();
	}

	/**
	 * List all options matching the filter
	 *
	 * @param array $filter
	 *
	 * @return array
	 */
	public function getList($filter = array()) {
		return $this->filter($filter)->find_all();
	}

	/**
	 * Filter database records
	 *
	 * @param array $filter an associative array of field/value pairs
	 *
	 * @return $this
	 */
	public function filter($filter = array()) {
		if (!empty($filter['filter_search'])) {
			$this->like('option_name', $filter['filter_search']);
		}

		if (!empty($filter['filter_display_type'])) {
			$this->where('display_type', $filter['filter_display_type']);
		}

		return $this;
	}

	/**
	 * Return all option values by option_id
	 *
	 * @param int $option_id
	 *
	 * @return array
	 */
	public function getOptionValues($option_id = NULL) {
		if ($option_id !== FALSE) {
			$this->where('option_id', $option_id);
		}

		return $this->order_by('priority')->from('option_values')->get_many();
	}

	/**
	 * Find a single option by option_id
	 *
	 * @param $option_id
	 *
	 * @return mixed
	 */
	public function getOption($option_id) {
		return $this->find($option_id);
	}

	/**
	 * Return all menu options by menu_id
	 *
	 * @param int $menu_id
	 *
	 * @return array
	 */
	public function getMenuOptions($menu_id = NULL) {
		$results = array();

		$this->select('*, menu_options.menu_id, menu_options.option_id');
		$this->join('options', 'options.option_id = menu_options.option_id', 'left');

		if (is_numeric($menu_id)) {
			$this->where('menu_options.menu_id', $menu_id);
		}

		if ($result = $this->order_by('options.priority')->from('menu_options')->get_many()) {
			foreach ($result as $row) {
				$results[] = array_merge($row, array(
					'option_values' => $this->getMenuOptionValues($row['menu_option_id'], $row['option_id']),
				));
			}
		}

		return $results;
	}

	/**
	 * Return all menu option values by menu_option_id and option_id
	 *
	 * @param int $menu_option_id
	 * @param int $option_id
	 *
	 * @return array
	 */
	public function getMenuOptionValues($menu_option_id = NULL, $option_id = NULL) {
		$result = array();

		if (is_numeric($menu_option_id) AND is_numeric($option_id)) {
			$this->select('*, menu_option_values.option_id, option_values.option_value_id');
			$this->join('option_values', 'option_values.option_value_id = menu_option_values.option_value_id', 'left');
			$this->where('menu_option_values.menu_option_id', $menu_option_id);
			$this->where('menu_option_values.option_id', $option_id);

			$result = $this->order_by('option_values.priority')->from('menu_option_values')->get_many();
		}

		return $result;
	}

	/**
	 * List all options matching the filter,
	 * to fill select auto-complete options
	 *
	 * @param array $filter
	 *
	 * @return array
	 */
	public function getAutoComplete($filter = array()) {
		if (is_array($filter) AND !empty($filter)) {
			if (!empty($filter['option_name'])) {
				$this->like('option_name', $filter['option_name']);
			}

			$result = array();
			if ($rows = $this->find_all()) {
				foreach ($rows as $row) {
					$result[] = array_merge($row, array(
						'option_values' => $this->getOptionValues($row['option_id']),
					));
				}
			}

			return $result;
		}
	}

	/**
	 * Create a new or update existing options
	 *
	 * @param int   $option_id
	 * @param array $save
	 *
	 * @return bool|int The $option_id of the affected row, or FALSE on failure
	 */
	public function saveOption($option_id, $save = array()) {
		if (empty($save)) return FALSE;

		if ($option_id = $this->skip_validation(TRUE)->save($save, $option_id)) {
			$save['option_values'] = isset($save['option_values']) ? $save['option_values'] : array();
			$this->addOptionValues($option_id, $save['option_values']);

			return $option_id;
		}
	}

	/**
	 * Create a new or update existing option values
	 *
	 * @param bool  $option_id
	 * @param array $option_values
	 *
	 * @return bool
	 */
	public function addOptionValues($option_id = FALSE, $option_values = array()) {
		$query = FALSE;

		if ($option_id !== FALSE AND !empty($option_values) AND is_array($option_values)) {
			$this->delete_from('option_values', array('option_id', $option_id));

			$priority = 1;
			foreach ($option_values as $key => $value) {
				$query = $this->insert_into('option_values', array_merge($value, array(
					'priority'  => $priority,
					'option_id' => $option_id,
				)));

				$priority++;
			}
		}

		return $query;
	}

	/**
	 * Create a new or update existing menu options
	 *
	 * @param bool  $menu_id
	 * @param array $menu_options
	 *
	 * @return bool
	 */
	public function addMenuOption($menu_id = FALSE, $menu_options = array()) {
		$query = FALSE;

		if ($menu_id !== FALSE) {
			$this->delete_from('menu_options', array('menu_id' => $menu_id));
			$this->delete_from('menu_option_values', array('menu_id' => $menu_id));

			if (!empty($menu_options)) {
				foreach ($menu_options as $option) {
					$option_values = $option['option_values'];
					$option = array_merge($option, array(
						'menu_id'          => $menu_id,
						'default_value_id' => empty($option['default_value_id']) ? '0' : $option['default_value_id'],
						'option_values'    => serialize($option['option_values']),
					));

					if ($menu_option_id = $this->insert_into('menu_options', $option)) {
						$this->addMenuOptionValues($menu_option_id, $menu_id, $option['option_id'], $option_values);
					}
				}
			}
		}

		return $query;
	}

	/**
	 * Create a new or update existing menu option values
	 *
	 * @param int   $menu_option_id
	 * @param int   $menu_id
	 * @param int   $option_id
	 * @param array $option_values
	 */
	public function addMenuOptionValues($menu_option_id = NULL, $menu_id = NULL, $option_id = NULL, $option_values = array()) {
		if ($menu_option_id !== NULL AND $menu_id !== NULL AND $option_id !== NULL AND !empty($option_values)) {
			foreach ($option_values as $value) {
				$value = array_merge($value, array(
					'menu_option_id' => $menu_option_id,
					'menu_id'        => $menu_id,
					'option_id'      => $option_id,
					'new_price'      => $value['price'],
				));

				$this->insert_into('menu_option_values', $value);
			}
		}
	}

	/**
	 * Delete a single or multiple option by option_id
	 *
	 * @param string|array $option_id
	 *
	 * @return int The number of deleted rows
	 */
	public function deleteOption($option_id) {
		if (is_numeric($option_id)) $option_id = array($option_id);

		if (!empty($option_id) AND ctype_digit(implode('', $option_id))) {
			$affected_rows = $this->delete('option_id', $option_id);

			if ($affected_rows > 0) {
				$this->delete_from('option_values', array('option_id', $option_id));

				$this->delete_from('menu_options', array('option_id', $option_id));

				$this->delete_from('menu_option_values', array('option_id', $option_id));

				return $affected_rows;
			}
		}
	}

	/**
	 * Delete a single or multiple menu option by menu_id
	 *
	 * @param string|array $menu_id
	 *
	 * @return int The number of deleted rows
	 */
	public function deleteMenuOption($menu_id) {
		if (is_numeric($menu_id)) $menu_id = array($menu_id);

		if (!empty($menu_id) AND ctype_digit(implode('', $menu_id))) {
			$this->delete_from('menu_options', array('menu_id', $menu_id));

			if (($affected_rows = $this->affected_rows()) > 0) {
				$this->delete_from('menu_option_values', array('menu_id', $menu_id));

				return $affected_rows;
			}
		}
	}
}

/* End of file Menu_options_model.php */
/* Location: ./system/tastyigniter/models/Menu_options_model.php */