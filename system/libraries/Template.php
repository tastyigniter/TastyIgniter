<?php
/**
 * TastyIgniter
 *
 * An open source online ordering, reservation and management system for restaurants.
 *
 * @package Igniter
 * @author Samuel Adepoyigi
 * @copyright (c) 2013 - 2016. Samuel Adepoyigi
 * @copyright (c) 2016 - 2017. TastyIgniter Dev Team
 * @link https://tastyigniter.com
 * @license http://opensource.org/licenses/MIT The MIT License
 * @since File available since Release 1.0
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Template Class
 *
 * @category       Libraries
 * @package        Igniter\Libraries\Template.php
 * @link           http://docs.tastyigniter.com
 */
class Template
{

    protected $_title_separator;
    protected $_view_folders;
    protected $_head_tags;

    protected $module;
    protected $controller;
    protected $method;

    protected $layout;
    protected $currentView;

    protected $themeCode;
    protected $themeObj;
    protected $partialAreas = [];

    protected $navMenu;
    protected $navMenuItems;

    protected $parent_theme = null;
    protected $theme_path = null;
    protected $theme_shortpath = null;
    protected $layouts = [];
    protected $partials = [];
    protected $components = [];
    protected $title_separator = ' | ';
    protected $data = [];
    protected $theme_fields = [];
    protected $theme_config = [];

    /**
     * @var \BaseController
     */
    private $CI;

    /**
     * Constructor - Sets Preferences
     *
     * The constructor can be passed an array of config values
     *
     * @param array $config
     */
    public function __construct($config = [])
    {
        $this->CI =& get_instance();

        $this->CI->load->library('assets');

        $this->CI->load->helper('template');
        $this->CI->load->helper('assets');
        $this->CI->load->helper('html');
        $this->CI->load->helper('string');

        empty($config) OR $this->initialize($config);

        log_message('info', 'Template Class Initialized');
    }

    public function initialize($config = [])
    {
        if (!empty($config)) foreach ($config as $key => $val) {
            if (property_exists($this, '_'.$key))
                $this->{'_'.$key} = $val;
        }
        unset($config);

        // Set active theme
        if ($activeTheme = $this->CI->config->item(APPDIR, 'default_themes'))
            $this->setTheme($activeTheme);

        // Modular Separation / Modular Extensions has been detected
        if (method_exists($this->CI->router, 'fetch_module'))
            $this->module = $this->CI->router->fetch_module();

        // No locations set in config?  Let's use this obvious default
        if ($this->_view_folders === [])
            $this->_view_folders = [THEMEPATH];
    }

    public function render($view = null, $data = [], $return = FALSE)
    {
        if (is_null($view))
            $view = $this->guessView();

        $this->currentView = $view;

        // Set whatever values are given. These will be available to all view files
        if (!empty($data))
            $this->setData($data);

        // We don't need you any more buddy
        unset($data);

        // Initialize the components for this layout
        // using the current URI segments
        $this->initLayoutComponents();

//        log_message('info', '------->>>>>>>>>   Template::render:  Load Components');
        // Load the layouts and partials variables
//        $this->loadPartials();
//        dd($this->currentView);

        // Lets do the caching instead of the browser
        if ($this->CI->config->item('cache_mode') === '1') {
//			$this->CI->output->cache($this->CI->config->item('cache_time'));
        }

        // Want it returned or output to browser?
        $output = $this->load_view($view, null, null, FALSE);

        Events::trigger('after_layout_render', $output);

        $this->CI->output->set_output($output);
    }

    public function guessView()
    {
        $controllerClass = strtolower(get_class($this->controller));
        $view = $controllerClass.DIRECTORY_SEPARATOR.$this->method;

        foreach ($this->_view_folders as $view_folder) {
            if (is_file($view_folder.$this->themeCode.DIRECTORY_SEPARATOR.$view.EXT))
                return $view;
        }

        show_error('Unable to guess view for: '.$view);

        return null;
    }

    //--------------------------------------------------------------------------
    // GETTER METHODS
    //--------------------------------------------------------------------------

    public function getTheme()
    {
        return $this->theme;
    }

    public function getCustomizer($item, $value = null)
    {
        if (empty($this->themeObj->customizer) OR !is_array($this->themeObj->customizer))
            return null;

        if ($item)
            return isset($this->themeObj->customizer[$item]) ?
                $this->themeObj->customizer[$item] : $value;

        return $this->themeObj->customizer;
    }

    // @todo: get from controller object
    public function getTitle()
    {
        return isset($this->data['title']) ? $this->data['title'] : '';
    }

    // @todo: get from controller object
    public function getHeading()
    {
        $heading = '';
        if (isset($this->data['heading'])) {
            if (count($heading_array = explode(':', $this->data['heading'])) === 2) {
                $heading = $heading_array[0].'&nbsp;&nbsp;<small>'.$heading_array[1].'</small>';
            } else {
                $heading = $this->data['heading'];
            }
        }

        return $heading;
    }

    // @todo: get from controller object
    public function getButtonList()
    {
        return (isset($this->data['buttons']) AND is_array($this->data['buttons'])) ? implode("\n\t\t", $this->data['buttons']) : '';
    }

    // @todo: get from controller object
    public function getIconList()
    {
        return (isset($this->data['icons']) AND is_array($this->data['icons'])) ? implode("\n\t\t", $this->data['icons']) : '';
    }

    // @todo: get from controller object
    public function getBreadcrumb($tag_open = '<li class="{class}">', $link_open = '<a href="{link}">', $link_close = ' </a>', $tag_close = '</li>')
    {
        $crumbs = '';

        if (isset($this->data['breadcrumbs'])) {
            foreach ($this->data['breadcrumbs'] as $crumb) {
                if (!empty($crumb['uri'])) {
                    $crumbs .= str_replace('{class}', '', $tag_open).str_replace('{link}', site_url(trim($crumb['uri'], '/')), $link_open).$crumb['name'].$link_close;
                } else {
                    $crumbs .= str_replace('{class}', 'active', $tag_open).'<span>'.$crumb['name'].' </span>';
                }

                $crumbs .= $tag_close;
            }
        }

        return (!empty($crumbs)) ? '<ol class="breadcrumb">'.$crumbs.'</ol>' : $crumbs;
    }

    public function getThemeLocation($theme = null)
    {
        $theme OR $theme = $this->theme;
        foreach ($this->_view_folders as $location) {
            if (is_dir($location.$theme)) {
                return $location;
            }
        }

        return FALSE;
    }

    //--------------------------------------------------------------------------
    // SETTER METHODS
    //--------------------------------------------------------------------------

    public function setController($controller = null, $method = null)
    {
        // What controllers or methods are in use
        if (!is_null($controller))
            $this->controller = $controller;

        if (!is_null($method))
            $this->method = $method;
    }

    public function setData($viewData)
    {
        if (!is_array($viewData))
            return FALSE;

        // Merge in what we already have with the specific data
        $this->data = array_merge($this->data, $viewData);
    }

    /**
     * @param $themeCode
     */
    public function setTheme($themeCode)
    {
        $themeCode = trim($themeCode, '/');
        $this->themeObj = $this->themeManager()->findTheme($themeCode);
        if (!$this->themeObj)
            show_error('Unable to load the active theme: '.$themeCode);

        $this->themeCode = $themeCode;

        // Set the header and footer views
        $this->themeObj->layouts = ['header' => [], 'footer' => []];

        // Make HTML head tags from customizer config
        if (!empty($this->themeObj->customizer['head_tags']))
            $this->assets()->setHeadTags($this->themeObj->customizer['head_tags']);

        // Set the partial areas registered in the theme config
        $this->setPartialAreas();

        // Set the nav menu items registered in the theme config
        $this->setNavMenuItems();
    }

    /**
     * @param array $partialAreas
     *
     * @return $this
     */
    public function setPartialAreas($partialAreas = null)
    {
        if (is_null($partialAreas)) {
            $partialAreas = (isset($this->themeObj->partialAreas) AND is_array($this->themeObj->partialAreas)) ?
                $this->themeObj->partialAreas : [];
        }

        foreach ($partialAreas as $alias => $area) {
            $alias = is_string($alias) ? $alias : (isset($area['id']) ? $area['id'] : $area);
            $this->partialAreas[$alias] = $area;
        }

        return $this;
    }

    public function setNavMenuItems()
    {
        if (!empty($this->navMenuItems))
            return $this;

        $menuItems = $this->getCustomizer('nav_menu');
        if (!$menuItems)
            return $this;

        foreach ($menuItems as $item => $menu) {
            $this->navMenuItems[$item] = $menu;
        }

        return $this;
    }

    public function setTitle()
    {
        if (func_num_args() >= 1) {
            $this->data['title'] = implode($this->title_separator, func_get_args());
        }
    }

    // @todo: set from controller actions instead
    public function setHeading($heading = '')
    {
        $this->data['heading'] = $heading;
    }

    // @todo: set from controller actions instead
    public function setButton($name, $attributes = [])
    {
        $attr = '';
        foreach ($attributes as $key => $value) {
            $attr .= ' '.$key.'="'.$value.'"';
        }

        $this->data['buttons'][] = '<a'.$attr.'>'.$name.'</a>';
    }

    // @todo: set from controller actions instead
    public function setIcon($icon)
    {
        $this->data['icons'][] = $icon;
    }

    // @todo: set from controller actions instead
    public function setBreadcrumb($name, $uri = '')
    {
        $this->data['breadcrumbs'][] = ['name' => $name, 'uri' => $uri];

        return $this;
    }

    //--------------------------------------------------------------------------
    // NAVIGATION MENU
    //--------------------------------------------------------------------------

    public function addNavMenuItem($item, $options = [], $parent = null)
    {
        if (!empty($parent)) {
            $this->navMenuItems[$parent]['child'][$item] = $options;
        } else {
            $this->navMenuItems[$item] = $options;
        }
    }

    public function removeNavMenuItem($item, $parent = null)
    {
        if (!empty($parent)) {
            unset($this->navMenuItems[$parent]['child'][$item]);
        } else {
            unset($this->navMenuItems[$item]);
        }
    }

    public function navMenu($prefs = [])
    {
        // Bail out if nav_menu theme config item is missing or not an array
        if (!is_array($this->navMenuItems))
            return null;

        $openTag = '<ul class="nav" id="side-menu">';
        $closeTag = '</ul>';

        extract($prefs);

        return $openTag.$this->_buildNavMenu($this->navMenuItems).$closeTag;
    }

    protected function _buildNavMenu($nav_menu = [], $has_child = 0)
    {
        $levels = ['', 'nav-second-level', 'nav-third-level'];

        foreach ($nav_menu as $key => $value) {
            $sort_array[$key] = isset($value['priority']) ? $value['priority'] : '1111';
        }

        array_multisort($sort_array, SORT_ASC, $nav_menu);

        $out = '';
        foreach ($nav_menu as $menu) {
            if (isset($menu['permission'])) {
                $permission = (strpos($menu['permission'], '|') !== FALSE) ? explode('|', $menu['permission']) : [$menu['permission']];

                $permitted = [];
                foreach ($permission as $perm) {
                    $permitted[strtolower($perm)] = (!$this->CI->user->hasPermission($perm.'.Access')) ? FALSE : TRUE;
                }

                if (!($permitted = array_filter($permitted))) continue;
            }

            $out .= '<li>'.$this->_buildNavMenuLink($menu);

            if (isset($menu['child']) AND is_array($menu['child'])) {
                $has_child += 1;

                $child_links = $this->_buildNavMenu($menu['child'], $has_child);
                $out .= '<ul class="nav '.$levels[$has_child].'">'.$child_links.'</ul>';

                $has_child = 0;
            }

            $out .= '</li>';
        }

        return $out;
    }

    protected function _buildNavMenuLink($menu_link = [])
    {
        $out = '<a';

        if (isset($menu_link['class'])) {
            $out .= ' class="'.$menu_link['class'].'"';
        }

        if (isset($menu_link['href'])) {
            $out .= ' href="'.$menu_link['href'].'"';
        }

        $out .= '>';
        if (isset($menu_link['icon'])) {
            $out .= '<i class="fa '.$menu_link['icon'].' fa-fw"></i>';
        } else {
            $out .= '<i class="fa fa-square-o fa-fw"></i>';
        }

        if (isset($menu_link['icon']) AND isset($menu_link['title'])) {
            $out .= '<span class="content">'.$menu_link['title'].'</span>';
        } else {
            $out .= $menu_link['title'];
        }

        if (isset($menu_link['child'])) {
            $out .= '<span class="fa arrow"></span>';
        }

        $out .= '</a>';

        return $out;
    }

    //--------------------------------------------------------------------------
    // LAYOUT, COMPONENTS & PARTIALS
    //--------------------------------------------------------------------------

    public function get_header()
    {
        return $this->load_view('header', $this->data);
    }

    public function get_footer()
    {
        return $this->load_view('footer', $this->data);
    }

    // @todo: get data from controller object
    public function partial_exists($view = '')
    {
        return isset($this->partials[$view]);
    }

    public function get_partial($view = '', $replace = [])
    {
        $partial = empty($this->partials[$view]) ? $this->getPartial($view) : $this->partials[$view];
        var_dump($view);

        $partial_class = !empty($partial['data']['class']) ? $partial['data']['class'] : '';
        $partial_class = !empty($replace['class']) ? $replace['class'] : $partial_class;

        $partial_data = isset($partial['data']['open_tag']) ? str_replace('{id}', str_replace('_', '-', $view), str_replace('{class}', $partial_class, $partial['data']['open_tag'])) : '';
        $partial_data .= empty($partial['view']) ? '' : $partial['view'];
        $partial_data .= isset($partial['data']['close_tag']) ? $partial['data']['close_tag'] : '';

        return $partial_data;
    }

    public function find_path($view = '')
    {
        if (!empty($this->themeCode)) {
            $theme_views = ['/', '/layouts/', '/partials/'];

            $themeCode = $this->themeCode;
            $parentThemeCode = $this->themeObj->parent;

            foreach ($this->_view_folders as $location) {

                foreach ($theme_views as $theme_view) {
                    $t_view = (pathinfo($view, PATHINFO_EXTENSION)) ? $view : $view.'.php';
                    if (file_exists($location.$themeCode.$theme_view.$t_view)) {
                        return [$themeCode.$theme_view.$view, $location];
                    } else if (file_exists($location.$parentThemeCode.$theme_view.$t_view)) {
                        return [$parentThemeCode.$theme_view.$view, $location];
                    }
                }
            }
        }

        // Not found it yet?
        return [$view, null];
    }

    protected function loadPartials()
    {
        $partialAreas = array_merge($this->partialAreas, $this->layouts);

        foreach ($partialAreas as $partial_name => $partial_data) {
            if (!is_string($partial_name)) continue;

            if ($partial_view = $this->load_partial($partial_name, $partial_data)) {
                $this->partials[$partial_name] = ['data' => $partial_data, 'view' => $partial_view];
            }
        }
    }

    protected function getPartial($partial = '')
    {
        list($name, $data) = [$partial, []];

        if (!is_string($name)) return null;

        $view = $this->load_partial($name, $data);

        return ['data' => $data, 'view' => $view];
    }

    protected function initLayoutComponents()
    {
        list($uriRoute, $components) = $this->getLayoutComponentsByRoute();
        foreach ($components as $component) {
            $this->attachComponent();
        }
    }

    protected function getLayoutComponents()
    {
        // Do nothing if template is rendered from a component

        list($uri_route, $layout_modules) = $this->getLayoutComponentsByRoute();

        $components = [];
        $_components = Components::listComponents();
        foreach ($layout_modules as $partial => $partial_modules) {
            foreach ($partial_modules as $layout_module) {
                if (isset($layout_module['module_code']) AND !empty($_components[$layout_module['module_code']])) {
                    $component = $_components[$layout_module['module_code']];

                    if ($component['code'] == $layout_module['module_code'] AND $layout_module['status'] == '1') {
                        $partial = $layout_module['partial'];
                        if (in_array($layout_module['partial'], ['top', 'left', 'right', 'bottom'])) {
                            $partial = 'content_'.$layout_module['partial'];
                        }

                        unset($layout_module['options']);
                        $components[$partial][] = [
                            'code'                => $component['code'],
                            'name'                => $component['name'],
                            'layout_id'           => $layout_module['layout_id'],
                            'uri_route'           => $uri_route,
                            'partial'             => $partial,
                            'priority'            => $layout_module['priority'],
                            'title'               => $layout_module['title'],
                            'fixed'               => $layout_module['fixed'],
                            'fixed_top_offset'    => $layout_module['fixed_top_offset'],
                            'fixed_bottom_offset' => $layout_module['fixed_bottom_offset'],
                        ];
                    }
                }
            }
        }

        return $components;
    }

    protected function getLayoutComponentsByRoute()
    {
        if (APPDIR === ADMINDIR) return [null, []];

        $this->CI->load->model('Layouts_model');
        $segments = $this->getLayoutRouteSegments();
        $layoutComponents = $this->CI->Layouts_model->getRouteLayoutModules($segments);

        // Lets break the look if a layout was found.
        $uri_route = isset($layoutComponents['uri_route']) ? $layoutComponents['uri_route'] : '';
        if (!empty($layoutComponents)) {
            return [$uri_route, $layoutComponents];
        }

        // We return null if no layout was found.
        return [null, []];
    }

    /**
     * @return array
     */
    protected function getLayoutRouteSegments()
    {
        $routes = [$this->CI->uri->segment_array(), $this->CI->uri->uri_string(),
            $this->CI->uri->rsegment_array(), $this->CI->uri->ruri_string()];

        if (!$this->CI->uri->segment(2) AND in_array('index', $this->CI->uri->rsegment_array())) {
            array_push($routes, $this->CI->uri->rsegment(1).'/'.$this->CI->uri->rsegment(1));
        }

        $segments = [];
        foreach ($routes as $key => $route) {
            if ($route === 'pages') {
                $segments[] = (int)$this->CI->input->get('page_id');
            } else if (is_array($route)) {
                $val = '';
                foreach ($route as $value) {
                    if ($value === 'index') continue;

                    $val = $val.'/'.$value;
                    $segments[] .= trim($val, '/');
                }
            } else if ($route !== 'index') {
                $segments[] = $route;
            }
        }

        return empty($routes) ? null : $segments;
    }

    protected function sortComponents($partial_name)
    {
        if (!empty($partial_name)) {
            foreach ($this->components[$partial_name] as $key => $module) {
                $components[$key] = $module['priority'];
            }

            array_multisort($components, SORT_ASC, $this->components[$partial_name]);
        }
    }

    //--------------------------------------------------------------------------
    // VIEWS LOADER
    //--------------------------------------------------------------------------

    public function load_view($view, $data = null, $override_view_path = null, $return = TRUE)
    {
        if (empty($data))
            $data = $this->data;

        list($view, $location) = $this->find_path($view);

        if (!empty($location)) $override_view_path = $location;

        if (!empty($override_view_path)) {
            $this->CI->load->vars($data);

            // Load it directly, bypassing $this->load->view() as MX resets _ci_view
            $content = $this->CI->load->file($override_view_path.$view.'.php', TRUE);
        } else {
            // Can just run as usual
            // Grab the content of the view
            $content = $this->CI->load->view($view, $data);
        }

        return $content;
    }

    public function load_partial($name, $data = [])
    {
        $view = null;

        if (isset($this->layouts[$name])) {
            $view = $this->load_view($name, $data);
        } else if (!empty($this->partialAreas[$name])) {
            // We stop here if no module was found.
            if (empty($this->components[$name])) return $view;

            $count = 1;
            $this->sortComponents($name);
            foreach ($this->components[$name] as $module) {
                $view .= $this->buildPartialComponent($module, $data, $count++);
            }
        }

        return $view;
    }

    protected function buildPartialComponent($module, $partial_data, $count)
    {
        $module_view = Components::run($module['code'].'/index', $this->controller, $module);
        var_dump("buildPartialComponent => {$module['code']}");

        if (!empty($module['title'])) {
            $module_view = ($module['title'] != strip_tags($module['title'])) ? $module['title'].$module_view : "<h3 class=\"module-title\">{$module['title']}</h3>".$module_view;
        }

        $module_class = 'module-'.$module['code'].'';
        if ($module['fixed'] == '1') {
            $top_offset = isset($module['fixed_top_offset']) ? $module['fixed_top_offset'] : '';
            $bottom_offset = isset($module['fixed_bottom_offset']) ? $module['fixed_bottom_offset'] : '';
            $fixed_tag = '<div data-spy="affix" data-offset-top="'.$top_offset.'" data-offset-bottom="'.$bottom_offset.'">';
            $module_view = $fixed_tag.$module_view.'</div>';
            $module_class .= ' affix-module';
        }

        (!empty($partial_data['module_html'])) OR $partial_data['module_html'] = '<div id="{id}" class="{class}">{module}</div>';

        $module_view = str_replace('{id}', 'module-'.str_replace('_', '-', $module['code']).'-'.$count,
            str_replace('{class}', $module_class, str_replace('{module}', $module_view, $partial_data['module_html'])));

        return $module_view;
    }

    /**
     * @return Theme_manager
     */
    public function themeManager()
    {
        if (!isset($this->CI->theme_manager))
            $this->CI->load->library('theme_manager');

        return $this->CI->theme_manager;
    }

    /**
     * @return Assets
     */
    public function assets()
    {
        if (!isset($this->CI->assets))
            $this->CI->load->library('assets');

        return $this->CI->assets;
    }
}

// END Template Class

/* End of file Template.php */
/* Location: ./system/tastyigniter/libraries/Template.php */