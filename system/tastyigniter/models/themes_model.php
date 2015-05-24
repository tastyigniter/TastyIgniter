<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Themes_model extends TI_Model {

    private $_allowed_image_ext = array('jpg', 'jpeg', 'png', 'gif', 'bmp', 'tiff', 'svg');
    private $_allowed_file_ext = array('html', 'txt', 'xml', 'js', 'php', 'css');
    private $_hidden_files = array();
    private $_hidden_folders = array();

    private $themes = array();
    private $themes_folder = array();
    private $loaded_config = array();
    private $themes_list = array();

    public function getList() {
        $this->getThemes();
        $this->getThemesFolder();

        if (empty($this->themes_list) AND !empty($this->themes_folder)) {
            foreach ($this->themes_folder as $theme) {
                $db_theme = (isset($this->themes[$theme['basename']]) AND !empty($this->themes[$theme['basename']])) ? $this->themes[$theme['basename']] : array();

                $extension_id 		= (!empty($db_theme['extension_id'])) ? $db_theme['extension_id'] : 0;
                $theme_name 		= (!empty($db_theme['name'])) ? $db_theme['name'] : $theme['basename'];

                $this->themes_list[$theme['basename']] = array(
                    'extension_id'	=> $extension_id,
                    'name'			=> $theme_name,
                    'title'	        => isset($theme['config']['title']) ? $theme['config']['title'] : $theme_name,
                    'description'	=> isset($theme['config']['description']) ? $theme['config']['description'] : '',
                    'location'		=> $theme['location'],
                    'thumbnail'		=> root_url($theme['path'] .'/images/theme_thumb.png'),
                    'preview'		=> root_url($theme['path'] .'/images/theme_preview.png'),
                    'path'			=> ROOTPATH . $theme['path'],
                    'is_writable'	=> is_writable(ROOTPATH . $theme['path']),
                    'config'		=> $theme['config'],
                    'data'	        => !empty($db_theme['data']) ? $db_theme['data'] : array(),
                    'customize'	    => (isset($theme['config']['customize']) AND !empty($theme['config']['customize'])) ? TRUE : FALSE
                );
            }
        }

        return $this->themes_list;
    }

    public function getThemes() {
        if (empty($this->themes)) {
            $this->db->from('extensions');
            $this->db->where('type', 'theme');
            $query = $this->db->get();

            if ($query->num_rows() > 0) {
                foreach ($query->result_array() as $row) {
                    $row['data'] = ($row['serialized'] === '1' AND !empty($row['data'])) ? unserialize($row['data']) : array();
                    $this->themes[$row['name']] = $row;
                }
            }
        }

        return $this->themes;
    }

    public function getTheme($name = '') {
        $result = array();
        $this->getList();

        if (!empty($name) AND !empty($this->themes_list) AND is_array($this->themes_list)) {
            if (isset($this->themes_list[$name]) AND is_array($this->themes_list[$name])) {
                $result = $this->themes_list[$name];
            }
        }

        return $result;
    }

    public function getThemeFiles($directory = '') {
        $theme_files = array();

        if (!empty($directory)) {
            foreach (glob(ROOTPATH .$directory .'*') as $file) {
                $file_name = basename($file);
                $file_ext = strtolower(substr(strrchr($file, '.'), 1));

                $type = 'file';
                if (is_dir($file) AND !in_array($file_name, $this->_hidden_folders)) {
                    $type = 'dir';
                } else if (!in_array($file, $this->_hidden_files)) {
                    if (in_array($file_ext, $this->_allowed_image_ext)) {
                        $type = 'img';
                    } else if (in_array($file_ext, $this->_allowed_file_ext)) {
                        $type = 'file';
                    }
                }

                $theme_files[] = array('type' => $type, 'name' => $file_name, 'path' => $file, 'ext' => $file_ext);
            }

            $type = array();
            foreach ($theme_files as $key => $value) {
                $type[$key] = $value['type'];
            }
            array_multisort($type, SORT_ASC, $theme_files);
        }

        return $theme_files;
    }

    public function getThemesFolder() {
        $themes_root = array(
            MAINDIR     => ROOTPATH . MAINDIR . '/views/themes',
            ADMINDIR    => ROOTPATH . ADMINDIR . '/views/themes',
        );

        foreach ($themes_root as $key => $value) {
            if (is_dir($value)) {
                foreach (glob($value . '/*', GLOB_ONLYDIR) as $theme_path) {
                    $theme_name = basename($theme_path);
                    $theme_path = $key.'/views/themes/'.$theme_name;

                    $this->themes_folder[] = array(
                        'location'  => $key,
                        'basename'  => $theme_name,
                        'path'      => $theme_path,
                        'config'    => $this->getConfig($theme_path)
                    );
                }
            }
        }

        return $this->themes_folder;
    }

    public function readFile($name, $location, $file) {
        $result = array();

        if (empty($name) AND empty($location) AND empty($file)) return FALSE;

        $theme_file_path = $location . '/views/themes/'. $name . $file;
        if (is_file(ROOTPATH . $theme_file_path)) {
            $file_name = basename($theme_file_path);
            $file_ext = strtolower(substr(strrchr($theme_file_path, '.'), 1));
            $type = $content = '';

            if (in_array($file_ext, $this->_allowed_image_ext)) {
                $type = 'img';
                $content = root_url($theme_file_path);
            } else if (in_array($file_ext, $this->_allowed_file_ext)) {
                $type = 'file';
                $content = htmlspecialchars(file_get_contents(ROOTPATH . $theme_file_path));
            }

            $result = array(
                'name'		    => $file_name,
                'ext'		    => $file_ext,
                'type'		    => $type,
                'path'		    => ROOTPATH . $theme_file_path,
                'content'	    => $content,
                'is_writable'   => is_writeable($theme_file_path)
            );
        }

        return $result;
    }

    public function writeFile($name, $location, $file, $data) {
        if (empty($name) AND empty($location) AND empty($file) AND empty($data)) return FALSE;

        $theme_file_path = ROOTPATH . $location . '/views/themes/' . $name . $file;

        if (!is_file($theme_file_path)) return FALSE;

        if ($fp = @fopen($theme_file_path, FOPEN_READ_WRITE_CREATE_DESTRUCTIVE)) {
            flock($fp, LOCK_EX);
            fwrite($fp, $data);
            flock($fp, LOCK_UN);
            fclose($fp);
            @chmod($theme_file_path, FILE_WRITE_MODE);

            return $data;
        }
    }

    /**
     * Fetch Theme Config File options
     *
     * @param string $theme_path
     * @return bool TRUE if the file was loaded correctly or FALSE on failure
     * @internal param string $path Theme directory path from root directory
     */
    public function getConfig($theme_path = '') {
        $loaded = FALSE;

        if ( ! file_exists(ROOTPATH.$theme_path.'/theme_config.php')) {
            log_message('debug', 'The Theme Config file ['.$theme_path.'] does not exist.');
            return FALSE;
        }

        if (array_key_exists($theme_path, $this->loaded_config)) {
            $loaded = TRUE;
            log_message('debug', 'The Theme Config file ['.$theme_path.'] has already been loaded. Second attempt aborted.');
        }

        if ($loaded === FALSE) {
            include(ROOTPATH.$theme_path.'/theme_config.php');

            if ( ! isset($theme) OR ! is_array($theme)) {
                log_message('debug', 'The Theme Config file [./'.$theme_path.'] does not appear to contain a valid array.');
                return FALSE;
            }

            $this->loaded_config[$theme_path] = $theme;
            unset($theme);
            $loaded = TRUE;
            log_message('debug', 'The Theme Config file [./'.$theme_path.'] loaded.');
        }

        if ($loaded === TRUE) {
            return $this->loaded_config[$theme_path];
        }

        return FALSE;
    }

    public function activateTheme($name, $location) {
        $query = FALSE;

        if (!empty($name) AND $theme = $this->getTheme($name)) {
            if (!empty($location) AND $theme['location'] === $location) {
                $default_themes = $this->config->item('default_themes');
                $default_themes[$location] = $name.'/';

                $this->load->model('Settings_model');
                if ($this->Settings_model->addSetting('prefs', 'default_themes', $default_themes, '1')) {
                    $query = $theme['title'];
                }
            }
        }

        return $query;
    }

    public function updateTheme($update = array()) {
        $query = FALSE;

        if ($this->config->item($update['location'], 'default_themes') === $update['name'].'/') {
            $this->db->set('status', '1');
        } else {
            $this->db->set('status', '0');
        }

        if (!empty($update['data'])) {
            $this->db->set('data', serialize($update['data']));
            $this->db->set('serialized', '1');
        }

        if (!empty($update['title'])) {
            $this->db->set('title', $update['title']);
        }

        if (!empty($update['extension_id']) AND !empty($update['name'])) {
            $this->db->where('type', 'theme');
            $this->db->where('name', $update['name']);
            $this->db->where('extension_id', $update['extension_id']);
            $query = $this->db->update('extensions');
        } else if (!empty($update['name'])) {
            $this->db->set('type', 'theme');
            $this->db->set('name', $update['name']);
            $query = $this->db->insert('extensions');
        }

        $customizer_active_style = $this->config->item('customizer_active_style');
        $customizer_active_style[$update['location']] = array($update['name'], $update['data']);

        if ($this->config->item($update['location'], 'default_themes') === $update['name'].'/') {
            $this->Settings_model->addSetting('prefs', 'customizer_active_style', $customizer_active_style, '1');
        }

        return $query;
    }
}

