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
defined('BASEPATH') OR exit('No direImproved Migration capability to check and install module migrations ct script access allowed');

/**
 * TastyIgniter Migration Class
 *
 * @category       Libraries
 * @package        TastyIgniter\Libraries\TI_Migration.php
 * @link           http://docs.tastyigniter.com
 */
class TI_Migration extends CI_Migration {

	public function __construct($config = array()) {
		// Only run this constructor on main library load
		if ( ! in_array(get_class($this), array('CI_Migration', config_item('subclass_prefix') . 'Migration'), TRUE)) {
			return;
		}

		foreach ($config as $key => $val) {
			$this->{'_' . $key} = $val;
		}

		// Ensure this values are not modified from within modules migration config
		$this->_migration_type = 'sequential';
		$this->_migration_auto_latest = FALSE;

		log_message('debug', 'Migrations class initialized');

		// Are they trying to use migrations while it is disabled?
		if ($this->_migration_enabled !== TRUE) {
			show_error('Migrations has been loaded but is disabled or set up incorrectly.');
		}

		// If not set, set it
		$this->_migration_path !== '' OR $this->_migration_path = APPPATH;

		// Add trailing slash if not set
		$this->_migration_path = rtrim($this->_migration_path, '/') . '/';

		// Load migration language
		$this->lang->load('migration');

		// They'll probably be using dbforge
		$this->load->dbforge();

		// Make sure the migration table name was set.
		if (empty($this->_migration_table)) {
			show_error('Migrations configuration file (migration.php) must have "migration_table" set.');
		}

		// Migration basename regex
		$this->_migration_regex = ($this->_migration_type === 'timestamp')
			? '/^\d{14}_(\w+)$/'
			: '/^\d{3}_(\w+)$/';

		// Make sure a valid migration numbering type was set.
		if ( ! in_array($this->_migration_type, array('sequential', 'timestamp'))) {
			show_error('An invalid migration numbering type was specified: ' . $this->_migration_type);
		}

		$this->load->database();

		// If the migrations table is missing, make it
		if ( ! $this->db->table_exists($this->_migration_table)) {
			$this->dbforge->add_field(array(
				'version' => array('type' => 'BIGINT', 'constraint' => 20),
			));

			$this->dbforge->create_table($this->_migration_table, TRUE);

			$this->db->insert($this->_migration_table, array('version' => 0));
		}

		// If the migrations type column is missing, add it
		if ( ! $this->db->field_exists('type', $this->_migration_table)) {
			$this->dbforge->add_column($this->_migration_table, array(
				'type' => array('type' => 'VARCHAR', 'constraint' => 40, 'first' => TRUE),
			));

			$this->db->update($this->_migration_table, array('type' => 'core'));
		}

		// Do we auto migrate to the latest migration?
		if ($this->_migration_auto_latest === TRUE && ! $this->latest()) {
			show_error($this->error_string());
		}
	}

	/**
	 * Sets the schema to the latest migration
	 * for a given migration type
	 *
	 * @param string $type
	 *
	 * @return mixed TRUE if already latest, FALSE if failed, string if upgraded
	 */
	public function latest($type = '')
	{
		$migrations = $this->find_migrations($type);

		if (empty($migrations))
		{
			$this->_error_string = $this->lang->line('migration_none_found');
			return FALSE;
		}

		$last_migration = basename(end($migrations));

		// Calculate the last migration step from existing migration
		// filenames and proceed to the standard version migration
		return $this->version($this->_get_migration_number($last_migration), $type);
	}

	// --------------------------------------------------------------------

	/**
	 * Sets the schema to the migration version set in config
	 * for a given migration type
	 *
	 * @param string $type
	 *
	 * @return mixed TRUE if already current, FALSE if failed, string if upgraded
	 */
	public function current($type = '') {
		$type = ($type === '') ? 'core' : $type;

		$latest_version = $this->get_available_version();

		return $this->version($latest_version, $type);
	}

	// --------------------------------------------------------------------

	/**
	 * Install TastyIgniter core schema to the migration version set in config.
	 *
	 * @return mixed TRUE installed, FALSE if failed
	 */
	public function install() {
		$latest_version = $this->get_available_version();

		// Core Migrations - this is all that is needed for TastyIgniter install.
		if ($this->version($latest_version, 'core') === FALSE) {
			return FALSE;
		}

		$this->load->model('Setup_model');

		if ($this->input->post('demo_data') === '1'
			AND ! $this->Setup_model->loadDemoSchema($this->input->post('demo_data'))) {

			$this->_error_string = 'Migration: demo_schema execution failed';

			return FALSE;
		}

		return TRUE;
	}

	// --------------------------------------------------------------------

	/**
	 * Retrieves list of available migration scripts
	 * for a given migration type
	 *
	 * @param string $type
	 *
	 * @return array list of migration file paths sorted by version
	 */
	public function find_migrations($type = '') {
		$migrations = array();

		$migration_path = $this->get_migrations_path($type);

		// Load all *_*.php files in the migrations path
		foreach (glob($migration_path . '*_*.php') as $file) {
			$name = basename($file, '.php');

			// Filter out non-migration files
			if (preg_match($this->_migration_regex, $name)) {
				$number = $this->_get_migration_number($name);

				// There cannot be duplicate migration numbers
				if (isset($migrations[$number])) {
					$this->_error_string = sprintf($this->lang->line('migration_multiple_version'), $number);
					show_error($this->_error_string);
				}

				$migrations[$number] = $file;
			}
		}

		ksort($migrations);

		return $migrations;
	}

	// --------------------------------------------------------------------

	/**
	 * Extracts the migration number from a filename
	 *
	 * @param    string $migration
	 *
	 * @return    string    Numeric portion of a migration filename
	 */
	public function get_migration_number($migration) {
		return $this->_get_migration_number($migration);
	}

	// --------------------------------------------------------------------

	/**
	 * Retrieves current schema version
	 * for a given migration type
	 *
	 * @param string $type
	 *
	 * @return string Current migration version
	 */
	public function get_version($type = '') {
		return $this->_get_version($type);
	}

	// --------------------------------------------------------------------

	/**
	 * Retrieves latest migration version
	 * for a given migration type
	 *
	 * @param string $type
	 *
	 * @return string Latest migration version
	 */
	public function get_latest_version($type = '') {
		$migrations = $this->find_migrations($type);

		if (empty($migrations)) {
			return 0;
		}

		$last_migration = end($migrations);
		if ($last_migration === FALSE) {
			return 0;
		}

		return $this->_get_migration_number(basename($last_migration));
	}

	// --------------------------------------------------------------------

	/**
	 * Retrieves current available migration version
	 *
	 * @return string Current migration version
	 */
	public function get_available_version() {
		return $this->_migration_version;
	}

	// --------------------------------------------------------------------

	/**
	 * Retrieves the migrations path for a given migration type
	 *
	 * @param string $type
	 *
	 * @return string migration path
	 */
	public function get_migrations_path($type = '') {
		switch ($type) {
			// Core migrations
			case '':
			case 'core':
				return $this->_migration_path;

			// If it is not a core migration, it should be the name of a module.
			default:
				return Modules::path($type, 'migrations/');
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Migrate to a schema version
	 * for a given migration type
	 *
	 * Calls each migration step required to get to the schema version of
	 * choice
	 *
	 * @param string    $type
	 * @param    string $target_version Target schema version
	 *
	 * @return mixed TRUE if already latest, FALSE if failed, string if upgraded
	 */
	public function version($target_version, $type = '') {
		// Note: We use strings, so that timestamp versions work on 32-bit systems
		$current_version = $this->_get_version($type);

		if ($this->_migration_type === 'sequential') {
			$target_version = sprintf('%03d', $target_version);
		} else {
			$target_version = (string) $target_version;
		}

		$migrations = $this->find_migrations($type);

		if ($target_version > 0 && ! isset($migrations[$target_version])) {
			$this->_error_string = sprintf($this->lang->line('migration_not_found'), $target_version);

			return FALSE;
		}

		if ($target_version > $current_version) {
			$method = 'up';
		} elseif ($target_version < $current_version) {
			$method = 'down';
			// We need this so that migrations are applied in reverse order
			krsort($migrations);
		} else {
			// Well, there's nothing to migrate then ...
			return TRUE;
		}

		$previous = FALSE;

		// Validate all available migrations, and run the ones within our target range
		foreach ($migrations as $number => $file) {
			// Check for sequence gaps
			if ($this->_migration_type === 'sequential' && $previous !== FALSE && abs($number - $previous) > 1) {
				$this->_error_string = sprintf($this->lang->line('migration_sequence_gap'), $number);

				return FALSE;
			}

			include_once($file);
			$class = 'Migration_' . ucfirst(strtolower($this->_get_migration_name(basename($file, '.php'))));

			// Validate the migration file structure
			if ( ! class_exists($class, FALSE)) {
				$this->_error_string = sprintf($this->lang->line('migration_class_doesnt_exist'), $class);

				return FALSE;
			}

			$previous = $number;

			// Run migrations that are inside the target range
			if (
				($method === 'up' && $number > $current_version && $number <= $target_version) OR
				($method === 'down' && $number <= $current_version && $number > $target_version)
			) {
				$instance = new $class();
				if ( ! is_callable(array($instance, $method))) {
					$this->_error_string = sprintf($this->lang->line('migration_missing_' . $method . '_method'), $class);

					return FALSE;
				}

				log_message('debug', 'Migrating ' . $type . ' ' . $method . ' from version ' . $current_version . ' to version ' . $number);
				call_user_func(array($instance, $method));
				$current_version = $number;
				$this->_update_version($current_version, $type);
			}
		}

		// This is necessary when moving down, since the the last migration applied
		// will be the down() method for the next migration up from the target
		if ($current_version <> $target_version) {
			$current_version = $target_version;
			$this->_update_version($current_version, $type);
		}

		log_message('debug', 'Finished migrating ' . $type . ' to ' . $current_version);

		return $current_version;
	}

	// --------------------------------------------------------------------

	/**
	 * Retrieves current schema version
	 * for a given migration type
	 *
	 * @param string $type
	 *
	 * @return string Current migration version
	 */
	protected function _get_version($type = '') {
		$row = $this->db->select('version')->where('type', $type)->get($this->_migration_table)->row();

		return $row ? $row->version : '0';
	}

	// --------------------------------------------------------------------

	/**
	 * Stores the current schema version
	 * for a given migration type
	 *
	 * @param    string $migration Migration reached
	 * @param string    $type
	 */
	protected function _update_version($migration, $type = '') {
		$row = $this->db->where('type', $type)->get($this->_migration_table)->row();

		if (!empty($row)) {
	        $this->db->where('type', $type);
			return $this->db->update($this->_migration_table, array('version' => $migration));
		} else {
			return $this->db->insert($this->_migration_table, array('type' => $type, 'version' => $migration));
		}
	}

	// --------------------------------------------------------------------
}

/* End of file TI_Migration.php */
/* Location: ./system/tastyigniter/core/TI_Migration.php */