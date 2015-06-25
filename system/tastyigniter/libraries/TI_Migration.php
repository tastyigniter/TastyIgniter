<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Migration Libary Class Extension
 *
 */
class TI_Migration extends CI_Migration {

    /**
     * Extracts the migration number from a filename
     *
     * @param	string	$migration
     * @return	string	Numeric portion of a migration filename
     */
    public function get_migration_number($migration)
    {
        return $this->_get_migration_number($migration);
    }

    // --------------------------------------------------------------------

    /**
     * Retrieves current schema version
     *
     * @return	string	Current migration version
     */
    public function get_version()
    {
        return $this->_get_version();
    }

    // --------------------------------------------------------------------

    /**
     * Retrieves current schema version
     *
     * @return	string	Current migration version
     */
    public function get_latest_version()
    {
        return $this->_migration_version;
    }

    // --------------------------------------------------------------------
}

/* End of file TI_Migration.php */
/* Location: ./system/tastyigniter/core/TI_Migration.php */