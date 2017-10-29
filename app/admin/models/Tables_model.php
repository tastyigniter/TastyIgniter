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
}
