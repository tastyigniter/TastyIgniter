<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Extension {
	private $uri_route;
	private $layout_id;
	private $layouts = array();
	private $modules = array();
	
	public function __construct() {
		$this->CI =& get_instance();

		$this->CI->load->model('Extensions_model');
		$this->CI->load->model('Design_model');
		
		$this->initialize();
	}
	
	public function initialize() {
		$this->setLayoutId();
		$this->setModules();
		$this->setLayouts();
	}
	
	public function setLayoutId() {
		$uri_route = 'home';
		if ($this->CI->uri->segment(1)) {
			$uri_route = $this->CI->uri->segment(1);
		}
	
		if ($this->CI->uri->segment(2)) {
			$uri_route = $this->CI->uri->segment(1) .'/'. $this->CI->uri->segment(2);
		}

		if (empty($this->layout_id)) {
			$this->layout_id = $this->CI->Design_model->getRouteLayoutId($uri_route);
		
			if ($this->CI->uri->segment(1) === 'pages') {
				$this->layout_id = $this->CI->Design_model->getPageLayoutId((int)$this->CI->input->get('page_id'));
			}
		}
	}
	
	public function getModules($position = '') {
		if (isset($this->layouts[$position]) AND count($this->layouts[$position]) > 0 AND is_array($this->layouts[$position])) {
			$layouts = array();
	
			foreach ($this->layouts[$position] as $key => $layout) {	
				$layouts[$key] = $layout['priority'];
			}
	
			array_multisort($layouts, SORT_ASC, $this->layouts[$position]);
			return $this->layouts[$position];
		}
	}

	public function setModules() {
		if (empty($this->modules)) {
			$results = $this->CI->Extensions_model->getModules();	

			$modules = array();
			foreach ($results as $result) {
				$module_name = $result['name'];
				if (file_exists(EXTPATH .'modules/'.$module_name.'/controllers/main/'.$module_name.'.php')) {
					$data = (!empty($result['data'])) ? unserialize($result['data']) : array();
					$modules[$module_name] = array(
						'layouts'	=> $data['layouts']
					);
				}
			}

			$this->modules = $modules;
		}
	}
	
	public function setLayouts() {
		if (!empty($this->modules)) {
			$layouts = array();
			foreach ($this->modules as $name => $modules) {
				foreach ($modules['layouts'] as $layout) {
					if (in_array($layout['layout_id'], $this->layout_id) AND $layout['status'] === '1') {
						$layouts[$layout['position']][] = array(
							'name' 		=> $name,
							'setting' 	=> $layout,
							'priority' 	=> $layout['priority']
						);
					}
				}
			}
			
			$this->layouts = $layouts;
		}
	}
}

// END Extension Class

/* End of file Extension.php */
/* Location: ./application/libraries/Extension.php */