<?php

class Design_model extends CI_Model {

	public function getLayouts() {
		$this->db->from('layouts');
		
		$query = $this->db->get();
		
		$result = array();
	
		if ($query->num_rows() > 0) {
			$result = $query->result_array();
		}
	
		return $result;
	}

	public function getRoutes() {
		$this->db->from('uri_routes');
		
		$this->db->order_by('priority', 'ASC');
		
		$query = $this->db->get();
		$result = array();
	
		if ($query->num_rows() > 0) {
			$result = $query->result_array();
		}
	
		return $result;
	}
	
	public function getLayout($layout_id) {
		$this->db->from('layouts');

		$this->db->where('layout_id', $layout_id);

		$query = $this->db->get();
		
		if ($query->num_rows() > 0) {
			return $query->row_array();
		}
	}

	public function getLayoutRoutes($layout_id) {
		$this->db->from('layout_routes');

		$this->db->where('layout_id', $layout_id);

		$query = $this->db->get();
		
		$result = array();
	
		if ($query->num_rows() > 0) {
			$result = $query->result_array();
		}
	
		return $result;
	}

	public function getRouteLayoutId($uri_route = '') {
		$result = array();
		
		if ($uri_route !== '') {
			$route = explode('/', $uri_route);
			$this->db->from('layout_routes');
			$this->db->where('uri_route', $route[0]);
			
			if (isset($route[1])) {
				$this->db->or_where('uri_route', $route[0] .'/'. $route[1]);
			}
		
			$query = $this->db->get();
			
			if ($query->num_rows() > 0) {
				foreach ($query->result_array() as $row) {
					$result[] = $row['layout_id'];
				}
			}
		}

		return $result;	
	}
	
	public function getPageLayoutId($page_id = '') {
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
	
	public function updateRoutes($routes = array()) {
		if (!empty($routes)) {
			$this->db->truncate('uri_routes'); 
			$priority = 1;
			
			foreach ($routes as $key => $value) {

				if (!empty($value['uri_route']) && !empty($value['controller'])) {
					$this->db->set('uri_route', $value['uri_route']);
					$this->db->set('controller', $value['controller']);
					$this->db->set('priority', $priority);
					
					$this->db->insert('uri_routes'); 
					$priority++;
				}
			}
					
			if ($this->db->affected_rows() > 0) {
				$this->writeRoutes();
				return TRUE;
			}
		}
	}

	public function writeRoutes() {
		$status = 1;
        $routes = $this->getRoutes($status);

        $data = array();
			
		$filepath = APPPATH . 'config/routes.php'; 
		$data = '';   
	
		if ($fp = @fopen($filepath, FOPEN_READ_WRITE_CREATE_DESTRUCTIVE)) {

			$data .= "<"."?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');\n\n";
			
			$data .= "$"."route['default_controller'] = 'main/home';\n";
			$data .= "$"."route['admin'] = 'admin/dashboard';\n";
			$data .= "$"."route['maintenance'] = 'main/maintenance';\n";

	        if (!empty($routes ) && is_array($routes)) {
				foreach ($routes as $route) {
					$data .= "$"."route['". $route['uri_route'] ."'] = '". $route['controller'] ."';\n";
				}
        	}
		
			$data .= "$"."route['404_override'] = '';\n\n";
			
			$data .= "/* End of file routes.php */\n";
			$data .= "/* Location: ./application/config/routes.php */";			

			flock($fp, LOCK_EX);
			fwrite($fp, $data);
			flock($fp, LOCK_UN);
			fclose($fp);

			@chmod($filepath, FILE_WRITE_MODE);
		}
	}
	
	public function updateLayout($update = array()) {
		$query = FALSE;

		if (!empty($update['name'])) {
			$this->db->set('name', $update['name']);
		}
		
		if (!empty($update['layout_id'])) {
			$this->db->where('layout_id', $update['layout_id']);
			$query = $this->db->update('layouts');			
		}		

		$this->db->where('layout_id', $update['layout_id']);
		$this->db->delete('layout_routes');

		if (is_array($update['routes'])) {
			foreach ($update['routes'] as $route) {
				$this->db->set('layout_id', $update['layout_id']);
				$this->db->set('uri_route', $route['uri_route']);
				$query = $this->db->insert('layout_routes'); 
			}
		}

		return $query;
	}

	public function addLayout($add = array()) {
		$query = FALSE;

		if (!empty($add['name'])) {
			$this->db->set('name', $add['name']);
		}

		if ($this->db->insert('layouts')) {			
			$layout_id = $this->db->insert_id();			

			$this->db->where('layout_id', $layout_id);
			$this->db->delete('layout_routes');

			if (is_array($add['routes'])) {
				foreach ($add['routes'] as $route) {
					$this->db->set('layout_id', $layout_id);
					$this->db->set('uri_route', $route['uri_route']);
					$query = $this->db->insert('layout_routes'); 
				}
			}

			$query = $layout_id;			
		}

		return $query;
	}

	public function deleteLayout($layout_id) {
		$this->db->where('layout_id', $layout_id);
		$this->db->delete('layouts');

		$this->db->where('layout_id', $layout_id);
		$this->db->delete('layout_routes');

		if ($this->db->affected_rows() > 0) {
			return TRUE;
		}
	}
}

/* End of file design_model.php */
/* Location: ./application/models/design_model.php */