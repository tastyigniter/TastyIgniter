<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Extensions_model extends TI_Model {

	public function getList($filter = array()) {
        $results = array();

        $extensions = $this->getExtensions();

        foreach ($this->fetchExtensionsPath() as $extension_path) {
            $options = $installed = FALSE;

            $basename = basename($extension_path);
            $title = ucwords(str_replace('_module', '', $basename));

            if (isset($extensions[$basename]) AND $extension = $extensions[$basename]) {
                if (isset($extension['status']) AND $extension['status'] === '1') {
                    $installed = TRUE;
                }
            }

            // skip loop if not installed and $is_installed is set TRUE
            if (!empty($filter['status']) AND $filter['status'] === TRUE AND $installed === FALSE) continue;

            $config_items = $this->getConfig($basename);

            $config = (!empty($config_items) AND is_array($config_items)) ? TRUE : FALSE;

            $ext_type = (isset($config_items['ext_type'])) ? $config_items['ext_type'] : 'module';

            if (isset($config_items['admin_options']) AND $config_items['admin_options'] === TRUE) {
                $options = file_exists($extension_path.'/controllers/admin_' . $basename . '.php') ? TRUE : FALSE;
            }

            $results[$ext_type][$basename] = array(
                'extension_id' => isset($extension['extension_id']) ? $extension['extension_id'] : 0,
                'name'         => $basename,
                'title'        => (!empty($extension['title'])) ? $extension['title'] : $title,
                'type'         => $ext_type,
                'ext_data'     => (isset($extension['data'])) ? $extension['data'] : '',
                'options'      => $options,
                'config'       => $config,
                'installed'    => $installed
            );
        }

        if (!empty($filter['type'])) {
            return $results[$filter['type']];
        }

        return $results;
    }

    public function getExtension($type = '', $name = '', $is_installed = TRUE) {
        $result = array();

        if (!empty($type) AND !empty($name)) {
            $extensions = $this->getList(array('type' => $type, 'status' => $is_installed));

            if ($extensions AND is_array($extensions)) {
                if (isset($extensions[$name]) AND is_array($extensions[$name])) {
                    $result = $extensions[$name];
                }
            }
        }

        return $result;
    }

    public function getExtensions($type = '', $filter_installed = FALSE) {

        $this->db->from('extensions');

        if ($type === '') {
            $this->db->where('type', 'module');
            $this->db->or_where('type', 'payment');
        } else {
            $this->db->where('type', $type);
        }

        if ($filter_installed === TRUE) {
            $this->db->where('status', '1');
        }

        $query = $this->db->get();

        $result = array();

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $name => $row) {
                if (preg_match('/\s/', $row['name']) > 0 OR !$this->extensionExists($row['name'])) {
                    $this->uninstall($row['type'], $row['name']);
                    continue;
                }

                $row['ext_data'] = ($row['serialized'] === '1' AND !empty($row['data'])) ? unserialize($row['data']) : array();
                unset($row['data']);
                $result[$row['name']] = $row;
            }
        }

        return $result;
	}

    private function fetchExtensionsPath() {
        $results = array();

        if ($modules_locations = $this->config->item('modules_locations')) {
            foreach ($modules_locations as $location => $offset) {
                foreach (glob($location . '*', GLOB_ONLYDIR) as $extension_path) {
                    if (is_file($extension_path.'/config/'.basename($extension_path).'.php')) {
                        $results[] = $extension_path;
                    }
                }
            }

        }

        return $results;
	}

    public function getModules() {
        return $this->getExtensions('module', TRUE);
    }

    public function getPayments() {
        return $this->getExtensions('payment', TRUE);
    }

	public function getPayment($name = '') {
        $result = array();

        if (!empty($name) AND is_string($name)) {
            $extensions = $this->getExtensions('payment', TRUE);

            if ($extensions AND is_array($extensions)) {
                if (isset($extensions[$name]) AND is_array($extensions[$name])) {
                    $result = $extensions[$name];
                }
            }
        }

        return $result;
	}

    public function getConfig($ext_name = '', $item = '', $fail_gracefully = TRUE) {
        $this->config->load($ext_name.'/'.$ext_name, TRUE, $fail_gracefully);

		if ($config = $this->config->item($ext_name)) {
			if ($item !== '') {
				return $config[$item];
			}
		}

        return $config;
	}

    public function updateExtension($update = array(), $serialized = '0') {
		$query = FALSE;

        if (!empty($update['type']) AND !empty($update['name'])) {

            $update['name'] = url_title(strtolower($update['name']), '-');

            if ($this->extensionExists($update['name'])) {

                if (empty($update['extension_id'])) {
                    $update['extension_id'] = $this->install($update['type'], $update['name']);
                }

                if (isset($update['data']) AND $serialized === '1') {
                    $this->db->set('data', serialize($update['data']));
                } else if (!empty( $update['data'])) {
                    $this->db->set('data', $update['data']);
                }

                $this->db->set('serialized', $serialized);

                if (!empty($update['title'])) {
                    $this->db->set('title', $update['title']);
                }

                $this->db->where('type', $update['type']);
                $this->db->where('name', $update['name']);

                if (!empty($update['extension_id'])) {
                    $this->db->where('extension_id', $update['extension_id']);
                    $query = $this->db->update('extensions');

                    $this->load->model('Notifications_model');
                    $this->Notifications_model->addNotification(array('action' => 'updated', 'object' => 'extension', 'object_id' => $update['extension_id']));
                }
            }
		}

		return $query;
	}

    public function upload($type = '', $file = array()) {
        if ($type === 'module' AND isset($file['tmp_name']) AND class_exists('ZipArchive')) {
            $rename_dir = '__0';
            $upload_path = ROOTPATH . EXTPATH;

            $zip = new ZipArchive;

            $file_path = $file['tmp_name'];
            chmod($file_path, 0777);

            if ($zip->open($file_path) === TRUE) {
                $i = 0;

                while ($info = $zip->statIndex($i)) {
                    if ($i === 0 AND preg_match('/\s/', $info['name'])) $rename_dir = $info['name'];

                    $file_path = $upload_path . $info['name'];
                    if (file_exists($file_path) OR ($rename_dir !== '__0' AND file_exists($upload_path . $rename_dir))) return FALSE;
                    $i++;
                }

                $zip->extractTo($upload_path);
                $zip->close();

                if ($rename_dir !== '__0' AND is_dir($upload_path . $rename_dir)) {
                    $new_name = str_replace(' ', '-', $rename_dir);

                    if (is_dir($upload_path . $new_name)) {
                        $this->load->helper('file');
                        delete_files($upload_path . $rename_dir, TRUE);
                        rmdir($upload_path . $rename_dir);
                        return FALSE;
                    }

                    rename($upload_path . $rename_dir, $upload_path. $new_name);
                }

                return TRUE;
            }
        }

        return FALSE;
    }

    public function install($type = '', $name = '', $extension_id = '0') {

		if (!empty($type) AND !empty($name)) {
            $name = url_title(strtolower($name), '-');

            if ($this->extensionExists($name)) {
                if ($extension_id !== '0' AND is_numeric($extension_id)) {
                    $this->db->set('status', '1');
                    $this->db->where('type', $type);
                    $this->db->where('name', $name);
                    $this->db->where('extension_id', $extension_id);
                    $this->db->update('extensions');
                } else {
                    $this->db->set('status', '1');
                    $this->db->set('type', $type);
                    $this->db->set('name', $name);
                    if ($this->db->insert('extensions')) $extension_id = $this->db->insert_id();
                }

                if ($extension_id AND is_numeric($extension_id)) {
                    $this->load->model('Notifications_model');
                    $this->Notifications_model->addNotification(array('action' => 'installed', 'object' => 'extension', 'object_id' => $name));
                }

                return $extension_id;
            }
        }


        return FALSE;
	}

    public function uninstall($type = '', $name = '', $extension_id = '0') {
        $query = FALSE;

        if (!empty($type) AND $this->extensionExists($name)) {

            $this->db->set('status', '0');
            $this->db->where('type', $type);
            $this->db->where('name', $name);

            if ($extension_id !== '0' AND is_numeric($extension_id)) {
                $this->db->where('extension_id', $extension_id);
            }

            if (preg_match('/\s/', $name) > 0) {
                $query = $this->delete($name);
            } else {
                $this->db->update('extensions');
                if ($this->db->affected_rows() > 0) {
                    $this->load->model('Notifications_model');
                    $this->Notifications_model->addNotification(array('action' => 'uninstalled', 'object' => 'extension', 'object_id' => $name));
                    $query = TRUE;
                }
            }
        }

        return $query;
    }

    public function delete($type = '', $name = '', $extension_id = '0') {
        $query = FALSE;

        if (!empty($type) AND $this->extensionExists($name)) {

            $this->db->where('status', '0');
            $this->db->where('type', $type);
            $this->db->where('name', $name);

            if ($extension_id !== '0' AND is_numeric($extension_id)) {
                $this->db->where('extension_id', $extension_id);
            }

            $this->db->delete('extensions');
            if ($this->db->affected_rows() > 0) {
                $query = TRUE;
            }

            $query = $this->db->where('status', '1')->where('type', $type)->where('name', $name)->get('extensions');
            if ($query->num_rows() <= 0) {
                $this->load->helper('file');
                delete_files(ROOTPATH . EXTPATH . $name, TRUE);
                rmdir(ROOTPATH . EXTPATH . $name);

                $query = TRUE;
                $this->load->model('Notifications_model');
                $this->Notifications_model->addNotification(array('action' => 'deleted', 'object' => 'extension', 'object_id' => $name));
            }
        }

        return $query;
    }

    public function extensionExists($extension_name) {
        $extension_path = ROOTPATH . EXTPATH .$extension_name;

        if (!empty($extension_name) AND file_exists($extension_path)) {
            return TRUE;
        }

        return FALSE;
    }
}

/* End of file extensions_model.php */
/* Location: ./system/tastyigniter/models/extensions_model.php */