<?php namespace System\Classes;

use Exception;
use Igniter\Flame\Traits\Singleton;
use PDO;
use PDOException;

/**
 * Installer Class
 * @package System
 */
class InstallerManager
{
    use Singleton;

    public static $page;

    /** @var boolean Indicates whether the default database settings were found. */
    protected static $db_exists = FALSE;

    /** @var boolean Indicates whether the database tables were found. */
    public $db_installed = FALSE;

    /** @var boolean Indicates whether the database settings were found. */
    public $db_settings_exist = FALSE;

    protected $is_installed = FALSE;

    protected $_db_config_loaded = FALSE;

    public $installed_php_version;

    public $installed_mysql_version;

    public $required_php_version;

    public static $writable_folders = [
        'storage/cache',
        'storage/logs',
        'storage/public',
        'assets/downloads',
        'assets/images',
    ];

    protected $writable_files = [
        'config/database.php',
    ];

    protected $composerManager;

    protected $hubManager;

    /**
     * @var \Setup_model
     */
    protected $model;

//	public function __construct($config = [])
//	{
//		$this->ci() =& get_instance();
//
//		$this->installed_php_version = phpversion();
//		$this->required_php_version = isset($this->required_php_version) ?
//            $this->required_php_version : '5.6';
//
//		$this->composerManager = ComposerManager::instance();
//
//		$this->initialize($config);
//	}

    public function initialize($config = [])
    {
//        $this->hubManager = HubManager::instance();
        $this->composerManager = ComposerManager::instance();
//		$this->checkDatabase();

//		$this->is_installed = $this->isInstalled();
//
//		// If 'config/updated.txt' exists, system needs upgrade
//		if ($this->upgrade()) {
//			redirect(admin_url('dashboard'));
//		}
//
//		// Redirect to setup if app requires setup
//		if (APPDIR !== 'setup') {
//            if (!$this->db_settings_exist OR !$this->db_exists) {
//				if (!file_exists(APPPATH . '/setup/controllers/Setup.php')) {
//					throw new SystemException('Upload missing setup folder', 500, 'Error Was Encountered');
//				} else {
//					redirect(root_url('setup'));
//				}
//			}
//
//			if (!$this->db_installed OR (!$this->db_exists AND $this->is_installed)) {
//				throw new SystemException('Unable to connect to the database', 500, 'Database Error Was Encountered');
//			}
//		}
    }

    public function getSysInfo()
    {
        $info = [
            'domain' => root_url(),
            'ver'    => defined('TI_VERSION') ? TI_VERSION : static::VERSION,
            'os'     => php_uname(),
            'php'    => phpversion(),
        ];

        return $info;
    }

    public function isInstalled()
    {
        if (!$this->checkComposerVendor()) {
            return FALSE;
        }

        $encryptionKey = $this->ci()->config->item('encryption_key');
        if (empty($encryptionKey)) {
            return FALSE;
        }

        // If config ti_version is not same with TI_VERSION const, the app is not installed
        if (TI_VERSION !== $this->ci()->config->item('ti_version')) {
            return FALSE;
        }

//        $setup_state = $this->ci()->config->item('ti_setup');
//        var_dump($setup_state);
//        if (!in_array($setup_state, ['installed', 'updated'])) {
//            return FALSE;
//        }

        return TRUE;
    }

    public function checkComposerVendor()
    {
        return $this->getComposerManager()->checkVendor();
    }

//	public function checkRequirements()
//	{
//		$result['php_status'] = (int)version_compare($this->installed_php_version, $this->required_php_version, ">=");
//		$result['mysqli_status'] = (int)(extension_loaded('mysqli') AND class_exists('Mysqli'));
//		$result['pdo_status'] = (int)defined('PDO::ATTR_DRIVER_NAME') OR class_exists('PDO');
//		$result['curl_status'] = (int)(function_exists('curl_init') AND defined('CURLOPT_FOLLOWLOCATION'));
//		$result['mbstring_status'] = (int)extension_loaded('mbstring');
//		$result['gd_status'] = (int)extension_loaded('gd');
//		$result['zip_status'] = (int)class_exists('ZipArchive');
//		$result['magic_quotes_status'] = (int)!ini_get('magic_quotes_gpc');
//		$result['register_globals_status'] = (int)!ini_get('register_globals');
//		$result['file_uploads_status'] = (int)ini_get('file_uploads');
//
//		return $result;
//	}
//
//	public function checkWritable($writables = [])
//	{
//		$writables = empty($writables) ? array_merge($this->writable_files, $this->writable_folders) : [];
//
//		$this->ci()->load->helper('file');
//
//		$data = [];
//		foreach ($writables as $writable) {
//			$data[$writable] = [
//				'file'   => $writable,
//				'status' => (int)is_really_writable(ROOTPATH . $writable),
//			];
//		}
//
//		return $data;
//	}

    public function checkSettings()
    {
        // Check if site_name and site_email config item is set
        if (!$this->ci()->config->item('site_name') AND !$this->ci()->config->item('site_email')) {
            return FALSE;
        }

        // Does the users table exist?
        if (!$this->ci()->db->table_exists('users')) {
            return FALSE;
        }

        // Make sure at least one row exists in the users table.
        $query = $this->ci()->db->get('users');
        if ($query->num_rows() == 0) {
            return FALSE;
        }

        $this->ci()->load->library('migration');

        if ($this->ci()->migration->get_available_version() > $this->ci()->migration->get_version()) {
            return FALSE;
        }

        // Install the latest database migrations.
        if (!$this->ci()->migration->current()) {
            throw new SystemException($this->ci()->migration->error_string());

            return FALSE;
        }

        $this->ci()->load->model('Setup_model');
        $this->ci()->Setup_model->updateVersion();

        return TRUE;
    }

//	public function checkFolders($folders = null)
//	{
//		!is_null($folders) OR $folders = $this->writable_folders;
//
//		return $this->checkWritable($folders);
//	}
//
//	public function checkFiles($files = null)
//	{
//		!is_null($files) OR $files = $this->writable_files;
//
//		return $this->checkWritable($files);
//	}
//
//	public function checkDatabase()
//	{
//		if (defined('ENVIRONMENT') && is_file(ROOTPATH.'config/' . ENVIRONMENT . '/database.php')) {
//			require(ROOTPATH.'config/' . ENVIRONMENT . '/database.php');
//		// @todo: no need to check development folder
//		} elseif (is_file(ROOTPATH.'config/development/database.php')) {
//			require(ROOTPATH.'config/development/database.php');
//		} elseif (is_file(ROOTPATH.'config/database.php')) {
//			require(ROOTPATH.'config/database.php');
//		} else {
//			$this->db_settings_exist = FALSE;
//
//			return FALSE;
//		}
//
//		// If $db['default'] doesn't exist, the app can't load the database
//		if (!isset($db) OR !isset($db['default'])) {
//			$this->db_settings_exist = FALSE;
//
//			return FALSE;
//		}
//
//		// Try to load database as long as database configuration is not empty
//		$this->ci()->load->database();
//
//		// Make sure the database name is specified
//		if (empty($db['default']['database']) OR $db['default']['dbprefix'] === 'ti_') {
//			$this->db_settings_exist = FALSE;
//
//			return FALSE;
//		}
//
//		// At this point, its clear database configuration is set or modified
//		$this->db_settings_exist = TRUE;
//
//		// Lets make sure the database is connected
//		if ($this->ci()->db->conn_id === FALSE) {
//			$this->db_exists = FALSE;
//
//			return FALSE;
//		}
//
//        $this->db_exists = TRUE;
//
//        // This fix issue with SQL error 'no default value specified'
//		$this->ci()->db->query("SET SESSION sql_mode=''");
//
//		// Check tastyigniter settings database table is installed
//		if (!$this->ci()->db->table_exists('settings')) {
//			return FALSE;
//		}
//
//        $this->db_installed = TRUE;
//
//        // All clear, database is connected and all tables installed.
//		return TRUE;
//	}
//
//	public function testDbConnection($db = [])
//	{
//		$default['driver'] = 'mysqli';
//		$default['database'] = post('database');
//		$default['hostname'] = post('hostname');
//		$default['password'] = post('password');
//		$default['username'] = post('username');
//
//		extract(array_merge($default, $db));
//
//		switch ($driver) {
//			case 'mysqli':
//				$mysqli = @mysqli_connect($hostname, $username, $password, $database);
//				if ($mysqli AND !$mysqli->connect_error) {
//					return TRUE;
//				}
//
//				return FALSE;
//			case 'sqlite':
//				if (!$sqlite = @sqlite_open($database, FILE_WRITE_MODE, $error)) {
//					throw new SystemException($error, 500);
//
//					return FALSE;
//				}
//
//				return $sqlite;
//			default:
//				return FALSE;
//		}
//	}
//
//	public function writeDbConfiguration()
//	{
//		if (!post()) {
//			return;
//		}
//
//		$db_config_path = ROOTPATH.'config/database.php';
//		$database = post('database');
//		$hostname = post('hostname');
//		$username = post('username');
//		$password = post('password');
//		$dbprefix = post('dbprefix');
//
//		if (is_writable($db_config_path)) {
//			if ($fp = @fopen($db_config_path, FOPEN_READ_WRITE_CREATE_DESTRUCTIVE)) {
//
//				$content = "<" . "?php  if ( ! defined('BASEPATH')) exit('No direct access allowed');\n\n";
//
//				$content .= "$" . "active_group = 'default';\n";
//				$content .= "$" . "query_builder = TRUE;\n\n";
//
//				$content .= "$" . "db['default']['dsn'] = '';\n";
//				$content .= "$" . "db['default']['hostname'] = '" . $hostname . "';\n";
//				$content .= "$" . "db['default']['username'] = '" . $username . "';\n";
//				$content .= "$" . "db['default']['password'] = '" . $password . "';\n";
//				$content .= "$" . "db['default']['database'] = '" . $database . "';\n";
//				$content .= "$" . "db['default']['dbdriver'] = 'mysqli';\n";
//				$content .= "$" . "db['default']['dbprefix'] = '" . $dbprefix . "';\n";
//				$content .= "$" . "db['default']['pconnect'] = TRUE;\n";
//				$content .= "$" . "db['default']['db_debug'] = (ENVIRONMENT !== 'production');\n";
//				$content .= "$" . "db['default']['cache_on'] = FALSE;\n";
//				$content .= "$" . "db['default']['cachedir'] = '';\n";
//				$content .= "$" . "db['default']['char_set'] = 'utf8';\n";
//				$content .= "$" . "db['default']['dbcollat'] = 'utf8_general_ci';\n";
//				$content .= "$" . "db['default']['swap_pre'] = '';\n";
//				$content .= "$" . "db['default']['autoinit'] = TRUE;\n";
//				$content .= "$" . "db['default']['encrypt']  = FALSE;\n";
//				$content .= "$" . "db['default']['compress'] = FALSE;\n";
//				$content .= "$" . "db['default']['stricton'] = FALSE;\n";
//				$content .= "$" . "db['default']['failover'] = array();\n";
//				$content .= "$" . "db['default']['save_queries'] = (ENVIRONMENT !== 'production');\n\n";
//
//				$content .= "/* End of file database.php */\n";
//				$content .= "/* Location: ./system/config/database.php */\n";
//
//				flock($fp, LOCK_EX);
//				fwrite($fp, $content);
//				flock($fp, LOCK_UN);
//				fclose($fp);
//
//				@chmod($db_config_path, FILE_WRITE_MODE);
//
//				return TRUE;
//			}
//		}
//	}

    public function prepareSetupModel($options = [])
    {
        $this->ci()->load->model('Setup_model');

        $model = $this->ci()->Setup_model;

        // If we've selected multiple location mode,
        // we will install the demo schema for multiple locations
        if (isset($options['useMulti']))
            $model->useMulti($options['useMulti']);

        // Lets make the initial schema available,
        // to be used later when migrating database
        if (isset($options['schema']))
            $model->loadSchema($options['schema']);

        // Load the demo schema if selected
        if (isset($options['includeDemo']) AND $options['includeDemo'] == TRUE)
            $model->loadSchema('demo');

        $this->model = $model;
    }

    public function setup()
    {
        if (!$this->model OR !$this->model instanceof \Setup_model)
            throw new Exception("Missing [Setup_model] model, check that you have called prepareModel() in your controller.");

        // Install the database tables
        $this->ci()->load->library('migration');
        if (!$this->ci()->migration->install())
            throw new \Exception($this->ci()->migration->error_string());

        // We'll need to reload config cache as migration could have
        // added new config item to the database
        $this->ci()->config->writeDBConfigCache();

        // On fresh install, the config item ti_version does not exist,
        // therefore if it exist then we abort...
        if ($this->ci()->config->item('ti_version'))
            return TRUE;

        // Create the admin user.
        $this->model->addUser(post());

        $settings = [
            'ti_version'         => TI_VERSION,
            'site_key'           => post('site_key'),
            'site_location_mode' => post('site_location_mode'),
            'site_url'           => root_url(),
            'site_name'          => post('site_name'),
            'site_email'         => post('site_email'),
        ];

        // Save the site configuration to the settings table
        if (!$this->model->updateSettings($settings)) {
            throw new \Exception("Failed to update admin settings");
        }

        // Create the default location
        $this->model->updateDefaultLocation($settings);

        // Create config array item containing all installed extensions
        $this->model->updateInstalledExtensions();

        // Create the encryption key used for sessions and encryption
        $this->createEncryptionKey();

        return TRUE;
    }

    public function upgrade()
    {
        if (!is_file(ROOTPATH.'config/updated.txt')) {
            return FALSE;
        }

        $update_version = '';
        if ($fh = @fopen(ROOTPATH.'config/updated.txt', FOPEN_READ)) {
            while ($line = fgets($fh)) {
                if (strpos($line, 'Installed Version:') !== FALSE) {
                    $update_version = preg_replace('/\s+/', '', str_replace('Installed Version:', '', $line));
                }
            }

            fclose($fh);
        }

        if (!empty($update_version) AND $update_version === TI_VERSION) {
            if (in_array(FALSE, $this->checkRequirements(), TRUE) AND in_array(FALSE, $this->checkWritable(), TRUE)) {
                return FALSE;
            }

            $this->ci()->load->model('Setup_model');

            // Install the latest database migrations.
            $this->ci()->load->library('migration');
            if (!$this->ci()->migration->current()) {
                log_message('error', $this->ci()->migration->error_string());

                return FALSE;
            }
            else {
                // Save the site configuration to the settings table
                $settings = ['ti_version' => $update_version, 'site_url' => root_url()];
                if (!$this->ci()->Setup_model->updateSettings($settings)) {
                    return FALSE;
                }

                // Create the default location
                $this->ci()->Setup_model->updateDefaultLocation($settings);

                // Create config array item containing all installed extensions
                $this->ci()->Setup_model->updateInstalledExtensions();

                // Create the encryption key used for sessions and encryption
                $this->createEncryptionKey();
            }

            unlink(ROOTPATH.'config/updated.txt');

            return TRUE;
        }
    }

    public function complete()
    {
        $this->createEncryptionKey();

        $settings = [
            'ti_setup' => (setting('ti_setup') == 'installed') ? 'updated' : 'installed',
            'sys_hash' => md5("TastyIgniter!core!".TI_VERSION),
        ];

        $this->ci()->load->model('Setup_model');

        return $this->ci()->Setup_model->updateSettings($settings);
    }

    public function saveSiteKey($site_key)
    {
        if (!empty($site_key)) {
            setting()->set('site_key', $site_key);
            $this->ci()->load->model('Setup_model');
            $this->ci()->Setup_model->updateSettings(['site_key' => $site_key]);
        }
    }

    public function listRequiredItems($type)
    {
        // cache recommended items for 6 hours.
        $cacheTime = 6 * 60 * 60;
        $items = $this->getHubManager()
                      ->setCacheLife($cacheTime)
                      ->listItems([
                          'browse' => 'recommended',
                          'type'   => $type,
                      ]);

        return $items;
    }

    public function applySetup($names)
    {
        return $this->getHubManager()->applyItems('core', $names);
    }

    public function downloadFile($fileCode, $fileHash, $params = [])
    {
        $filePath = storage_path("temp/".md5($fileCode).'.zip');

        if (!is_dir($fileDir = dirname($filePath)))
            mkdir($fileDir, 0777, TRUE);

        return $this->getHubManager()->downloadFile('setup', $filePath, $fileHash, $params);
    }

    public function extractFile($fileCode, $fileType)
    {
        $extractTo = current(ExtensionManager::instance()->folders());

        $this->ci()->load->library('UpdateManager');

        if (!$this->ci()->updates_manager->extractTo($fileCode, $extractTo.$fileCode))
            throw new Exception('Failed to extract %s archive file', $fileCode);

        return TRUE;
    }

    public function cleanUp()
    {
        if (!function_exists('delete_files'))
            get_instance()->load->helper('file_helper');

        delete_files(ROOTPATH.'assets/downloads/temp', TRUE);
        @rmdir(ROOTPATH.'assets/downloads/temp');

        return 'Installation clean up complete';
    }

    protected function createEncryptionKey()
    {
        $chars = [
            'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm',
            'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z',
            'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M',
            'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z',
            '0', '1', '2', '3', '4', '5', '6', '7', '8', '9',
        ];

        shuffle($chars);
        $num_chars = count($chars) - 1;

        $token = '';
        // Create random token at the specified length.
        for ($i = 0; $i < 32; $i++) {
            $token .= $chars[mt_rand(0, $num_chars)];
        }

        $config_array = ['encryption_key' => $token];

        if (!function_exists('write_config'))
            $this->ci()->load->helper('config_helper');

        return write_config('config', $config_array, '', IGNITEPATH);
    }

    public static function testDbConnection($db = [], $checkTables = TRUE)
    {
        if (self::$db_exists)
            return TRUE;

        extract($db);

        switch ($dbdriver) {
            case 'mysqli':
                $dsn = 'mysql:host='.$hostname.';dbname='.$database;
                if ($port) $dsn .= ";port=".$port;
                break;
            case 'postgre':
                $dsn = 'pgsql:'.(($hostname) ? 'host='.$hostname.';' : '').'dbname='.$database;
                if ($port) $dsn .= ";port=".$port;
                break;
            case 'sqlite':
            case 'sqlite3':
                $dsn = 'sqlite:'.$database;
                if (!$sqlite = @sqlite_open($database, FILE_WRITE_MODE, $error)) {
                    throw new Exception($error);
                }
                break;
        }

        try {
            $db = new PDO($dsn, $username, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
        } catch (PDOException $ex) {
            log_message('error', 'Connection failed: '.$ex->getMessage());

            return FALSE;
        }

        if (!$checkTables) {
            return TRUE;
        }

        // Check the database table prefix is empty
        if ($dbdriver == 'sqlite' OR $dbdriver == 'sqlite3') {
            $fetch = $db->query("select name from sqlite_master where type='table' and table_name like '{$dbprefix}%'", PDO::FETCH_NUM);
        }
        elseif ($dbdriver == 'postgre') {
            $fetch = $db->query("select table_name from information_schema.tables where table_schema = 'public' and table_name like '{$dbprefix}%'", PDO::FETCH_NUM);
        }
        else {
            $fetch = $db->query("show tables where tables_in_{$database} like '".str_replace('_', '\\_', $dbprefix)."%'", PDO::FETCH_NUM);
        }

        $tables = 0;
        while ($result = $fetch->fetch()) $tables++;
        if ($tables > 0) {
            self::$db_exists = TRUE;

            return TRUE;
        }

        return FALSE;
    }

    /**
     * @return \Igniter\Classes\ComposerManager
     */
    protected function getComposerManager()
    {
        return $this->composerManager;
    }

    /**
     * @return \System\Classes\HubManager
     */
    protected function getHubManager()
    {
        return $this->hubManager;
    }
}
