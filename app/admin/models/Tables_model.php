<?php namespace Admin\Models;

use Model;

/**
 * Tables Model Class
 *
 * @package Admin
 */
class Tables_model extends Model
{
    /**
     * @var string The database table name
     */
    protected $table = 'tables';

    /**
     * @var string The database table primary key
     */
    protected $primaryKey = 'table_id';

    public $fillable = ['table_name', 'min_capacity', 'max_capacity', 'max_capacity'];

    /**
     * Filter database records
     *
     * @param $query
     * @param array $filter an associative array of field/value pairs
     *
     * @return $this
     */
    public function scopeFilter($query, $filter = [])
    {
        if (isset($filter['filter_search']) AND is_string($filter['filter_search'])) {
            $query->search($filter['filter_search'], ['table_name']);
        }

        if (is_numeric($filter['filter_status'])) {
            $query->where('table_status', $filter['filter_status']);
        }

        return $query;
    }

    /**
     * Return all tables
     *
     * @return array
     */
    public function getTables()
    {
        return $this->get();
    }

    /**
     * Find a single table by table_id
     *
     * @param int $table_id
     *
     * @return array
     */
    public function getTableById($table_id)
    {
        return $this->findOrNew($table_id)->toArray();
    }

    /**
     * Return all tables by location
     *
     * @param int $location_id
     *
     * @return array
     */
    public function getTablesByLocation($location_id = null)
    {
        $location_tables = [];
        $tables = Location_tables_model::where('location_id', $location_id)->get();
        foreach ($tables as $row) {
            $location_tables[] = $row['table_id'];
        }

        return $location_tables;
    }

    /**
     * List all tables matching the filter,
     * to fill select auto-complete options
     *
     * @param array $filter
     *
     * @return array
     */
    public static function getAutoComplete($filter = [])
    {
        if (is_array($filter) && !empty($filter)) {

            $query = self::query()->where('table_status', '>', '0');

            if (!empty($filter['table_name'])) {
                $query->like('table_name', $filter['table_name']);
            }

            return $query->get();
        }
    }

    /**
     * Create a new or update existing table
     *
     * @param int $table_id
     * @param array $save
     *
     * @return bool|int The $table_id of the affected row, or FALSE on failure
     */
    public function saveTable($table_id, $save = [])
    {
        if (empty($save)) return FALSE;

        $tableModel = $this->findOrNew($table_id);

        if ($saved = $tableModel->fill($save)->save()) {
            $table_id = $tableModel->getKey();
            $this->addTableLocations($table_id, isset($save['locations']) ? $save['locations'] : []);

            return $table_id;
        }
    }

    /**
     * Create a new or update existing table locations
     *
     * @param int $menu_id
     * @param array $locations
     *
     * @return bool
     */
    public function addTableLocations($table_id, $locations = [])
    {
        if (is_single_location())
            return TRUE;

        $affected_rows = Location_tables_model::where('table_id', $table_id)->delete();

        if (is_array($locations) && !empty($locations)) {
            foreach ($locations as $key => $location_id) {
                Location_tables_model::firstOrCreate([
                    'table_id'    => $table_id,
                    'location_id' => $location_id,
                ]);
            }
        }

        if (!empty($locations) AND $affected_rows > 0) {
            return TRUE;
        }
    }

    /**
     * Delete a single or multiple table by table_id
     *
     * @param string|array $table_id
     *
     * @return int  The number of deleted rows
     */
    public function deleteTable($table_id)
    {
        if (is_numeric($table_id)) $table_id = [$table_id];

        if (!empty($table_id) AND ctype_digit(implode('', $table_id))) {
            $affected_rows = $this->whereIn('table_id', $table_id)->delete();

            if ($affected_rows > 0) {
                Location_tables_model::whereIn('table_id', $table_id)->delete();
            }
        }
    }
}
