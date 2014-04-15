<?php
class Image_tool extends CI_Controller {

	public function __construct() {
		parent::__construct(); //  calls the constructor
		$this->load->library('user');
	}

	public function index() {
			
		if (!file_exists(APPPATH .'views/admin/image_tool.php')) {
			show_404();
		}
			
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

		$data['heading'] 			= 'Image Tool';
		$data['sub_menu_save'] 		= 'Save';
		
		$result = $this->config->item('image_tool');
		
		$data['root_folder'] 		= (isset($result['root_folder'])) ? $result['root_folder'] : '';
		$data['max_size'] 			= (isset($result['max_size'])) ? $result['max_size'] : '';
		$data['thumb_height'] 		= (isset($result['thumb_height'])) ? $result['thumb_height'] : '';
		$data['thumb_width'] 		= (isset($result['thumb_width'])) ? $result['thumb_width'] : '';
		$data['thumb_height_mini'] 	= (isset($result['thumb_height_mini'])) ? $result['thumb_height_mini'] : '';
		$data['thumb_width_mini'] 	= (isset($result['thumb_width_mini'])) ? $result['thumb_width_mini'] : '';
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

		if ($this->input->post() && $this->_updateImageTool() === TRUE) {
			redirect('admin/image_tool');
		}

		$regions = array(
			'admin/header',
			'admin/footer'
		);
		
		$this->template->regions($regions);
		$this->template->load('admin/image_tool', $data);
	}

	public function _updateImageTool() {
    	if (!$this->user->hasPermissions('modify', 'admin/image_tool')) {
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have the right permission to edit!</p>');
			return TRUE;
    	} else if ($this->validateForm() === TRUE) { 
			$update['image_tool'] = array(
				'root_folder' 		=> $this->input->post('root_folder'),
				'max_size' 			=> $this->input->post('max_size'),
				'thumb_height' 		=> $this->input->post('thumb_height'),
				'thumb_width' 		=> $this->input->post('thumb_width'),
				'thumb_height_mini' => $this->input->post('thumb_height_mini'),
				'thumb_width_mini' 	=> $this->input->post('thumb_width_mini'),
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

			if ($this->Settings_model->updateSettings('image_tool', $update)) {
				$this->session->set_flashdata('alert', '<p class="success">Image Tool Updated Sucessfully!</p>');
			} else {
				$this->session->set_flashdata('alert', '<p class="warning">Nothing Updated!</p>');
			}

			return TRUE;
		}
	}

	public function validateForm() {
		$this->form_validation->set_rules('root_folder', 'Root Folder', 'trim|required|alpha_numeric');
		$this->form_validation->set_rules('max_size', 'Maximum File Size', 'trim|required|numeric');
		$this->form_validation->set_rules('thumb_height', 'Thumbnail Height', 'trim|required|numeric');
		$this->form_validation->set_rules('thumb_width', 'Thumbnail Width', 'trim|required|numeric');
		$this->form_validation->set_rules('thumb_height_mini', 'Mini Thumbnail Height', 'trim|required|numeric');
		$this->form_validation->set_rules('thumb_width_mini', 'Mini Thumbnail Width', 'trim|required|numeric');
		$this->form_validation->set_rules('show_ext', 'Show Extension', 'trim|required|integer');
		$this->form_validation->set_rules('uploads', 'Uploads', 'trim|integer');
		$this->form_validation->set_rules('new_folder', 'New Folder', 'trim|integer');
		$this->form_validation->set_rules('copy', 'Copy', 'trim|integer');
		$this->form_validation->set_rules('move', 'Move', 'trim|integer');
		$this->form_validation->set_rules('rename', 'Rename', 'trim|integer');
		$this->form_validation->set_rules('delete', 'Delete', 'trim|integer');
		$this->form_validation->set_rules('allowed_ext', 'Allowed Extension', 'trim|required');
		$this->form_validation->set_rules('hidden_files', 'Hidden Files', 'trim|');
		$this->form_validation->set_rules('hidden_folders', 'Hidden Folders', 'trim|');
		$this->form_validation->set_rules('transliteration', 'Transliteration', 'trim|integer');
		$this->form_validation->set_rules('remember_days', 'Remember Last Folder', 'trim|integer');

		if ($this->form_validation->run() == TRUE) {
			return TRUE;
		} else {
			return FALSE;
		}

	}
}