<?php namespace System\Models;

use DB;
use Model;

/**
 * Maintenance Model Class
 *
 * @package System
 */
class Maintenance_model extends Model
{
    protected static $storageFolder = 'backups';

    /**
     * List all database tables
     *
     * @return array
     */
    public function getDbTables()
    {
        $result = [];

        $connectionName = app('config')->get('database.default');
//        $connection = app('db')->connection($connectionName);
        $connection = app('config')->get('database.connections.'.$connectionName);


        $sql = "SELECT table_name, table_rows, engine, data_free, index_length, data_length "
            ."FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = ? AND table_name LIKE "
            .DB::connection()->getPdo()->quote($connection['prefix'].'%')."";

        $query = DB::select($sql, [$connection['database']]);

        if (count($query)) {
            foreach ($query as $row) {
                $result[] = (array) $row;
            }
        }

        return $result;
    }

    /**
     * Return all backed up SQL files
     *
     * @return array
     */
    public function getBackupFiles()
    {
        $result = [];

        $storagePath = storage_path(self::$storageFolder);
        $backup_files = glob($storagePath.'/*.sql');
        if (is_array($backup_files)) {
            foreach ($backup_files as $backup_file) {
                $basename = basename($backup_file);
                $result[] = [
                    'filename' => rtrim($basename, '.sql'),
                    'time' => filemtime($backup_file),
                    'size'     => filesize($backup_file),
                ];
            }
        }

        return sort_array($result, 'time', SORT_DESC);
    }

    /**
     * List all database table records matching filter
     *
     * @param array $filter
     *
     * @return array
     */
    public function browseTable($filter = [])
    {
        if (!empty($filter['page']) AND $filter['page'] !== 0) {
            $filter['page'] = ($filter['page'] - 1) * $filter['limit'];
        }

        if (!empty($filter['table']) AND is_string($filter['table']) AND $this->ci()->limit($filter['limit'], $filter['page'])) {
            $this->ci()->from($filter['table']);

            $query = $this->ci()->get();

            $result = ['query' => $query, 'total_rows' => $this->ci()->count_all($filter['table'])];

            return $result;
        }
    }

    /**
     * Check if a table exist in the database
     *
     * @param array $tables
     *
     * @return bool TRUE on success, or FALSE on failure
     */
    public function checkTables($tables = [])
    {
        if (!empty($tables)) {
            foreach ($tables as $table) {
                if (!$this->ci()->table_exists($table)) {
                    return FALSE;
                }
            }

            return TRUE;
        }

        return FALSE;
    }

    /**
     * Backup database and save backup file
     *
     * @param array $backup an array containing backup options
     *
     * @return bool
     */
    public function backupDatabase($backup = [])
    {
        if (!empty($backup)) {
            $this->ci()->load->dbutil();
            $this->ci()->load->helper('file');

            $timestamp = mdate('%Y-%m-%d-%H-%i-%s', now());

            $file_name = !empty($backup['file_name']) ? $backup['file_name'] : 'tastyigniter-'.$timestamp;

            $prefs = [
                // Array of tables to backup.
                'tables'     => !empty($backup['backup_tables']) ? $backup['backup_tables'] : [],
                // gzip, zip, txt
                'format'     => (isset($backup['compression']) AND $backup['compression'] !== 'none') ? $backup['compression'] : 'txt',
                // File name - NEEDED ONLY WITH ZIP FILES
                'filename'   => $file_name.'.sql',
                // Whether to add DROP TABLE statements to backup file
                'add_drop'   => isset($backup['drop_tables']) AND $backup['drop_tables'] == '1' ? TRUE : FALSE,
                // Whether to add INSERT data to backup file
                'add_insert' => isset($backup['add_inserts']) AND $backup['add_inserts'] == '1' ? TRUE : FALSE,
                // Newline character used in backup file
                'newline'    => "\n",
            ];

            $back_up = $this->dbutil->backup($prefs);

            $storagePath = storage_path(self::$storageFolder);
            if (!is_dir(storage_path(self::$storageFolder))) {
                mkdir($storagePath, DIR_WRITE_MODE);
            }

            if (file_put_contents($storagePath.DIRECTORY_SEPARATOR.$file_name.'.sql', $back_up, LOCK_EX)) {
                return TRUE;
            }
        }

        return FALSE;
    }

    /**
     * Restore database from existing backup file
     *
     * @param $backup_file
     *
     * @return bool
     */
    public function restoreDatabase($backup_file)
    {
        $file = pathinfo($this->security->sanitize_filename($backup_file));
        $file_path = storage_path(self::$storageFolder.DIRECTORY_SEPARATOR.$file['filename'].".sql");

        if (isset($file['filename']) AND strpos($file_path, 'tastyigniter-') !== FALSE) {
            if (is_file($file_path) AND $content = file_get_contents($file_path)) {
                foreach (explode(";\n", $content) as $sql) {
                    $sql = trim($sql);

                    if ($sql) {
                        $this->ci()->query($sql);
                    }
                }

                $this->ci()->query("SET CHARACTER SET utf8");

                return TRUE;
            }
        }
    }

    /**
     * Read the database backup file from backup folder
     *
     * @param $backup_file
     *
     * @return array
     */
    public function readBackupFile($backup_file)
    {
        $file = pathinfo($this->ci()->security->sanitize_filename($backup_file));
        $file_path = storage_path(self::$storageFolder.DIRECTORY_SEPARATOR.$file['filename'].".sql");

        if (isset($file['filename']) AND strpos($file_path, 'tastyigniter-') !== FALSE) {
            if (is_file($file_path)) {
                return [
                    'filename' => $file['basename'].".sql",
                    'content'  => file_get_contents($file_path),
                ];
            }
        }
    }

    /**
     * Delete a single or multiple database file
     *
     * @param $backup_file
     *
     * @return bool TRUE on success, or FALSE on failure
     */
    public function deleteBackupFile($backup_file)
    {
        $file = pathinfo($this->ci()->security->sanitize_filename($backup_file));
        $file_path = storage_path(self::$storageFolder.DIRECTORY_SEPARATOR.$file['filename'].".sql");

        if (is_file($file_path)) {
            unlink($file_path);

            return TRUE;
        }
    }
}