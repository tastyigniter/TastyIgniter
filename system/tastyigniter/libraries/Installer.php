<?php
/**
 * TastyIgniter
 *
 * An open source online ordering, reservation and management system for restaurants.
 *
 * @package   TastyIgniter
 * @author    SamPoyigi
 * @copyright TastyIgniter
 * @link      http://tastyigniter.com
 * @license   http://opensource.org/licenses/GPL-3.0 The GNU GENERAL PUBLIC LICENSE
 * @since     File available since Release 1.0
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Installer Class
 *
 * @category       Libraries
 * @package        TastyIgniter\Libraries\Installer.php
 * @link           http://docs.tastyigniter.com
 */
class Installer {

    public $db_exists = NULL;

    public $installed_php_version;
    public $installed_mysql_version;
    public $required_php_version = '5.4';

    private $writable_folders = array(
        'admin/cache',
        'main/cache',
        'system/tastyigniter/logs',
        'assets/downloads',
        'assets/images'
    );

    private $writable_files = array(
        'system/tastyigniter/config/database.php',
    );

    public function __construct($config = array()) {
        $this->CI =& get_instance();

        $this->CI->load->model('Setup_model');

        $this->installed_php_version = phpversion();
    }

    public function getSysInfo() {
        $info = array();
        $info['version'] = TI_VERSION;
        $info['php_version'] = $this->installed_php_version;
        $info['mysql_version'] = $this->db_exists ? $this->CI->db->version() : '';
        $info['api'] = $this->CI->config->item('api_key', '');

        $this->CI->load->model('Languages_model');
        $languages = $this->CI->Languages_model->getLanguages();
        foreach ($languages as $language) {
            $langs[] = $language['idiom'];
        }

        $info['languages'] = implode(',', $langs);

        return $info;
    }

    public function checkRequirements() {
        $result['php_status']               = (bool) !($this->installed_php_version < $this->required_php_version);
        $result['mysqli_status']            = (bool) (extension_loaded('mysqli') AND class_exists('Mysqli'));
        $result['curl_status']              = (bool) function_exists('curl_init');
        $result['gd_status']                = (bool) extension_loaded('gd');
        $result['magic_quotes_status']      = (bool) !ini_get('magic_quotes_gpc');
        $result['register_globals_status']  = (bool) !ini_get('register_globals');
        $result['file_uploads_status']      = (bool) ini_get('file_uploads');

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

    public function checkSettings() {
        // Check if site_name and site_email config item is set
        if ( ! $this->CI->config->item('site_name') AND ! $this->CI->config->item('site_email')) {
            return FALSE;
        }

        // Does the users table exist?
        if ( ! $this->CI->db->table_exists('users')) {
            return FALSE;
        }

        // Make sure at least one row exists in the users table.
        $query = $this->CI->db->get('users');
        if ($query->num_rows() == 0) {
            return FALSE;
        }

        // Install the latest database migrations.
        $this->CI->load->library('migration');

        if ( ! $this->CI->migration->current()) {
            show_error($this->CI->migration->error_string());

            return FALSE;
        }

        $this->CI->Setup_model->updateVersion();

        return TRUE;
    }

    public function isInstalled() {
        // If config ti_version is same with TI_VERSION const, the app is installed
        if (TI_VERSION === $this->CI->config->item('ti_version')) {
            $this->db_exists = TRUE;
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

        // Make sure the database is connected and the settings table exist
        if ( $this->CI->db->conn_id === FALSE OR ! $this->CI->db->table_exists('settings')) {
            return FALSE;
        }

        $this->db_exists = TRUE;

        if (TI_VERSION !== $this->CI->config->item('ti_version')) {
            return FALSE;
        }

        return TRUE;
    }

    public function testDbConnection() {
        $driver   = 'mysqli';
        $database  = $this->CI->input->post('database');
        $hostname = $this->CI->input->post('hostname');
        $password = $this->CI->input->post('password');
        $username = $this->CI->input->post('username');

        switch ($driver) {
            case 'mysqli':
                $mysqli = @mysqli_connect($hostname, $username, $password, $database);
                if ($mysqli AND ! $mysqli->connect_error) {
                    return TRUE;
                }

                return FALSE;
            case 'sqlite':
                if ( ! $sqlite = @sqlite_open($database, FILE_WRITE_MODE, $error)) {
                    show_error($error, 500);
                    return FALSE;
                }

                return $sqlite;
            default:
                return FALSE;
        }
    }

    public function writeDbConfiguration() {
        if (!$this->CI->input->post()) {
            return;
        }

        $db_config_path = IGNITEPATH .'config/database.php';
        $database  = $this->CI->input->post('database');
        $hostname = $this->CI->input->post('hostname');
        $username = $this->CI->input->post('username');
        $password = $this->CI->input->post('password');
        $dbprefix = $this->CI->input->post('dbprefix');

        if ( is_writable($db_config_path)) {
            if ($fp = @fopen($db_config_path, FOPEN_READ_WRITE_CREATE_DESTRUCTIVE)) {

                $content = "<"."?php  if ( ! defined('BASEPATH')) exit('No direct access allowed');\n\n";

                $content .= "$"."active_group = 'default';\n";
                $content .= "$"."query_builder = TRUE;\n\n";

                $content .= "$"."db['default']['dsn'] = '';\n";
                $content .= "$"."db['default']['hostname'] = '". $hostname ."';\n";
                $content .= "$"."db['default']['username'] = '". $username ."';\n";
                $content .= "$"."db['default']['password'] = '". $password ."';\n";
                $content .= "$"."db['default']['database'] = '". $database ."';\n";
                $content .= "$"."db['default']['dbdriver'] = 'mysqli';\n";
                $content .= "$"."db['default']['dbprefix'] = '". $dbprefix ."';\n";
                $content .= "$"."db['default']['pconnect'] = TRUE;\n";
                $content .= "$"."db['default']['db_debug'] = FALSE;\n";
                $content .= "$"."db['default']['cache_on'] = FALSE;\n";
                $content .= "$"."db['default']['cachedir'] = '';\n";
                $content .= "$"."db['default']['char_set'] = 'utf8';\n";
                $content .= "$"."db['default']['dbcollat'] = 'utf8_general_ci';\n";
                $content .= "$"."db['default']['swap_pre'] = '';\n";
                $content .= "$"."db['default']['autoinit'] = TRUE;\n";
                $content .= "$"."db['default']['encrypt']  = FALSE;\n";
                $content .= "$"."db['default']['compress'] = FALSE;\n";
                $content .= "$"."db['default']['stricton'] = FALSE;\n";
                $content .= "$"."db['default']['failover'] = array();\n";
                $content .= "$"."db['default']['save_queries'] = TRUE;\n\n";

                $content .= "/* End of file database.php */\n";
                $content .= "/* Location: ./system/tastyigniter/config/database.php */\n";

                flock($fp, LOCK_EX);
                fwrite($fp, $content);
                flock($fp, LOCK_UN);
                fclose($fp);

                @chmod($db_config_path, FILE_WRITE_MODE);

                return TRUE;
            }
        }
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
        // Install the database tables.
        $this->CI->load->library('migration');

        if ( ! $this->CI->migration->install()) {
            show_error($this->CI->migration->error_string());
        }

        // Insert the admin user in the users table so they can login.
        if ( ! $this->CI->Setup_model->addUser($this->CI->input->post())) {
            return FALSE;
        }

        // Save the site configuration to the settings table
        $settings = array(
            'ti_setup'          => 'installed',
            'site_name'         => $this->CI->input->post('site_name'),
            'site_email'        => $this->CI->input->post('site_email'),
        );

        if ( ! $this->CI->Setup_model->updateSettings($settings)) {
            return FALSE;
        }

        // Add an item to db configuration as a simple check whether it's installed,
        // so development doesn't require removing the setup folder.
        $this->CI->Setup_model->updateVersion();

        // Create the encryption key used for sessions and encryption
        $this->createEncryptionKey();

        return TRUE;
    }

    public function upgrade() {
        if ( ! is_file(IGNITEPATH . 'config/updated.txt')) {
            return FALSE;
        }

        $update_version = '';
        if ($fh = @fopen(IGNITEPATH . 'config/updated.txt', FOPEN_READ)) {
            while ($line = fgets($fh)) {
                if (strpos($line, 'Installed Version:') !== FALSE) {
                    $update_version = preg_replace('/\s+/', '', str_replace('Installed Version:', '', $line));
                }
            }

            fclose($fh);
        }

        if ( ! empty($update_version) AND $update_version === TI_VERSION) {
            if (in_array(FALSE, $this->checkRequirements(), TRUE) AND in_array(FALSE, $this->checkWritable(), TRUE)) {
                return FALSE;
            }

            // Install the latest database migrations.
            $this->CI->load->library('migration');
            if ( ! $this->CI->migration->current()) {
                log_message('error', $this->CI->migration->error_string());

                return FALSE;
            } else {
                $this->CI->Setup_model->updateVersion($update_version);

                // Save the site configuration to the settings table
                if ( ! $this->CI->Setup_model->updateSettings(array('ti_setup' => 'updated'), TRUE)) {
                    return FALSE;
                }

                // Create the encryption key used for sessions and encryption
                $this->createEncryptionKey();
            }

            unlink(IGNITEPATH . 'config/updated.txt');
            return TRUE;
        }
    }

    protected function createEncryptionKey() {
        $this->CI->load->helper('config_helper');

        $chars = array(
            'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm',
            'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z',
            'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M',
            'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z',
            '0', '1', '2', '3', '4', '5', '6', '7', '8', '9'
        );

        shuffle($chars);
        $num_chars = count($chars) - 1;

        $token = '';
        // Create random token at the specified length.
        for ($i = 0; $i < 32; $i++) {
            $token .= $chars[mt_rand(0, $num_chars)];
        }

        $config_array = array(
            'encryption_key' => $token,
        );

        return write_config('config', $config_array, '', IGNITEPATH);
    }
}

// END Installer Class

/* End of file Installer.php */
/* Location: ./system/tastyigniter/libraries/Installer.php */