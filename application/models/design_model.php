<?php
class Design_model extends CI_Model {

	public function __construct() {
		$this->load->database();
	}

	public function getLayouts() {
		$this->db->from('layouts');
		
		$query = $this->db->get();
		
		$result = array();
	
		if ($query->num_rows() > 0) {
			$result = $query->result_array();
		}
	
		return $result;
	}

	public function getRoutes($status = 0) {
		$this->db->from('uri_routes');
		
		if ($status === 1) {
			$this->db->where('status', '1');
		}

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

	public function getLayoutRouteId($route = FALSE) {
		if ($route !== FALSE) {
			
			$this->db->from('uri_routes');
			$this->db->join('layout_routes', 'layout_routes.uri_route_id = uri_routes.uri_route_id', 'left');
			
			$this->db->where('route', $route);
			
			$query = $this->db->get();
			
			if ($query->num_rows() > 0) {
				$row = $query->row_array();
				return $row['layout_id'];	
			}
		}
		
		return FALSE;
	}
	
	public function updateRoutes($routes = array()) {
		if (!empty($routes)) {
			$this->db->truncate('uri_routes'); 

			foreach ($routes as $key => $route) {

				if (!empty($route['route']) && !empty($route['controller'])) {
					$this->db->set('route', $route['route']);
					$this->db->set('controller', $route['controller']);
					
					if ($route['status'] === '1') {
						$this->db->set('status', $route['status']);
					} else {
						$this->db->set('status', '0');
					}
					
					if (!empty($route['uri_route_id'])) {
						$this->db->set('uri_route_id', $route['uri_route_id']);
					}

					if (!empty($route['priority'])) {
						$this->db->set('priority', $route['priority']);
					}
					
					$this->db->insert('uri_routes'); 
				}
			}
					
			if ($this->db->affected_rows() > 0) {
				$this->writeRoutes();
				return TRUE;
			}
		}
	}

	public function writeRoutes() {
        $routes = $this->getRoutes(1);

        $data = array();

        if (!empty($routes )) {
			
			$filepath = APPPATH . 'config/routes.php'; 
			$data = '';   
		
			if ($fp = @fopen($filepath, FOPEN_READ_WRITE_CREATE_DESTRUCTIVE)) {

				$data .= "<"."?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');\n\n";
				
				$data .= "$"."route['default_controller'] = 'main/home';\n";
				$data .= "$"."route['admin'] = 'admin/dashboard';\n";

				foreach ($routes as $route) {
					$data .= "$"."route['". $route['route'] ."'] = '". $route['controller'] ."';\n";
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
	}
	
	public function updateLayout($update = array()) {

		$query = FALSE;
		if (!empty($update['name'])) {
			$this->db->set('name', $update['name']);
		}
		
		if (!empty($update['layout_id'])) {
			$this->db->where('layout_id', $update['layout_id']);
			$this->db->update('layouts');			
		}		

		if ($this->db->affected_rows() > 0) {
			$query = TRUE;
		}

		$this->db->where('layout_id', $update['layout_id']);
		$this->db->delete('layout_routes');

		if (is_array($update['routes'])) {
			foreach ($update['routes'] as $route) {
				$this->db->set('layout_id', $update['layout_id']);
				$this->db->set('uri_route_id', $route['uri_route_id']);
				$this->db->insert('layout_routes'); 
			}
		}

		if ($this->db->affected_rows() > 0) {
			$query = TRUE;
		}

		return $query;
	}

	public function addLayout($add = array()) {

		if (!empty($add['name'])) {
			$this->db->set('name', $add['name']);
		}
		
		$this->db->insert('layouts');			

		if ($this->db->affected_rows() > 0) {
			$layout_id = $this->db->insert_id();			

			$this->db->where('layout_id', $layout_id);
			$this->db->delete('layout_routes');

			if (is_array($add['routes'])) {
				foreach ($add['routes'] as $route) {
					$this->db->set('layout_id', $layout_id);
					$this->db->set('uri_route_id', $route['uri_route_id']);
					$this->db->insert('layout_routes'); 
				}
			}
		}

		if ($this->db->affected_rows() > 0) {
			return TRUE;
		}
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