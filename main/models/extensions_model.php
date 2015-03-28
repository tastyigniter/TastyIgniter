<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Extensions_model extends CI_Model {
	private $extensions = array();
	private $layouts = NULL;
	private $modules = array();
	private $payments = array();

	public function getList($type = '') {
		$this->db->from('extensions');

		if (!empty($type)) {
			$this->db->where('type', $type);
		}

		$query = $this->db->get();

		$results = array();

		if ($query->num_rows() > 0) {
			$results = $query->result_array();
		}

		return $results;
	}

	public function getExtensions() {
		if (empty($this->extensions)) {
			$this->db->from('extensions');
			$this->db->where('status', '1');

			$query = $this->db->get();

			$results = array();

			if ($query->num_rows() > 0) {
				foreach ($query->result_array() as $row) {
					$installed = FALSE;

					if (!empty($row['data']) AND $row['serialized'] === '1') {
						$ext_data = unserialize($row['data']);
					} else {
						$ext_data = $row['data'];
					}

					$title = (!empty($row['title'])) ? $row['title'] : ucwords(str_replace('_module', '', $row['name']));

					$results[$row['type']][$row['name']] = array(
						'extension_id' 		=> $row['extension_id'],
						'name' 				=> $row['name'],
						'title'				=> $title,
						'type'				=> $row['type'],
						'ext_data'			=> $ext_data,
						'status'			=> $row['status']
					);
				}

				$this->extensions = $results;
			}
		}

		return $this->extensions;
	}

	public function getModules() {
		$this->getExtensions();
		if (!empty($this->extensions['module']) AND is_array($this->extensions['module'])) {
			foreach ($this->extensions['module'] as $module) {
				$this->modules[$module['name']] = $module;
			}
		}

		return $this->modules;
	}

	/*public function getModules() {
		$this->db->from('extensions');
		$this->db->where('type', 'module');

		$query = $this->db->get();

		$results = array();

		if ($query->num_rows() > 0) {
			$results = $query->result_array();
		}

		return $results;

		if (isset($this->layouts[$position]) AND count($this->layouts[$position]) > 0 AND is_array($this->layouts[$position])) {
			$layouts = array();

			foreach ($this->layouts[$position] as $key => $layout) {
				$layouts[$key] = $layout['priority'];
			}

			array_multisort($layouts, SORT_ASC, $this->layouts[$position]);
			return $this->layouts[$position];
		}
	}*/

	public function getLayouts() {
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

	public function getExtension($type = '', $name = '') {
		$result = array();

		if (!empty($type) AND !empty($name)) {
			$this->db->from('extensions');
			$this->db->where('type', $type);
			$this->db->where('name', $name);

			$query = $this->db->get();

			if ($query->num_rows() > 0) {
				$result = $query->row_array();
			}
		}

		return $result;
	}

	public function getModuleData($name = '') {
		$result = array();

		foreach ($this->getModules() as $module) {
			if ($module['name'] === $name) {
				if (!empty($module['ext_data'])) {
					$result = $module['ext_data'];
				}
			}
		}

		return $result;
	}

	public function getPayment($name = '') {
		$result = array();

		if (!empty($name)) {
			$this->db->from('extensions');
			$this->db->where('name', $name);
			$this->db->where('type', 'payment');

			$query = $this->db->get();

			if ($query->num_rows() > 0) {
				$row = $query->row_array();
				$row['data'] = unserialize($row['data']);
				$result = $row;
			}
		}

		return $result;
	}

	public function getPayPalPayment() {
		$result = array();

		$this->db->from('extensions');
		$this->db->where('name', 'paypal_express');
		$this->db->where('type', 'payment');

		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			$row = $query->row_array();

			$payment_data = unserialize($row['data']);

			$result = array(
				'name'			=> $row['name'],
				'title'			=> $row['title'],
				'priority'		=> $payment_data['priority'],
				'status'		=> $payment_data['status'],
				'api_mode'		=> $payment_data['api_mode'],
				'api_user'		=> $payment_data['api_user'],
				'api_pass'		=> $payment_data['api_pass'],
				'api_signature'	=> $payment_data['api_signature'],
				'api_action'	=> $payment_data['api_action'],
				'return_uri'	=> $payment_data['return_uri'],
				'cancel_uri'	=> $payment_data['cancel_uri'],
				'order_total'	=> $payment_data['order_total'],
				'order_status'	=> $payment_data['order_status'],
			);
		}

		return $result;
	}

	public function getModulesByPosition($position = '', $segments = array()) {
		$modules = FALSE;
		$layouts = $this->getCurrentLayouts($segments);

		foreach ($this->getModules() as $module) {
			if (!empty($module['ext_data'])) {
				$ext_data = $module['ext_data'];

				if (!empty($ext_data['layouts'])) {
					$ext_layouts = $ext_data['layouts'];
					unset($ext_data['layouts']);

					foreach ($ext_layouts as $layout) {
						if ($position === $layout['position']) {
							if (in_array($layout['layout_id'], $layouts) AND $layout['status'] === '1') {

								$modules[] = array(
									'name'			=> $module['name'],
									'title'			=> $module['title'],
									'layout_id'		=> $layout['layout_id'],
									'position'		=> $layout['position'],
									'priority'		=> $layout['priority'],
									'ext_data'		=> $ext_data,
								);
							}
						}
					}
				}
			}
		}

		return $modules;
	}

	public function getCurrentLayouts($segments = array()) {
		$uri_route = '';
		$layouts = array();

		if ($this->layouts === NULL OR empty($this->layouts)) {
			if (!empty($segments) AND is_array($segments)) {
				foreach ($segments as $segment) {

					if ($uri_route === '') {
						$uri_route = $segment;
					} else {
						$uri_route .= '/'.$segment;
					}

					if ($segment === 'pages') {
						$layouts = $this->getPageLayouts((int)$this->input->get('page_id'));
					} else {
						$layouts = $this->getRouteLayouts(rtrim($uri_route, '/'));
					}

					if (!empty($layouts)) {
						break;
					}
				}
			} else {
				$layouts = $this->getRouteLayouts('home');
			}

			if (empty($layouts)) {
				$layouts = array('0');
			}

			$this->layouts = $layouts;
		}

		return $this->layouts;
	}

	public function getRouteLayouts($uri_route = '') {
		$result = array();

		if ($uri_route !== '') {
			$this->db->from('layout_routes');
			$this->db->where('uri_route', $uri_route);

			$query = $this->db->get();

			if ($query->num_rows() > 0) {
				foreach ($query->result_array() as $row) {
					$result[] = $row['layout_id'];
				}
			}
		}

		return $result;
	}

	public function getPageLayouts($page_id = '') {
		$result = array();

		if ($page_id !== '') {
			$this->db->from('pages');
			$this->db->where('page_id', $page_id);

			$query = $this->db->get();

			if ($query->num_rows() > 0) {
				$row = $query->row_array();
				$result[] = $row['layout_id'];
			}
		}

		return $result;
	}
}

/* End of file extensions_model.php */
/* Location: ./main/models/extensions_model.php */