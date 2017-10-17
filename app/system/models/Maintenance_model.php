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
 */
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Maintenance Model Class
 *
 * @category       Models
 * @package        TastyIgniter\Models\Maintenance_model.php
 * @link           http://docs.tastyigniter.com
 */
class Maintenance_model extends TI_Model {

	public function getdbTables() {
		$result = array();

		$sql = "SELECT table_name, table_rows, engine, data_free, index_length, data_length FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = ? ";
		$query = $this->db->query($sql, $this->db->database);

		if ($query->num_rows() > 0) {
			;
			foreach ($query->result_array() as $row) {
				if ($this->db->table_exists($row['table_name'])) {
					$result[] = $row;
				}
			}
		}

		return $result;
	}

	public function getBackupFiles() {
		$result = array();

		$backup_files = glob(IGNITEPATH . 'migrations/backups/*.sql');
		if (is_array($backup_files)) {
			foreach ($backup_files as $backup_file) {
				$basename = basename($backup_file);
				$result[] = array(
					'filename' => $basename,
					'size'     => filesize($backup_file),
					'download' => site_url('maintenance/backup?download=' . $basename),
					'restore'  => site_url('maintenance/backup?restore=' . $basename),
					'delete'   => site_url('maintenance/backup?delete=' . $basename)
				);
			}
		}

		return $result;
	}

	public function browseTable($filter = array()) {
		if ( ! empty($filter['page']) AND $filter['page'] !== 0) {
			$filter['page'] = ($filter['page'] - 1) * $filter['limit'];
		}

		if ( ! empty($filter['table']) AND is_string($filter['table']) AND $this->db->limit($filter['limit'],
		                                                                                    $filter['page'])
		) {
			$this->db->from($filter['table']);

			$query = $this->db->get();

			$result = array('query' => $query, 'total_rows' => $this->db->count_all($filter['table']));

			return $result;
		}
	}

	public function checkTables($tables = array()) {
		if ( ! empty($tables)) {
			foreach ($tables as $table) {
				if ( ! $this->db->table_exists($table)) {
					return FALSE;
				}
			}

			return TRUE;
		}

		return FALSE;
	}

	public function backupDatabase($backup = array()) {
		if ( ! empty($backup)) {
			$this->load->dbutil();
			$this->load->helper('file');

			$timestamp = mdate('%Y-%m-%d-%H-%i-%s', now());

			$file_name = ! empty($backup['file_name']) ? $backup['file_name'] : 'tastyigniter-' . $timestamp;

			$prefs = array(
				// Array of tables to backup.
				'tables'     => ! empty($backup['tables']) ? $backup['tables'] : array(),
				// gzip, zip, txt
				'format'     => isset($backup['compression']) OR $backup['compression'] !== 'none' ? $backup['compression'] : 'txt',
				// File name - NEEDED ONLY WITH ZIP FILES
				'filename'   => $file_name . '.sql',
				// Whether to add DROP TABLE statements to backup file
				'add_drop'   => isset($backup['drop_tables']) AND $backup['drop_tables'] === '1' ? TRUE : FALSE,
				// Whether to add INSERT data to backup file
				'add_insert' => isset($backup['add_inserts']) AND $backup['add_inserts'] === '1' ? TRUE : FALSE,
				// Newline character used in backup file
				'newline'    => "\n",
			);

			$back_up = $this->dbutil->backup($prefs);

			if ( ! is_dir(IGNITEPATH . 'migrations/backups')) {
				mkdir(IGNITEPATH . 'migrations/backups', DIR_WRITE_MODE);
			}

			if (file_put_contents(IGNITEPATH . 'migrations/backups/' . $file_name . '.sql', $back_up, LOCK_EX)) {
				return TRUE;
			}
		}

		return FALSE;
	}

	public function restoreDatabase($backup_file) {
		$file = pathinfo($this->security->sanitize_filename($backup_file));
		$file_path = IGNITEPATH . "migrations/backups/" . $file['filename'] . ".sql";

		if (isset($file['filename']) AND strpos($file_path, 'tastyigniter-') !== FALSE) {
			if (is_file($file_path) AND $content = file_get_contents($file_path)) {
				foreach (explode(";\n", $content) as $sql) {
					$sql = trim($sql);

					if ($sql) {
						$this->db->query($sql);
					}
				}

				$this->db->query("SET CHARACTER SET utf8");

				return TRUE;
			}
		}
	}

	public function readBackupFile($backup_file) {
		$file = pathinfo($this->security->sanitize_filename($backup_file));
		$file_path = IGNITEPATH . "migrations/backups/" . $file['filename'] . ".sql";

		if (isset($file['filename']) AND strpos($file_path, 'tastyigniter-') !== FALSE) {
			if (is_file($file_path)) {
				return array(
					'filename' => $file['basename'],
					'content' => file_get_contents($file_path),
				);
			}
		}
	}

	public function deleteBackupFile($backup_file) {
		$file = pathinfo($this->security->sanitize_filename($backup_file));
		$file_path = IGNITEPATH . "migrations/backups/" . $file['filename'] . ".sql";

		if ($file['extension'] === 'sql' AND is_file($file_path)) {
			unlink($file_path);
			return TRUE;
		}
	}
}

/* End of file maintenance_model.php */
/* Location: ./system/tastyigniter/models/maintenance_model.php */