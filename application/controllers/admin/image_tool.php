<?php
class Image_tool extends CI_Controller {

	public function __construct() {
		parent::__construct(); //  calls the constructor
		$this->load->library('user');
	}

	public function index() {
		if (!$this->user->islogged()) {  
  			redirect('admin/login');
		}

    	if (!$this->user->hasPermissions('access', 'admin/image_tool')) {
  			redirect('admin/permission');
		}
		
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');  // retrieve session flashdata variable if available			
		} else {
			$data['alert'] = '';
		}

		$this->template->setTitle('Image Tool');
		$this->template->setHeading('Image Tool');
		$this->template->setButton('Save', array('class' => 'save_button', 'onclick' => '$(\'form\').submit();'));
		
		if (!empty($this->config->item('image_tool'))) {
			$result = $this->config->item('image_tool');
		} else {
			$result = array();
		}
		
		$data['root_folder'] 		= (isset($result['root_folder'])) ? $result['root_folder'] : '';
		$data['max_size'] 			= (isset($result['max_size'])) ? $result['max_size'] : '';
		$data['thumb_height'] 		= (isset($result['thumb_height'])) ? $result['thumb_height'] : '';
		$data['thumb_width'] 		= (isset($result['thumb_width'])) ? $result['thumb_width'] : '';
		$data['thumb_height_mini'] 	= (isset($result['thumb_height_mini'])) ? $result['thumb_height_mini'] : '';
		$data['thumb_width_mini'] 	= (isset($result['thumb_width_mini'])) ? $result['thumb_width_mini'] : '';
		$data['show_mini'] 			= (isset($result['show_mini'])) ? $result['show_mini'] : '';
		$data['show_ext'] 			= (isset($result['show_ext'])) ? $result['show_ext'] : '';
		$data['uploads'] 			= (isset($result['uploads'])) ? $result['uploads'] : '';
		$data['new_folder'] 		= (isset($result['new_folder'])) ? $result['new_folder'] : '';
		$data['copy'] 				= (isset($result['copy'])) ? $result['copy'] : '';
		$data['move'] 				= (isset($result['move'])) ? $result['move'] : '';
		$data['rename'] 			= (isset($result['rename'])) ? $result['rename'] : '';
		$data['delete'] 			= (isset($result['delete'])) ? $result['delete'] : '';
		$data['allowed_ext'] 		= (isset($result['allowed_ext'])) ? $result['allowed_ext'] : '';
		$data['hidden_files'] 		= (isset($result['hidden_files'])) ? $result['hidden_files'] : '';
		$data['hidden_folders'] 	= (isset($result['hidden_folders'])) ? $result['hidden_folders'] : '';
		$data['transliteration'] 	= (isset($result['transliteration'])) ? $result['transliteration'] : '';
		$data['remember_days'] 		= (isset($result['remember_days'])) ? $result['remember_days'] : '';
		$data['delete_thumbs']		= site_url('admin/image_tool/delete_thumbs');
		
		if ($this->input->post() AND $this->_updateImageTool() === TRUE) {
			redirect('admin/image_tool');
		}

		$this->template->regions(array('header', 'footer'));
		if (file_exists(APPPATH .'views/themes/admin/'.$this->config->item('admin_theme').'image_tool.php')) {
			$this->template->render('themes/admin/'.$this->config->item('admin_theme'), 'image_tool', $data);
		} else {
			$this->template->render('themes/admin/default/', 'image_tool', $data);
		}
	}

	public function delete_thumbs() {
		if (!$this->user->islogged()) {  
  			redirect('admin/login');
		}

    	if (!$this->user->hasPermissions('access', 'admin/image_tool')) {
  			redirect('admin/permission');
		}
		
    	if (!$this->user->hasPermissions('modify', 'admin/image_tool')) {
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to delete!</p>');
    	} else { 
			if (file_exists(IMAGEPATH . 'thumbs')) {
				$this->_delete_thumbs(IMAGEPATH . 'thumbs');
				$this->session->set_flashdata('alert', '<p class="success">Thumbs deleted sucessfully!</p>');
			}
		}
		
		redirect('admin/image_tool');
	}
	
	public function _updateImageTool() {
    	if (!$this->user->hasPermissions('modify', 'admin/image_tool')) {
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to update!</p>');
			return TRUE;
    	} else if ($this->validateForm() === TRUE) { 
			$update = array(
				'root_folder' 		=> $this->security->sanitize_filename($this->input->post('root_folder'), TRUE),
				'max_size' 			=> $this->input->post('max_size'),
				'thumb_height' 		=> $this->input->post('thumb_height'),
				'thumb_width' 		=> $this->input->post('thumb_width'),
				'thumb_height_mini' => $this->input->post('thumb_height_mini'),
				'thumb_width_mini' 	=> $this->input->post('thumb_width_mini'),
				'show_mini' 		=> $this->input->post('show_mini'),
				'show_ext' 			=> $this->input->post('show_ext'),
				'uploads' 			=> $this->input->post('uploads'),
				'new_folder' 		=> $this->input->post('new_folder'),
				'copy' 				=> $this->input->post('copy'),
				'move' 				=> $this->input->post('move'),
				'rename' 			=> $this->input->post('rename'),
				'delete' 			=> $this->input->post('delete'),
				'allowed_ext' 		=> $this->input->post('allowed_ext'),
				'hidden_files' 		=> $this->input->post('hidden_files'),
				'hidden_folders' 	=> $this->input->post('hidden_folders'),
				'transliteration'	=> $this->input->post('transliteration'),
				'remember_days'		=> $this->input->post('remember_days')
			);

			if ($this->Settings_model->addSetting('module', 'image_tool', $update, '1')) {
				$this->session->set_flashdata('alert', '<p class="success">Image Tool updated sucessfully.</p>');
			} else {
				$this->session->set_flashdata('alert', '<p class="warning">An error occured, nothing updated.</p>');
			}

			return TRUE;
		}
	}

	public function validateForm() {
		$this->form_validation->set_rules('root_folder', 'Root Folder', 'xss_clean|trim|required|callback_validate_path');
		$this->form_validation->set_rules('max_size', 'Maximum File Size', 'xss_clean|trim|required|numeric');
		$this->form_validation->set_rules('thumb_height', 'Thumbnail Height', 'xss_clean|trim|required|numeric');
		$this->form_validation->set_rules('thumb_width', 'Thumbnail Width', 'xss_clean|trim|required|numeric');
		$this->form_validation->set_rules('thumb_height_mini', 'Mini Thumbnail Height', 'xss_clean|trim|required|numeric');
		$this->form_validation->set_rules('thumb_width_mini', 'Mini Thumbnail Width', 'xss_clean|trim|required|numeric');
		$this->form_validation->set_rules('show_mini', 'Mini Thumbnail', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('show_ext', 'Show Extension', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('uploads', 'Uploads', 'xss_clean|trim|integer');
		$this->form_validation->set_rules('new_folder', 'New Folder', 'xss_clean|trim|integer');
		$this->form_validation->set_rules('copy', 'Copy', 'xss_clean|trim|integer');
		$this->form_validation->set_rules('move', 'Move', 'xss_clean|trim|integer');
		$this->form_validation->set_rules('rename', 'Rename', 'xss_clean|trim|integer');
		$this->form_validation->set_rules('delete', 'Delete', 'xss_clean|trim|integer');
		$this->form_validation->set_rules('allowed_ext', 'Allowed Extension', 'xss_clean|trim|required');
		$this->form_validation->set_rules('hidden_files', 'Hidden Files', 'xss_clean|trim|');
		$this->form_validation->set_rules('hidden_folders', 'Hidden Folders', 'xss_clean|trim|');
		$this->form_validation->set_rules('transliteration', 'Transliteration', 'xss_clean|trim|integer');
		$this->form_validation->set_rules('remember_days', 'Remember Last Folder', 'xss_clean|trim|integer');
			
		if ($this->form_validation->run() === TRUE) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function validate_path($str) {
		if (strpos($str, '/') !== FALSE OR strpos($str, './') !== FALSE) {
			$this->form_validation->set_message('validate_path', 'Root Folder must have NO SLASH!');
			return FALSE;
		}

		return TRUE;
	}

	public function _delete_thumbs($path) {
		if (file_exists($path) AND is_file($path)) {
			return unlink($path);
		}

		foreach (scandir($path) as $item) {
			if ($item != '.' AND $item != '..') {
				if ( ! is_dir($path .'/'. $item)) {
					unlink($path .'/'. $item);
				} else {
					$this->_delete_thumbs($path .'/'. $item);
				}
			}
		}
		
		if (is_dir($path)) {
			return rmdir($path);
		}
	}
}

/* End of file image_tool.php */
/* Location: ./application/controllers/admin/image_tool.php */