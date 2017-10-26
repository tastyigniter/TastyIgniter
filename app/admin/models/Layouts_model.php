<?php namespace Admin\Models;

use DB;
use Igniter\Flame\Database\Traits\Purgeable;
use Model;

/**
 * Layouts Model Class
 *
 * @package Admin
 */
class Layouts_model extends Model
{
    use Purgeable;

    /**
     * @var string The database table name
     */
    protected $table = 'layouts';

    /**
     * @var string The database table primary key
     */
    protected $primaryKey = 'layout_id';

    public $relation = [
        'hasMany' => [
            'routes'     => ['Admin\Models\Layout_routes_model', 'delete' => TRUE],
            'components' => ['Admin\Models\Layout_modules_model', 'delete' => TRUE],
        ],
    ];

    public $purgeable = ['routes', 'components'];

    public static function getDropdownOptions()
    {
        return static::dropdown('name');
    }

    //
    // Events
    //

    public function afterSave()
    {
        $this->restorePurgedValues();

        if (array_key_exists('routes', $this->attributes))
            $this->addLayoutRoutes($this->attributes['routes']);

        if (array_key_exists('components', $this->attributes))
            $this->addLayoutModules($this->attributes['components']);
    }

    //
    // Helpers
    //

    /**
     * Return all layouts
     *
     * @return array
     */
    public function getLayouts()
    {
        return $this->get();
    }

    /**
     * Return all layout routes
     *
     * @return array
     */
    public function getRoutes()
    {
        return $this->orderBy('priority')->from('uri_routes')->get();
    }

    /**
     * Find a single layout by layout_id
     *
     * @param int $layout_id
     *
     * @return mixed
     */
    public function getLayout($layout_id)
    {
        return $this->findOrNew($layout_id)->toArray();
    }

    /**
     * Return all layout components
     **
     * @return array
     */
    public function getLayoutModules()
    {
        $result = [];
        if ($components = Layout_modules_model::get()) {
            foreach ($components as $row) {
                $row = $this->getModuleOptionsArray($row);

                $result[$row['layout_id']][] = $row;
            }
        }

        return $result;
    }

    /**
     * Return all layouts by module code
     *
     * @param string $module_code
     *
     * @return array
     */
    public function getModuleLayouts($module_code)
    {
        $this->load->model('Layout_modules_model');
        $layouts = Layout_modules_model::join('layouts', 'layouts.layout_id', '=', 'layout_modules.layout_id', 'left')
                                       ->orderBy('priority')->where('module_code', $module_code)->get();

        $result = [];
        if ($layouts) {
            foreach ($layouts as $row) {
                $row = $this->getModuleOptionsArray($row);

                $result[] = $row;
            }
        }

        return $result;
    }

    /**
     * Return all layouts by $uri_route
     *
     * @param string $uri_route
     *
     * @return array
     * @TODO    use relationship
     */
    public function getRouteLayoutModules($uri_route)
    {
        $result = [];
        $this->load->model('Layout_routes_model');

        if (is_array($uri_route)) {
            foreach ($uri_route as $route) {
                $query = Layout_routes_model::groupBy('layout_module_id');
                $query->select('layout_modules.layout_id', 'layout_module_id', 'module_code', 'uri_route', 'partial', 'priority', 'layout_modules.options', 'layout_modules.status');
                $query->leftJoin('layout_modules', 'layout_modules.layout_id', '=', 'layout_routes.layout_id');
                $query->leftJoin('pages', 'pages.layout_id', '=', 'layout_routes.layout_id');

                if (is_numeric($route)) {
                    $query->orWhere('pages.page_id', $route);
                }
                else {
                    $query->orWhere('layout_routes.uri_route', $route);
                }

                // Lets break the loop if a layout was found.
                if ($rows = $query->get()) {
                    $result['uri_route'] = $route;
                    foreach ($rows as $row) {
                        $row = $this->getModuleOptionsArray($row);

                        $result[$row['partial']][] = $row;
                    }

                    break;
                }
            }
        }

        return $result;
    }

    /**
     * Return all layout routes by layout_id
     *
     * @param int $layout_id
     *
     * @return array
     * @TODO    use relationship
     */
    public function getLayoutRoutes($layout_id)
    {
        $this->load->model('Layout_routes_model');

        return Layout_routes_model::where('layout_id', $layout_id)->get();
    }

    /**
     * Find a single layout by uri route
     *
     * @param string $uri_route
     *
     * @return null
     */
    public function getRouteLayoutId($uri_route = '')
    {
        $layout_id = null;

        if ($uri_route !== '') {
            $this->load->model('Layout_routes_model');
            if ($row = Layout_routes_model::where('uri_route', $uri_route)->first()) {
                $layout_id = $row->layout_id;
            }
        }

        return $layout_id;
    }

    /**
     * Find a single layout by page_id
     *
     * @param string $page_id
     *
     * @return null
     * @TODO    use relationship
     */
    public function getPageLayoutId($page_id = '')
    {
        $layout_id = null;

        if ($page_id !== '') {
            $this->load->model('Pages_model');

            if ($row = Pages_model::find($page_id)) {
                $layout_id = $row->layout_id;
            }
        }

        return $layout_id;
    }

    /**
     * @param $row
     *
     * @return mixed
     */
    public function getModuleOptionsArray($row = [])
    {
        $row['options'] = $options = is_string($row['options']) ? @unserialize($row['options']) : $row['options'];
        $row['options']['title'] = isset($options['title']) ? htmlspecialchars_decode($options['title']) : '';
        $row['options']['fixed'] = isset($options['fixed']) ? (int)$options['fixed'] : 0;
        $row['options']['fixed_top_offset'] = isset($options['fixed_top_offset']) ? (int)$options['fixed_top_offset'] : 0;
        $row['options']['fixed_bottom_offset'] = isset($options['fixed_bottom_offset']) ? (int)$options['fixed_bottom_offset'] : 0;

        return $row;
    }

    /**
     * Update existing routes
     *
     * @deprecated since 2.2.0
     *
     * @param array $routes
     *
     * @return bool TRUE on success
     */
    public function updateRoutes($routes = [])
    {
        if (!empty($routes)) {
            $write_routes = [];

            DB::table('uri_routes')->truncate();
            $priority = 1;
            foreach ($routes as $key => $value) {
                if (!empty($value['uri_route']) AND !empty($value['controller'])) {
                    $write_routes[$priority] = $value;

                    DB::table('uri_routes')->insertGetId([
                        'uri_route'  => $value['uri_route'],
                        'controller' => $value['controller'],
                        'priority'   => $priority,
                    ]);

                    $priority++;
                }
            }

            return TRUE;
        }
    }

    /**
     * Write routes into system routes file
     *
     * @deprecated since 2.2.0, never to be used.
     *
     * @param array $write_routes
     */
    public function writeRoutesFile($write_routes = [])
    {

        $filepath = ROOTPATH.'config/routes.php';
        $line = '';

        if ($fp = @fopen($filepath, FOPEN_READ_WRITE_CREATE_DESTRUCTIVE)) {

            $line .= "<"."?php  if ( ! defined('BASEPATH')) exit('No direct access allowed');\n\n";

            $line .= "$"."route['default_controller'] = 'home';\n";
            $line .= "$"."route[\"^(\".implode('|', array('home', 'menus', 'reserve', 'contact', 'checkout', 'maintenance', 'local', 'pages')).\")?$\"] = '$1';\n";
            $line .= "$"."route[\"^(\".implode('|', array('home', 'menus', 'reserve', 'contact', 'checkout', 'maintenance', 'local', 'pages')).\")?/(:any)$\"] = '$1';\n";
            $line .= "$"."route[\"^(\".implode('|', array('home', 'menus', 'reserve', 'contact', 'checkout', 'maintenance', 'local', 'pages')).\")?/(:any)$\"] = '$1/$2';\n";

            if (!empty($write_routes) AND is_array($write_routes)) {
                foreach ($write_routes as $key => $value) {
                    $line .= "$"."route['".$value['uri_route']."'] = '".$value['controller']."';\n";
                }
            }

            //$line .= "$"."route['(:any)'] = 'slug';\n\n";
            $line .= "$"."route['404_override'] = '';\n\n";

            $line .= "/* End of file routes.php */\n";
            $line .= "/* Location: ./system/config/routes.php */";

            flock($fp, LOCK_EX);
            fwrite($fp, $line);
            flock($fp, LOCK_UN);
            fclose($fp);

            @chmod($filepath, FILE_WRITE_MODE);
        }
    }

    /**
     * Create a new or update existing layout
     *
     * @param       $layout_id
     * @param array $save
     *
     * @return bool
     */
    public function saveLayout($layout_id, $save = [])
    {
        if (empty($save)) return FALSE;

        $layoutModel = $this->findOrNew($layout_id);

        $saved = $layoutModel->fill($save)->save();

        return $saved ? $layoutModel->getKey() : $saved;
    }

    /**
     * Create a new or update existing layout routes
     *
     * @param int $layout_id
     * @param array $routes if empty all existing records will be deleted
     *
     * @return bool|int
     * @TODO    use relationship
     */
    protected function addLayoutRoutes($routes = [])
    {
        $idsToKeep = [];
        foreach ($routes as $route) {
            if (!empty($route['uri_route'])) {
                $layoutRoute = $this->routes()->updateOrCreate([
                    'layout_route_id' => $route['layout_route_id'],
                ], array_merge($route, [
                    'uri_route' => $route['uri_route'],
                ]));

                $idsToKeep[] = $layoutRoute->getKey();
            }
        }

        $this->routes()->whereNotIn('layout_route_id', $idsToKeep)->delete();
    }

    /**
     * Create a new or update existing layout components
     *
     * @param int $layout_id
     * @param array $partialComponents if empty all existing records will be deleted
     *
     * @return bool|int
     * @TODO    use relationship
     */
    protected function addLayoutModules($partialComponents = [])
    {
        $query = FALSE;

        $idsToKeep = [];
        if (count($partialComponents)) {
            foreach ($partialComponents as $partial => $components) {
                $priority = 1;
                foreach ($components as $module) {
                    if (!empty($module) AND is_array($module)) {
                        $layoutModule = $this->components()->updateOrCreate([
                            'layout_module_id' => $module['layout_module_id'],
                        ], array_merge($this->getModuleOptionsArray($module), [
                            'priority' => $priority,
                        ]));

                        $idsToKeep[] = $layoutModule->getKey();
                        $priority++;
                    }
                }
            }
        }

        $this->components()->whereNotIn('layout_module_id', $idsToKeep)->delete();

        return $query;
    }

    /**
     * Delete a single or multiple layout by layout_id
     *
     * @param string|array $layout_id
     *
     * @return int The number of deleted rows
     * @TODO    use relationship
     */
    public function deleteLayout($layout_id)
    {
        if (is_numeric($layout_id)) $layout_id = [$layout_id];

        if (!empty($layout_id) AND ctype_digit(implode('', $layout_id))) {
            return $this->whereIn('layout_id', $layout_id)->delete();
        }
    }
}