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
 * Mail_templates Model Class
 *
 * @category       Models
 * @package        TastyIgniter\Models\Mail_templates_model.php
 * @link           http://docs.tastyigniter.com
 */
class Mail_templates_model extends TI_Model
{
	/**
	 * @var string The database table name
	 */
	protected $table_name = 'mail_templates';

	/**
	 * @var string The database table primary key
	 */
	protected $primary_key = 'template_id';

	/**
	 * @var array The model table column to convert to dates on insert/update
	 */
	protected $timestamps = array('created', 'updated');

	/**
	 * Scope a query to only include enabled mail template
	 *
	 * @return $this
	 */
	public function isEnabled() {
		return $this->where('status', '1');
	}

	/**
	 * Count the number of records
	 *
	 * @param array $filter
	 *
	 * @return int
	 */
	public function getCount($filter = array()) {
		return $this->filter($filter)->count_all();
	}

	/**
	 * List all coupons matching the filter
	 *
	 * @param array $filter
	 *
	 * @return array
	 */
	public function getList($filter = array()) {
		return $this->filter($filter)->order_by('template_id')->find_all();
	}

	/**
	 * Return all mail templates
	 *
	 * @return array
	 */
	public function getTemplates() {
		return $this->find_all();
	}

	/**
	 * Find a single mail template by template_id
	 *
	 * @param $template_id
	 *
	 * @return bool
	 */
	public function getTemplate($template_id) {
		return $this->find($template_id);
	}

	/**
	 * Return all mail templates data by template_id
	 *
	 * @param $template_id
	 *
	 * @return array
	 */
	public function getAllTemplateData($template_id) {
		$result = array();

		if ($template_id) {
			$this->load->model('Mail_templates_data_model');
			$this->Mail_templates_data_model->where('template_id', $template_id);

			$result = $this->Mail_templates_data_model->order_by('template_data_id')->find_all();
		}

		return $result;
	}

	/**
	 * Find a single mail template by template id and code
	 *
	 * @param $template_id
	 * @param $template_code
	 *
	 * @return mixed
	 */
	public function getTemplateData($template_id, $template_code) {
		if (is_numeric($template_id) AND is_string($template_code)) {
			$this->load->model('Mail_templates_data_model');
			$this->Mail_templates_data_model->join('mail_templates', 'mail_templates.template_id = mail_templates_data.template_id', 'left');
			$this->Mail_templates_data_model->where('mail_templates_data.template_id', $template_id);
			$this->Mail_templates_data_model->where('mail_templates_data.code', $template_code);
			$this->Mail_templates_data_model->where('mail_templates.status', '1');

			return $this->Mail_templates_data_model->find();
		}
	}

	/**
	 * Create a new or update existing mail template
	 *
	 * @param       $template_id
	 * @param array $save
	 *
	 * @return bool|int The $template_id of the affected row, or FALSE on failure
	 */
	public function saveTemplate($template_id, $save = array()) {
		if (empty($save)) return FALSE;

		if ($template_id = $this->save($save, $template_id)) {
			if (!empty($save['clone_template_id'])) {
				$templates = $this->getAllTemplateData($save['clone_template_id']);
				$this->updateTemplateData($template_id, $templates, $save['clone_template_id']);
			} else if (!empty($save['templates'])) {
				$this->updateTemplateData($template_id, $save['templates']);
			}

			return $template_id;
		}
	}

	/**
	 * Create a new or update existing mail template data
	 *
	 * @param       $template_id
	 * @param array $templates
	 * @param bool  $clone_template_id
	 *
	 * @return bool TRUE on success, or FALSE on failure
	 */
	public function updateTemplateData($template_id, $templates = array(), $clone_template_id = FALSE) {
		$query = FALSE;

		if (empty($templates)) return FALSE;

		$this->load->model('Mail_templates_data_model');

		foreach ($templates as $template) {
			if (isset($template['body'])) {
				$template['body'] = preg_replace('~>\s+<~m', '><', $template['body']);
			}

			if (!empty($template_id)) {
				if (!$clone_template_id AND !empty($template['code'])) {
					$query = $this->Mail_templates_data_model->update(array(
						'template_id' => $template_id,
						'code'        => $template['code'],
					), $template);
				} else if (!empty($template['code'])) {
					$query = $this->Mail_templates_data_model->insert(array_merge($template, array(
						'template_id' => $template_id,
						'code'        => $template['code'],
					)));
				}
			}
		}

		return $query;
	}

	/**
	 * Delete a single or multiple mail template by template_id
	 *
	 * @param $template_id
	 *
	 * @return int The number of deleted rows
	 */
	public function deleteTemplate($template_id) {
		if (is_numeric($template_id)) $template_id = array($template_id);

		foreach ($template_id as $key => $value) {
			if ($value === $this->config->item('mail_template_id')) {
				unset($template_id[$key]);
			}
		}

		if (!empty($template_id) AND ctype_digit(implode('', $template_id))) {
			$this->where('template_id !=', '11');
			$affected_rows = $this->delete('template_id', $template_id);

			if ($affected_rows > 0) {
				$this->load->model('Mail_templates_data_model');

				$this->where('template_id !=', '11');
				$this->Mail_templates_data_model->delete('template_id', $template_id);

				return $affected_rows;
			}
		}
	}
}

/* End of file Mail_templates_model.php */
/* Location: ./system/tastyigniter/models/Mail_templates_model.php */