<?php
class Mail_templates_model extends CI_Model {

	public function getList() {
		$this->db->from('mail_templates');
		
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

	public function getAllTemplateData($template_id) {
		$result = array();

		if ($template_id) {
			$this->db->from('mail_templates_data');
			$this->db->where('template_id', $template_id);

			$query = $this->db->get();
	
			if ($query->num_rows() > 0) {
				$result = $query->result_array();
			}
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

	public function getTemplateData($template_id, $template_code) {
		if ($template_id AND $template_code) {
			$this->db->from('mail_templates_data');
			$this->db->join('mail_templates', 'mail_templates.template_id = mail_templates_data.template_id', 'left');
			$this->db->where('mail_templates_data.template_id', $template_id);
			$this->db->where('mail_templates_data.code', $template_code);

			$query = $this->db->get();
	
			if ($query->num_rows() > 0) {
				return $query->row_array();
			}
		}
	}

	public function updateTemplate($update = array()) {
		$query = FALSE;

		if (!empty($update['name'])) {
			$this->db->set('name', $update['name']);
		}
		
		if (!empty($update['language_id'])) {
			$this->db->set('language_id', $update['language_id']);
		}
		
		if (!empty($update['date_added'])) {
			$this->db->set('date_added', $update['date_added']);
		}
		
		if (!empty($update['date_updated'])) {
			$this->db->set('date_updated', $update['date_updated']);
		}
		
		if ($update['status'] === '1') {
			$this->db->set('status', '1');
		} else {
			$this->db->set('status', '0');
		}
		
		if (!empty($update['template_id'])) {
			$this->db->where('template_id', $update['template_id']);
			$this->db->update('mail_templates');			
		}		

		if ($this->db->affected_rows() > 0) {
			$query = TRUE;
		}

		return $query;
	}

	public function updateTemplateData($update = array()) {
		$query = FALSE;

		if (!empty($update['subject'])) {
			$this->db->set('subject', $update['subject']);
		}
		
		if (!empty($update['body'])) {
			$this->db->set('body', $update['body']);
		}
		
		if (!empty($update['date_updated'])) {
			$this->db->set('date_updated', $update['date_updated']);
		}
		
		if (!empty($update['template_id']) AND !empty($update['code'])) {
			$this->db->where('template_id', $update['template_id']);
			$this->db->where('code', $update['code']);
			$this->db->update('mail_templates_data');			
		}		

		if ($this->db->affected_rows() > 0) {
			$query = TRUE;
		}

		return $query;
	}

	public function addTemplate($add = array()) {

		if (!empty($add['name'])) {
			$this->db->set('name', $add['name']);
		}
		
		if (!empty($add['language_id'])) {
			$this->db->set('language_id', $add['language_id']);
		}
		
		if (!empty($add['date_added'])) {
			$this->db->set('date_added', $add['date_added']);
		}
		
		if (!empty($add['date_updated'])) {
			$this->db->set('date_updated', $add['date_updated']);
		}
		
		if ($add['status'] === '1') {
			$this->db->set('status', '1');
		} else {
			$this->db->set('status', '0');
		}
		
		$this->db->insert('mail_templates');			

		if ($this->db->affected_rows() > 0) {
			$template_id = $this->db->insert_id();
			$templates = $this->getAllTemplateData($add['clone_template_id']);
			foreach ($templates as $template) {
				$this->db->set('template_id', $template_id);
				$this->db->set('code', $template['code']);
				$this->db->set('subject', $template['subject']);
				$this->db->set('body', $template['body']);
				$this->db->set('date_added', $add['date_added']);
				$this->db->set('date_updated', $add['date_updated']);

				$this->db->insert('mail_templates_data');			
			}
			
			return TRUE;
		}
	}

	public function deleteTemplate($template_id) {
		if ($template_id !== '11') {
			$this->db->where('template_id', $template_id);
			$this->db->delete('mail_templates');

			$this->db->where('template_id', $template_id);
			$this->db->delete('mail_templates_data');
		}
		
		if ($this->db->affected_rows() > 0) {
			return TRUE;
		}
	}
}

/* End of file mail_templates_model.php */
/* Location: ./application/models/mail_templates_model.php */