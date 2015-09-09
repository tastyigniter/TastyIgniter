<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Installer {

    public $db_exists = NULL;

    public $php_version;
    public $php_required_version = '5.4';

    private $supported_dbs = array('mysql', 'mysqli', 'sqlite');

    private $writable_folders = array(
        'admin/cache/',
        'main/cache/',
        'system/tastyigniter/logs/',
        'assets/downloads/',
        'assets/images/'
    );

    private $writable_files = array(
        'system/tastyigniter/config/database.php',
    );

    public function __construct($config = array()) {
        $this->CI =& get_instance();
        $this->php_version = phpversion();
    }

    public function checkRequirements() {
        $result['php_status'] = (bool) ($this->php_version < $this->php_required_version);
        $result['mysqli_status'] = (bool) (extension_loaded('mysqli') AND class_exists('Mysqli'));
        $result['curl_status'] = (bool) function_exists('curl_init');
        $result['gd_status'] = (bool) extension_loaded('gd');
        $result['register_globals_status'] = (bool) !ini_get('register_globals');
        $result['magic_quotes_gpc_status'] = (bool) !ini_get('magic_quotes_gpc');
        $result['file_uploads'] = (bool) !ini_get('file_uploads');

        return $result;
    }

    public function checkWritable($writables = array()) {
        $writables = empty($writables) ? array_merge($this->writable_files, $this->writable_folders) : array();

        $this->CI->load->helper('file');

        $data = array();
        foreach ($writables as $writable) {
            $data[$writable] = array(
                'file' => $writable,
                'status' => is_really_writable(ROOTPATH . $writable),
            );
        }

        return $data;
    }

    public function testDbConnection($hostname, $username, $password, $db_name, $driver) {
        switch ($driver) {
            case 'mysqli':
                $mysqli = @mysqli_connect($hostname, $username, $password, $db_name);
                if ( ! $mysqli->connect_error) {
                    return TRUE;
                }

                return FALSE;
            case 'sqlite':
                if ( ! $sqlite = @sqlite_open($db_name, FILE_WRITE_MODE, $error)) {
                    show_error($error, 500);
                    return FALSE;
                }

                return $sqlite;
            default:
                return FALSE;
        }
    }

    public function isInstalled() {
        if (TI_VERSION === $this->config->item('ti_version')) {
            return TRUE;
        }

        if (is_file(IGNITEPATH . 'config/database.php')) {
            require(IGNITEPATH . 'config/database.php');
        } else {
            $this->db_exists = FALSE;
            return FALSE;
        }

        // If $db['default'] doesn't exist, the app can't load the database
        if ( ! isset($db) OR ! isset($db['default'])) {
            $this->db_exists = FALSE;
            return FALSE;
        }

        // Make sure the database name is specified
        if (empty($db['default']['database']) OR $db['default']['database'] === 'your database name') {
            $this->db_exists = FALSE;
            return FALSE;
        }
        $this->db_exists = TRUE;

        $this->CI->load->database($db['default']);
//        $DATABASE = $this->load->database('default', TRUE);

        // Does the settings table exist?
        if ( ! $this->CI->db->conn_id === FALSE OR ! $this->CI->db->table_exists('settings')) {
            return FALSE;
        }

        // Make sure at least one row exists in the settings table.
        $query = $this->CI->db->get('settings');
        if ($query->num_rows() == 0) {
            return FALSE;
        }

        defined('TI_INSTALLED') OR define('TI_INSTALLED', TRUE);

        return TRUE;
    }

    public function checkFolders($folders = NULL) {
        !is_null($folders) OR $folders = $this->writable_folders;

        return $this->checkWritable($folders);
    }

    public function checkFiles($files = NULL) {
        !is_null($files) OR $files = $this->writable_files;

        return $this->checkWritable($files);
    }

    public function setup() {
        // Install default info into the database.
        // This is done by running the app, core, and module-specific migrations

        // Load the Database before calling the Migrations
        $this->CI->load->database();

        // Install the database tables.
        $this->CI->load->library('migration');
        $row = $this->CI->db->select('version')->get('migrations')->row();
        $old_version = !empty($row) ? $row->version : '0';

        if (($current_version = $this->CI->migration->current()) === FALSE) {
            show_error($this->CI->migration->error_string());
        }

        if ($current_version !== FALSE AND $old_version !== $current_version) {
            if ( ! $this->CI->Setup_model->loadInitialSchema()) {
                log_message('info', 'Migration: initial_schema execution failed');
            }
        }

        if ($current_version !== FALSE AND $this->CI->input->post_get('demo_data') === '1') {
            if ( ! $this->CI->Setup_model->loadDemoSchema($this->CI->input->post_get('demo_data'))) {
                log_message('info', 'Migration: demo_schema execution failed');
            }
        }

//        // Core Migrations - this is all that is needed for Bonfire install.
//        if ( ! $this->CI->migrations->install()) {
//            return $this->CI->migrations->getErrorMessage();
//        }
//
//        // Save the information to the settings table
//        $settings = array(
//            'site.title'        => 'My Bonfire',
//            'site.system_email' => 'admin@mybonfire.com',
//        );
//
//        foreach ($settings as $key => $value) {
//            $setting_rec = array(
//                'name'   => $key,
//                'module' => 'core',
//                'value'  => $value,
//            );
//
//            $this->CI->db->where('name', $key);
//            if ($this->CI->db->update('settings', $setting_rec) == FALSE) {
//                return lang('in_db_settings_error');
//            }
//        }
//
//        // Update the emailer sender_email
//        $setting_rec = array(
//            'name'   => 'sender_email',
//            'module' => 'email',
//            'value'  => '',
//        );
//
//        $this->CI->db->where('name', 'sender_email');
//        if ($this->CI->db->update('settings', $setting_rec) == FALSE) {
//            return lang('in_db_settings_error');
//        }
//
//        // Install the admin user in the users table so they can login.
//        $data = array(
//            'role_id'  => 1,
//            'email'    => 'admin@mybonfire.com',
//            'username' => 'admin',
//            'active'   => 1,
//        );
//
//        // As of 0.7, using phpass for password encryption...
//        require(BFPATH . 'modules/users/libraries/PasswordHash.php');
//
//        $iterations = $this->CI->config->item('password_iterations');
//        $hasher = new PasswordHash($iterations, FALSE);
//        $password = $hasher->HashPassword('password');
//
//        $data['password_hash'] = $password;
//        $data['created_on'] = date('Y-m-d H:i:s');
//        $data['display_name'] = $data['username'];
//
//        if ($this->CI->db->insert('users', $data) == FALSE) {
//            $this->errors = lang('in_db_account_error');
//
//            return FALSE;
//        }
//
//        // Create a unique encryption key
//        $this->CI->load->helper('string');
//        $key = random_string('md5', 40);
//
//        $this->CI->load->helper('config_file');
//
//        $config_array = array('encryption_key' => $key);
//        write_config('config', $config_array, '', APPPATH);
//
//        // Run custom migrations last. In particular this comes after the core
//        // migrations, and after populating the user table.
//
//        // Get the list of custom modules in the main application
//        $module_list = $this->get_module_versions();
//        if (is_array($module_list) && count($module_list)) {
//            foreach ($module_list as $module_name => $module_detail) {
//                // Install the migrations for the custom modules
//                if ( ! $this->CI->migrations->install("{$module_name}_")) {
//                    return $this->CI->migrations->getErrorMessage();
//                }
//            }
//        }
//
//        // Write a file to /public/install/installed.txt as a simple check
//        // whether it's installed, so development doesn't require removing the
//        // install folder.
//        $this->CI->load->helper('file');
//
//        $filename = APPPATH . 'config/installed.txt';
//        $msg = 'Installed On: ' . date('r') . "\n";
//        write_file($filename, $msg);
//
//        $config_array = array(
//            'bonfire.installed' => TRUE,
//        );
//        write_config('application', $config_array, '', APPPATH);
//
//        return TRUE;
    }
}

// END Setting Class

/* End of file Setting.php */
/* Location: ./system/tastyigniter/libraries/Setting.php */