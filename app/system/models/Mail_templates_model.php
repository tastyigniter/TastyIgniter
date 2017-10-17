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
class Mail_templates_model extends TI_Model {

	public function getList() {
		$this->db->from('mail_templates');
		$this->db->order_by('template_id', 'ASC');

		$query = $this->db->get();
		$result = array();

		if ($query->num_rows() > 0) {
			$result = $query->result_array();
		}

		return $result;
	}

	public function getTemplates() {
		$this->db->from('mail_templates');

		$query = $this->db->get();

		$result = array();

		if ($query->num_rows() > 0) {
			$result = $query->result_array();
		}

		return $result;
	}

	public function getTemplate($template_id) {
		$this->db->from('mail_templates');

		$this->db->where('template_id', $template_id);

		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			return $query->row_array();
		}

		return FALSE;
	}

	public function getAllTemplateData($template_id) {
		$result = array();

		if ($template_id) {
			$this->db->from('mail_templates_data');
			$this->db->order_by('template_data_id', 'ASC');
			$this->db->where('template_id', $template_id);

			$query = $this->db->get();

			if ($query->num_rows() > 0) {
				$result = $query->result_array();
			}
		}

		return $result;
	}

	public function getTemplateData($template_id, $template_code) {
		if (is_numeric($template_id) AND is_string($template_code)) {
			$this->db->from('mail_templates_data');
			$this->db->join('mail_templates', 'mail_templates.template_id = mail_templates_data.template_id', 'left');
			$this->db->where('mail_templates_data.template_id', $template_id);
			$this->db->where('mail_templates_data.code', $template_code);
			$this->db->where('mail_templates.status', '1');

			$query = $this->db->get();

			if ($query->num_rows() > 0) {
				return $query->row_array();
			}
		}
	}

	public function saveTemplate($template_id, $save = array()) {
		if (empty($save)) return FALSE;

		if (isset($save['name'])) {
			$this->db->set('name', $save['name']);
		}

		if (isset($save['language_id'])) {
			$this->db->set('language_id', $save['language_id']);
		}

		if (isset($save['status']) AND $save['status'] === '1') {
			$this->db->set('status', '1');
		} else {
			$this->db->set('status', '0');
		}

		if (is_numeric($template_id)) {
			$this->db->set('date_updated', mdate('%Y-%m-%d %H:%i:%s', time()));
			$this->db->where('template_id', $template_id);
			$query = $this->db->update('mail_templates');
		} else {
			$this->db->set('date_added', mdate('%Y-%m-%d %H:%i:%s', time()));
			$this->db->set('date_updated', mdate('%Y-%m-%d %H:%i:%s', time()));
			$query = $this->db->insert('mail_templates');
			$template_id = $this->db->insert_id();
		}

		if ($query === TRUE AND is_numeric($template_id)) {
			if ( ! empty($save['clone_template_id'])) {
				$templates = $this->getAllTemplateData($save['clone_template_id']);
				$this->updateTemplateData($template_id, $templates, $save['clone_template_id']);
			} else if ( ! empty($save['templates'])) {
				$this->updateTemplateData($template_id, $save['templates']);
			}

			return $template_id;
		}
	}

	public function updateTemplateData($template_id, $templates = array(), $clone_template_id = FALSE) {
		$query = FALSE;

		if (empty($templates)) return FALSE;

		foreach ($templates as $template) {
			if (isset($template['subject'])) {
				$this->db->set('subject', $template['subject']);
			}

			if (isset($template['body'])) {
				$this->db->set('body', preg_replace('~>\s+<~m', '><', $template['body']));
			}

			if (isset($template['date_updated'])) {
				$this->db->set('date_updated', $template['date_updated']);
			}

			if ( ! empty($template_id)) {
				if ( ! $clone_template_id AND ! empty($template['code'])) {
					$this->db->set('date_updated', mdate('%Y-%m-%d %H:%i:%s', time()));
					$this->db->where('template_id', $template_id);
					$this->db->where('code', $template['code']);
					$query = $this->db->update('mail_templates_data');
				} else if ( ! empty($template['code'])) {
					$this->db->set('date_added', mdate('%Y-%m-%d %H:%i:%s', time()));
					$this->db->set('date_updated', mdate('%Y-%m-%d %H:%i:%s', time()));
					$this->db->set('template_id', $template_id);
					$this->db->set('code', $template['code']);
					$query = $this->db->insert('mail_templates_data');
				}
			}
		}

		return $query;
	}

	public function deleteTemplate($template_id) {
		if (is_numeric($template_id)) $template_id = array($template_id);

		foreach ($template_id as $key => $value) {
			if ($value === $this->config->item('mail_template_id')) {
				unset($template_id[$key]);
			}
		}

		if ( ! empty($template_id) AND ctype_digit(implode('', $template_id))) {
			$this->db->where_in('template_id', $template_id);
			$this->db->where('template_id !=', '11');
			$this->db->delete('mail_templates');

			if (($affected_rows = $this->db->affected_rows()) > 0) {
				$this->db->where_in('template_id', $template_id);
				$this->db->where('template_id !=', '11');
				$this->db->delete('mail_templates_data');

				return $affected_rows;
			}
		}
	}
}

/* End of file mail_templates_model.php */
/* Location: ./system/tastyigniter/models/mail_templates_model.php */