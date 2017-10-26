<?php namespace Admin\Models;

use Model;

/**
 * Layout modules Model Class
 *
 * @package Admin
 */
class Layout_modules_model extends Model
{
    /**
     * @var string The database table name
     */
    protected $table = 'layout_modules';

    protected $primaryKey = 'layout_module_id';

    protected $fillable = ['layout_id', 'module_code', 'alias', 'partial', 'priority', 'options', 'status'];

    public $casts = [
        'options' => 'serialize',
    ];

    /**
     * Return all layout modules
     *
     * @return array
     */
    public function getLayoutModules()
    {
        $result = [];

        if ($modules = $this->get()) {
            foreach ($modules as $row) {
                $options = $row['options'];
                $row['title'] = isset($options['title']) ? htmlspecialchars_decode($options['title']) : '';
                $row['fixed'] = isset($options['fixed']) ? $options['fixed'] : '';
                $row['fixed_top_offset'] = isset($options['fixed_top_offset']) ? $options['fixed_top_offset'] : '';
                $row['fixed_bottom_offset'] = isset($options['fixed_bottom_offset']) ? $options['fixed_bottom_offset'] : '';

                $result[$row['layout_id']][] = $row;
            }
        }

        return $result;
    }
}