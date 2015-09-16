<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Migration Libary Class Extension
 *
 */
class TI_Migration extends CI_Migration {

    public function __construct($config = array()) {
        parent::__construct($config);

        // If the migrations type column is missing, add it
        if ( ! $this->db->field_exists('type', $this->_migration_table)) {
            $this->dbforge->add_column($this->_migration_table, array(
                'type' => array('type' => 'VARCHAR', 'constraint' => 40, 'first' => TRUE),
            ));

            $this->db->update($this->_migration_table, array('type' => 'core'));
        }
    }

    /**
     * Extracts the migration number from a filename
     *
     * @param    string $migration
     * @return    string    Numeric portion of a migration filename
     */
    public function get_migration_number($migration) {
        return $this->_get_migration_number($migration);
    }

    // --------------------------------------------------------------------

    /**
     * Retrieves current schema version
     *
     * @return    string    Current migration version
     */
    public function get_version() {
        return $this->_get_version();
    }

    // --------------------------------------------------------------------

    /**
     * Retrieves current schema version
     *
     * @param string $type
     * @return string Current migration version
     */
//    protected function _get_version($type = '') {
//        $row = $this->db->select('version')->where('type', $type)->get($this->_migration_table)->row();
//
//        return $row ? $row->version : '0';
//    }
//
//    // --------------------------------------------------------------------
//
//    /**
//     * Stores the current schema version
//     *
//     * @param    string $migration Migration reached
//     * @param string $type
//     */
//    protected function _update_version($migration, $type = '')
//    {
//        $this->db->where('type', $type);
//        return $this->db->update($this->_migration_table, array(
//            'version' => $migration
//        ));
//    }
//
    // --------------------------------------------------------------------

    /**
     * Retrieves current schema version
     *
     * @return    string    Current migration version
     */
    public function get_latest_version() {
        return $this->_migration_version;
    }

    // --------------------------------------------------------------------

    /**
     * Install the migrations for the given domain up to the latest version.
     *
     * @return string Current migration version
     */
    public function install() {
        // Core Migrations - this is all that is needed for TastyIgniter install.
        if (($current_version = $this->current()) === FALSE) {
            return FALSE;
        }

        if ( ! $this->Setup_model->loadInitialSchema()) {
            $this->_error_string = 'Migration: initial_schema execution failed';
            return FALSE;
        }

        if ($this->input->post('demo_data') === '1'
            AND ! $this->Setup_model->loadDemoSchema($this->input->post('demo_data'))) {
            $this->_error_string = 'Migration: demo_schema execution failed';
            return FALSE;
        }

        return TRUE;
    }

    // --------------------------------------------------------------------
}

/* End of file TI_Migration.php */
/* Location: ./system/tastyigniter/core/TI_Migration.php */