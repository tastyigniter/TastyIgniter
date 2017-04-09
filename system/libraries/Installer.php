<?php
/**
 * TastyIgniter
 *
 * An open source online ordering, reservation and management system for restaurants.
 *
 * @package Igniter
 * @author Samuel Adepoyigi
 * @copyright (c) 2013 - 2016. Samuel Adepoyigi
 * @copyright (c) 2016 - 2017. TastyIgniter Dev Team
 * @link https://tastyigniter.com
 * @license http://opensource.org/licenses/MIT The MIT License
 * @since File available since Release 1.0
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Installer Class
 *
 * @category       Libraries
 * @package        Igniter\Libraries\Installer.php
 * @link           http://docs.tastyigniter.com
 */
class Installer
{
	/** @var boolean Indicates whether the default database settings were found. */
	public $db_exists = FALSE;

	/** @var boolean Indicates whether the database settings were found. */
	public $db_settings_exist = FALSE;

	protected $is_installed = FALSE;
	protected $_db_config_loaded = FALSE;

	public $installed_php_version;
	public $installed_mysql_version;
	public $required_php_version;

	protected $writable_folders = [
		'admin/cache',
		'main/cache',
		'system/tastyigniter/logs',
		'assets/cache',
		'assets/downloads',
		'assets/images',
	];

	protected $writable_files = [
		'system/tastyigniter/config/database.php',
	];

	public function __construct($config = [])
	{
		$this->CI =& get_instance();

		$this->installed_php_version = phpversion();
		$this->required_php_version = isset($this->required_php_version) ?
            $this->required_php_version : '5.6';

		$this->CI->load->library('hub_manager');

		$this->initialize($config);
	}

	public function initialize($config = [])
	{
		$this->checkDatabase();

		$this->is_installed = $this->isInstalled();

		// If 'config/updated.txt' exists, system needs upgrade
		if ($this->upgrade()) {
			redirect(admin_url('dashboard'));
		}

		// Redirect to setup if app requires setup
		if (APPDIR !== 'setup') {
			if ($this->db_settings_exist !== TRUE OR ($this->db_exists AND $this->is_installed !== TRUE)) {
				if (!file_exists(APPPATH . '/setup/controllers/Setup.php')) {
					show_error('Upload missing setup folder', 500, 'Error Was Encountered');
				} else {
					redirect(root_url('setup'));
				}
			}

			if ($this->db_exists !== TRUE AND $this->db_settings_exist AND $this->is_installed !== TRUE) {
				show_error('Unable to connect to the database', 500, 'Database Error Was Encountered');
			}
		}
	}

	public function getSysInfo()
	{
		$info = [];
		$info['domain'] = root_url();
		$info['ver'] = TI_VERSION;
		$info['php'] = $this->installed_php_version;
		$info['mysql'] = $this->db_exists ? $this->CI->db->version() : '5.5';
		$info['web'] = isset($_SERVER['SERVER_SOFTWARE']) ? $_SERVER['SERVER_SOFTWARE'] : null;

		return $info;
	}

	public function checkComposerVendor()
	{
		if (!isset($this->CI->composer_manager))
			$this->CI->load->library('Composer_manager');

		return $this->CI->composer_manager->checkVendor();
	}

	public function checkRequirements()
	{
		$result['php_status'] = (int)version_compare($this->installed_php_version, $this->required_php_version, ">=");
		$result['mysqli_status'] = (int)(extension_loaded('mysqli') AND class_exists('Mysqli'));
		$result['pdo_status'] = (int)defined('PDO::ATTR_DRIVER_NAME') OR class_exists('PDO');
		$result['curl_status'] = (int)(function_exists('curl_init') AND defined('CURLOPT_FOLLOWLOCATION'));
		$result['mbstring_status'] = (int)extension_loaded('mbstring');
		$result['gd_status'] = (int)extension_loaded('gd');
		$result['zip_status'] = (int)class_exists('ZipArchive');
		$result['magic_quotes_status'] = (int)!ini_get('magic_quotes_gpc');
		$result['register_globals_status'] = (int)!ini_get('register_globals');
		$result['file_uploads_status'] = (int)ini_get('file_uploads');

		return $result;
	}

	public function checkWritable($writables = [])
	{
		$writables = empty($writables) ? array_merge($this->writable_files, $this->writable_folders) : [];

		$this->CI->load->helper('file');

		$data = [];
		foreach ($writables as $writable) {
			$data[$writable] = [
				'file'   => $writable,
				'status' => (int)is_really_writable(ROOTPATH . $writable),
			];
		}

		return $data;
	}

	public function checkSettings()
	{
		// Check if site_name and site_email config item is set
		if (!$this->CI->config->item('site_name') AND !$this->CI->config->item('site_email')) {
			return FALSE;
		}

		// Does the users table exist?
		if (!$this->CI->db->table_exists('users')) {
			return FALSE;
		}

		// Make sure at least one row exists in the users table.
		$query = $this->CI->db->get('users');
		if ($query->num_rows() == 0) {
			return FALSE;
		}

		// Install the latest database migrations.
		$this->CI->load->library('migration');

		if (!$this->CI->migration->current()) {
			show_error($this->CI->migration->error_string());

			return FALSE;
		}

		$this->CI->load->model('Setup_model');
		$this->CI->Setup_model->updateVersion();

		return TRUE;
	}

	public function isInstalled()
	{
		if (!$this->checkComposerVendor()) {
			return FALSE;
		}

		$encryptionKey = $this->CI->config->item('encryption_key');
		if (empty($encryptionKey)) {
			return FALSE;
		}

		// If config ti_version is not same with TI_VERSION const, the app is not installed
		if (TI_VERSION !== $this->CI->config->item('ti_version')) {
			return FALSE;
		}

		$setup_state = $this->CI->config->item('ti_setup');
		if (!in_array($setup_state, ['installed', 'updated'])) {
			return FALSE;
		}

		return TRUE;
	}

	public function checkFolders($folders = null)
	{
		!is_null($folders) OR $folders = $this->writable_folders;

		return $this->checkWritable($folders);
	}

	public function checkFiles($files = null)
	{
		!is_null($files) OR $files = $this->writable_files;

		return $this->checkWritable($files);
	}

	public function checkDatabase()
	{
		if (defined('ENVIRONMENT') && is_file(ROOTPATH.'config/' . ENVIRONMENT . '/database.php')) {
			require(ROOTPATH.'config/' . ENVIRONMENT . '/database.php');
		// @todo: no need to check development folder
		} elseif (is_file(ROOTPATH.'config/development/database.php')) {
			require(ROOTPATH.'config/development/database.php');
		} elseif (is_file(ROOTPATH.'config/database.php')) {
			require(ROOTPATH.'config/database.php');
		} else {
			$this->db_settings_exist = FALSE;

			return FALSE;
		}

		// If $db['default'] doesn't exist, the app can't load the database
		if (!isset($db) OR !isset($db['default'])) {
			$this->db_settings_exist = FALSE;

			return FALSE;
		}

		// Try to load database as long as database configuration is not empty
		$this->CI->load->database();

		// Make sure the database name is specified
		if (empty($db['default']['database']) OR $db['default']['dbprefix'] === 'ti_') {
			$this->db_settings_exist = FALSE;

			return FALSE;
		}

		// At this point, its clear database configuration is set or modified
		$this->db_settings_exist = TRUE;

		// Lets make sure the database is connected
		if ($this->CI->db->conn_id === FALSE) {
			$this->db_exists = FALSE;

			return FALSE;
		}

		$this->db_exists = TRUE;

		// This fix issue with SQL error 'no default value specified'
		$this->CI->db->query("SET SESSION sql_mode=''");

		// Check tastyigniter settings database table is installed
		if (!$this->CI->db->table_exists('settings')) {
			return FALSE;
		}

		// All clear, database is connected and all tables installed.
		return TRUE;
	}

	public function testDbConnection($db = [])
	{
		$default['driver'] = 'mysqli';
		$default['database'] = $this->CI->input->post('database');
		$default['hostname'] = $this->CI->input->post('hostname');
		$default['password'] = $this->CI->input->post('password');
		$default['username'] = $this->CI->input->post('username');

		extract(array_merge($default, $db));

		switch ($driver) {
			case 'mysqli':
				$mysqli = @mysqli_connect($hostname, $username, $password, $database);
				if ($mysqli AND !$mysqli->connect_error) {
					return TRUE;
				}

				return FALSE;
			case 'sqlite':
				if (!$sqlite = @sqlite_open($database, FILE_WRITE_MODE, $error)) {
					show_error($error, 500);

					return FALSE;
				}

				return $sqlite;
			default:
				return FALSE;
		}
	}

	public function writeDbConfiguration()
	{
		if (!$this->CI->input->post()) {
			return;
		}

		$db_config_path = ROOTPATH.'config/database.php';
		$database = $this->CI->input->post('database');
		$hostname = $this->CI->input->post('hostname');
		$username = $this->CI->input->post('username');
		$password = $this->CI->input->post('password');
		$dbprefix = $this->CI->input->post('dbprefix');

		if (is_writable($db_config_path)) {
			if ($fp = @fopen($db_config_path, FOPEN_READ_WRITE_CREATE_DESTRUCTIVE)) {

				$content = "<" . "?php  if ( ! defined('BASEPATH')) exit('No direct access allowed');\n\n";

				$content .= "$" . "active_group = 'default';\n";
				$content .= "$" . "query_builder = TRUE;\n\n";

				$content .= "$" . "db['default']['dsn'] = '';\n";
				$content .= "$" . "db['default']['hostname'] = '" . $hostname . "';\n";
				$content .= "$" . "db['default']['username'] = '" . $username . "';\n";
				$content .= "$" . "db['default']['password'] = '" . $password . "';\n";
				$content .= "$" . "db['default']['database'] = '" . $database . "';\n";
				$content .= "$" . "db['default']['dbdriver'] = 'mysqli';\n";
				$content .= "$" . "db['default']['dbprefix'] = '" . $dbprefix . "';\n";
				$content .= "$" . "db['default']['pconnect'] = TRUE;\n";
				$content .= "$" . "db['default']['db_debug'] = (ENVIRONMENT !== 'production');\n";
				$content .= "$" . "db['default']['cache_on'] = FALSE;\n";
				$content .= "$" . "db['default']['cachedir'] = '';\n";
				$content .= "$" . "db['default']['char_set'] = 'utf8';\n";
				$content .= "$" . "db['default']['dbcollat'] = 'utf8_general_ci';\n";
				$content .= "$" . "db['default']['swap_pre'] = '';\n";
				$content .= "$" . "db['default']['autoinit'] = TRUE;\n";
				$content .= "$" . "db['default']['encrypt']  = FALSE;\n";
				$content .= "$" . "db['default']['compress'] = FALSE;\n";
				$content .= "$" . "db['default']['stricton'] = FALSE;\n";
				$content .= "$" . "db['default']['failover'] = array();\n";
				$content .= "$" . "db['default']['save_queries'] = (ENVIRONMENT !== 'production');\n\n";

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

	public function setup()
	{
		$this->CI->load->model('Setup_model');

		$this->CI->Setup_model->loadSchema();

		// Install the database tables and demo data if necessary.
		$this->CI->load->library('migration');
		if (!$this->CI->migration->install()) {
			show_error($this->CI->migration->error_string());
		}

		// Insert the admin user in the users table so they can login.
		if (!$this->CI->Setup_model->addUser($this->CI->input->post())) {
			return FALSE;
		}

		// Save the site configuration to the settings table
		$settings = [
			'ti_version'         => TI_VERSION,
			'site_location_mode' => $this->CI->input->post('site_location_mode'),
			'site_url'           => root_url(),
			'site_name'          => $this->CI->input->post('site_name'),
			'site_email'         => $this->CI->input->post('site_email'),
		];

		if (!$this->CI->Setup_model->updateSettings($settings)) {
			return FALSE;
		}

		// Create the default location
		$this->CI->Setup_model->updateDefaultLocation($settings);

		// Create config array item containing all installed extensions
		$this->CI->Setup_model->updateInstalledExtensions();

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

			$this->CI->load->model('Setup_model');

			// Install the latest database migrations.
			$this->CI->load->library('migration');
			if (!$this->CI->migration->current()) {
				log_message('error', $this->CI->migration->error_string());

				return FALSE;
			} else {
				// Save the site configuration to the settings table
				$settings = ['ti_version' => $update_version, 'site_url' => root_url()];
				if (!$this->CI->Setup_model->updateSettings($settings)) {
					return FALSE;
				}

				// Create the default location
				$this->CI->Setup_model->updateDefaultLocation($settings);

				// Create config array item containing all installed extensions
				$this->CI->Setup_model->updateInstalledExtensions();

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
			'ti_setup' => (config_item('ti_setup') == 'installed') ? 'updated' : 'installed',
			'sys_hash' => md5("TastyIgniter!core!".TI_VERSION),
		];

		$this->CI->load->model('Setup_model');

		return $this->CI->Setup_model->updateSettings($settings);
	}

	public function saveSiteKey($site_key)
	{
		if (!empty($site_key)) {
			$this->CI->config->set_item('site_key', $site_key);
			$this->CI->load->model('Setup_model');
			$this->CI->Setup_model->updateSettings(['site_key' => $site_key]);
		}
	}

	public function applySetup($names)
	{
		return $this->getHubManager()->applyInstallOrUpdate('setup', $names);
	}

	public function downloadFile($fileCode, $fileHash, $params = [])
	{
		$filePath = storage_path("temp/".md5($fileCode) . '.zip');

		if (!is_dir($fileDir = dirname($filePath)))
			mkdir($fileDir, 0777, TRUE);

		return $this->getHubManager()->downloadFile('setup', $filePath, $fileHash, $params);
	}

	public function extractFile($fileCode, $fileType)
	{
		$extractTo = current(Modules::folders());

		$this->CI->load->library('updates_manager');

		if (!$this->CI->updates_manager->extractTo($fileCode, $extractTo . $fileCode))
			throw new Exception('Failed to extract %s archive file', $fileCode);

		return TRUE;
	}

	public function cleanUp()
	{
		if (!function_exists('delete_files'))
			get_instance()->load->helper('file_helper');

		delete_files(ROOTPATH . 'assets/downloads/temp', TRUE);
		@rmdir(ROOTPATH . 'assets/downloads/temp');

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
			$this->CI->load->helper('config_helper');

		return write_config('config', $config_array, '', IGNITEPATH);
	}

	/**
	 * @return Hub_manager
	 */
	protected function getHubManager()
	{
		return $this->CI->hub_manager;
	}
}

// END Installer Class

/* End of file Installer.php */
/* Location: ./system/tastyigniter/libraries/Installer.php */