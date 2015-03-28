<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Extensions_model extends CI_Model {

    private $extensions = array();
    private $db_extensions = array();
    private $loaded_config = array();

	public function getList($type = '') {
		$extensions = array();

		if (!defined(EXTPATH) AND !is_dir(ROOTPATH.EXTPATH)) {
			return FALSE;
		}

		$db_extensions = empty($this->db_extensions) ? $this->getExtensions() : $this->db_extensions;

		foreach (glob(ROOTPATH . EXTPATH.'*', GLOB_ONLYDIR) as $ext_path) {
			$extension_id = 0;
			$ext_type = $ext_data = '';
			$options = $config = $installed = FALSE;

			$basename = basename($ext_path);
			$title = ucwords(str_replace('_module', '', $basename));

			$config_items = $this->getConfig($basename);

			if ($config_items AND is_array($config_items)) {
				$config = TRUE;

				if (isset($config_items['ext_type'])) {
					$ext_type = $config_items['ext_type'];
				}

				if (isset($config_items['admin_options'])) {
					$options = $config_items['admin_options'];
				}
			}

			if (isset($db_extensions[$basename]) AND $db_extension = $db_extensions[$basename]) {
				$ext_data = $db_extension['data'];

				$title = (!empty($db_extension['title'])) ? $db_extension['title'] : $title;

				if (isset($db_extension['status']) AND $db_extension['status'] === '1') {
					$installed = TRUE;
				}

				$extension_id = $db_extension['extension_id'];
			}

			$extensions[$ext_type][$basename] = array(
				'extension_id' 		=> $extension_id,
				'name' 				=> $basename,
				'title'				=> $title,
				'type'				=> $ext_type,
				'ext_data'			=> $ext_data,
				'options'			=> $options,
				'config'			=> $config,
				'installed' 		=> $installed
			);
		}

		if ($type !== '' AND isset($extensions[$type])) {
			return $extensions[$type];
		} else {
			return $extensions;
		}
	}

	public function getExtensions() {
		$this->db->from('extensions');
        $query = $this->db->get();


        $result = array();

		if ($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				$row['data'] = ($row['serialized'] === '1' AND !empty($row['data'])) ? unserialize($row['data']) : array();
				$result[$row['name']] = $row;
			}

			$this->db_extensions = $result;
		}

		return $result;
	}

	public function getExtension($type = '', $name = '') {
		$result = array();

		if (!empty($type) AND !empty($name)) {
			$extensions = $this->getList($type);

			if ($extensions AND is_array($extensions)) {
				if (isset($extensions[$name]) AND is_array($extensions[$name])) {
					$result = $extensions[$name];
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

				$result = array(
					'name'		=> $row['name'],
					'data'		=> unserialize($row['data'])
				);
			}
		}

		return $result;
	}

	public function getConfig($ext_name = '', $item = '') {
		$loaded = $installed = FALSE;

		$config_path = EXTPATH.$ext_name.'/config/config.php';

		if ( ! file_exists(ROOTPATH . $config_path)) {
			$this->alert->warning_now('The Extension ['.$ext_name.'] Config file '.$config_path.' does not exist.');
			return FALSE;
		}

		if (array_key_exists($config_path, $this->loaded_config)) {
			$loaded = TRUE;
			log_message('debug', 'Extension ['.$ext_name.'] Config file has already been loaded. Second attempt aborted.');
		}

		if ($loaded === FALSE) {
			include(ROOTPATH . $config_path);

			if ( ! isset($config) OR ! is_array($config)) {
				$this->alert->warning_now('Extension ['.$config_path.'] Config file does not appear to contain a valid array.');
				return FALSE;
			}

			$this->loaded_config[$config_path] = $config;
			unset($config);
			$loaded = TRUE;
			log_message('debug', 'Extension ['.$ext_name.'] Config file loaded: '.$config_path);
		}

		if ($loaded === TRUE) {
			if ($item !== '') {
				return $this->loaded_config[$config_path][$item];
			}

			return $this->loaded_config[$config_path];
		}

		return FALSE;
	}

	public function updateExtension($update = array(), $serialized = '0') {
		$query = FALSE;

        if (!empty($update['type']) AND !empty($update['name'])
			AND !empty($update['data'])) {

            if (empty($update['extension_id']))
            {
                $update['extension_id'] = $this->install($update['type'], $update['name']);
            }

			if (is_array($update['data']) AND $serialized === '1') {
				$data = serialize($update['data']);
			} else {
				$data = $update['data'];
			}

			$this->db->set('data', $data);
			$this->db->set('serialized', $serialized);

			if (isset($update['title'])) {
				$this->db->set('title', $update['title']);
			}

			$this->db->where('type', $update['type']);
			$this->db->where('name', $update['name']);

			if (!empty($update['extension_id'])) {
				$this->db->where('extension_id', $update['extension_id']);
				$query = $this->db->update('extensions');

				$this->load->model('Notifications_model');
				$this->Notifications_model->addNotification(array('action' => 'updated', 'object' => 'extension', 'object_id' => $update['extension_id'], 'actor_id' => $this->user->getStaffId()));
            }
		}

		return $query;
	}


	public function findExtension($extension_name = '') {
		$extension_path = ROOTPATH . EXTPATH .$extension_name.'/controllers/'.$extension_name.'.php';

		if (file_exists($extension_path)) {
			return TRUE;
		}

		return FALSE;
	}

	public function install($type = '', $name = '', $extension_id = FALSE) {

		if (!empty($type) AND !empty($name)) {
			$extension = $this->getExtension($type, $name);

			if (!empty($extension) AND $extension['extension_id'] !== 0) {
                $this->db->set('status', '1');
                $this->db->where('type', $type);
                $this->db->where('name', $name);
				$this->db->where('extension_id', $extension['extension_id']);

				if ($this->db->update('extensions')) {
					$extension_id = $extension['extension_id'];
				}

			} else {
                $this->db->set('type', $type);
                $this->db->set('name', $name);
                $this->db->set('status', '1');

                if ($this->db->insert('extensions')) {
					$extension_id = $this->db->insert_id();
				}
			}
		}

		if ($extension_id AND is_numeric($extension_id)) {
			$this->load->model('Notifications_model');
			$this->Notifications_model->addNotification(array('action' => 'installed', 'object' => 'extension', 'object_id' => $extension_id, 'actor_id' => $this->user->getStaffId()));

			$this->load->model('Staff_groups_model');
    		$this->Staff_groups_model->addPermission($this->user->getStaffGroupId(), 'access', $name);
    		$this->Staff_groups_model->addPermission($this->user->getStaffGroupId(), 'modify', $name);

    		return $extension_id;
		}

		return FALSE;
	}

	public function uninstall($type = '', $name = '') {
		if (!empty($type) AND !empty($name)) {
			$extension = $this->getExtension($type, $name);

			$this->db->set('status', '0');
			$this->db->where('type', $type);
			$this->db->where('name', $name);

			if ($this->db->update('extensions')) {
				$this->load->model('Notifications_model');
				$this->Notifications_model->addNotification(array('action' => 'uninstalled', 'object' => 'extension', 'object_id' => $extension['extension_id'], 'actor_id' => $this->user->getStaffId()));
				return TRUE;
			}

			return FALSE;
		}
	}
}

/* End of file extensions_model.php */
/* Location: ./admin/models/extensions_model.php */