<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

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

			if (file_put_contents(ROOTPATH . 'assets/downloads/' . $file_name . '.sql', $back_up, LOCK_EX)) {
				return TRUE;
			}
		}

		return FALSE;
	}

	public function restoreDatabase($restore_path) {
		if ($content = file_get_contents($restore_path)) {
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
/* End of file maintenance_model.php */
/* Location: ./system/tastyigniter/models/maintenance_model.php */