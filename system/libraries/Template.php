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

    protected $_breadcrumb;
    protected $_title_separator;
    protected $_partial_area;
    protected $_view_folders;

    protected $controller;
    protected $method;

    protected $layoutRoute;
    protected $layoutComponents;
    protected $attachedComponents;

    protected $currentView;

    protected $themeCode;
    protected $themeObj;
    protected $partialAreas = [];

    protected $navMenu;
    protected $navMenuItems;

    protected $pageTitle;
    protected $pageHeading;
    protected $pageButtons = [];
    protected $pageIcons = [];
    protected $pageCrumbs = [];

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

        $this->CI->load->library('parser');

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

        // No locations set in config?  Let's use this obvious default
        if ($this->_view_folders === [])
            $this->_view_folders = [THEMEPATH];
    }

    public function render($view = null, $data = [])
    {
        if (is_null($view))
            $view = $this->guessView();

        $event = Events::trigger('Template::before_render', ['view' => $view, 'data' => $data]);
        $data = is_null($event) ? $data : $event;

        $this->currentView = $view;

        // Initialize the components for this layout
        // using the current URI segments
        $this->initLayoutComponents();

        // Lets do the caching instead of the browser
        if ($this->CI->config->item('cache_mode') === '1')
            $this->CI->output->cache($this->CI->config->item('cache_time'));

        // Set whatever values are given. These will be available to all view files
        $this->CI->load->vars($data);

        // Want it returned or output to browser?
        $output = $this->CI->load->view($view);

        $event = Events::trigger('Template::after_render', ['output' => $output]);
        $output = is_null($event) ? $output : $event;

        $this->CI->output->set_output($output);
    }

    public function guessView()
    {
        $view = strtolower(get_class($this->controller)).DIRECTORY_SEPARATOR.$this->method;
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
        return $this->themeCode;
    }

    public function getPartialArea($area = null)
    {
        if (is_null($area))
            return $this->partialAreas;

        if (!isset($this->partialAreas[$area]))
            return null;

        $defaultArea = array_merge([
            'id'          => $area,
            'class'       => '',
        ], $this->_partial_area);

        return array_merge($defaultArea, $this->partialAreas[$area]);
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

    public function getTitle()
    {
        return $this->pageTitle;
    }

    public function getHeading()
    {
        return $this->pageHeading;
    }

    public function getButtonList()
    {
        return implode(PHP_EOL, $this->pageButtons);
    }

    /**
     * @deprecated since 2.2
     * @return string
     */
    public function getIconList()
    {
        return implode(PHP_EOL, $this->pageIcons);
    }

    /**
     * @param array $options default:
     *      [
     *          'tag_open' = '<li class="{class}">',
     *          'link_open' = '<a href="{link}">',
     *          'link_close' = '</a>',
     *          'tag_close' = '</li>',
     *      ]
     *
     * @return string
     */
    public function getBreadcrumb($options = [])
    {
        $options = array_merge($this->_breadcrumb, $options);

        if (isset($this->data['breadcrumbs'])) {
            foreach ($this->data['breadcrumbs'] as $crumb) {
                $replaceData = array_merge([
                    'class' => '',
                    'active' => FALSE,
                    'link' => site_url(trim($crumb['uri'], '/')),
                ], $crumb['replace']);

                if ($replaceData['active']) {
                    $options['link_open'] = '<span class="{class}">';
                    $options['link_close'] = '</span>';
                }

                $options['tag_open'] = $this->CI->parser->parse_string($options['tag_open'], $replaceData);
                $options['link_open'] = $this->CI->parser->parse_string($options['link_open'], $replaceData);

                $crumbs[] = $options['tag_open'].$options['link_open'].$crumb['name'].$options['link_close'].$options['tag_close'];
            }
        }

        return !empty($crumbs) ? implode(PHP_EOL, $crumbs) : null;
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

    /**
     * @used-by	BaseController::_remap()
     *
     * @param BaseController $controller
     * @param string $method
     */
    public function setController($controller, $method = null)
    {
        // What controllers or methods are in use
        if ($controller instanceof BaseController)
            $this->controller = $controller;

        if (!is_null($method))
            $this->method = $method;
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
     * @param array $partialArea
     *
     * @return $this
     */
    public function setPartialAreas($partialArea = null)
    {
        if (is_null($partialArea)) {
            $partialArea = (isset($this->themeObj->partialAreas) AND is_array($this->themeObj->partialAreas)) ?
                $this->themeObj->partialAreas : [];
        }

        foreach ($partialArea as $alias => $area) {
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
        if (is_array($menuItems)) {
            foreach ($menuItems as $item => $menu) {
                $this->navMenuItems[$item] = $menu;
            }
        }

        return $this;
    }

    public function setTitle()
    {
        if (func_num_args()) {
            $this->pageTitle = implode($this->_title_separator, func_get_args());
        }
    }

    public function setHeading($heading)
    {
        if (count($heading_array = explode(':', $heading)) === 2) {
            $heading = $heading_array[0].'&nbsp;<small>'.$heading_array[1].'</small>';
        }

        $this->pageHeading = $heading;
    }

    public function setButton($name, $attributes = [])
    {
        $this->pageButtons[] = '<a'._attributes_to_string($attributes).'>'.$name.'</a>';
    }

    /**
     * @deprecated since 2.2
     * @param $icon
     */
    public function setIcon($icon)
    {
        $this->pageIcons[] = $icon;
    }

    /**
     * @param $name
     * @param string $uri
     * @param array $replace ex. ['class' => 'crumb-link', 'active' => TRUE]
     *
     * @return $this
     */
    public function setBreadcrumb($name, $uri = '', $replace = [])
    {
        $this->data['breadcrumbs'][] = ['name' => $name, 'uri' => $uri, 'replace' => $replace];

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
        return $this->CI->load->partial('header');
    }

    public function get_footer()
    {
        return $this->CI->load->partial('footer');
    }

    public function partial_exists($partialName)
    {
        return isset($this->layoutComponents[$partialName]);
    }

    /**
     * @deprecated since 2.2 use loadComponentArea instead
     *
     * @param string $view
     * @param array $replace
     *
     * @return mixed|string
     */
    public function get_partial($view = '', $replace = [])
    {
        return $this->loadComponentArea($view, $replace);
    }

    public function find_path($view = '')
    {
        if (!empty($this->themeCode)) {
            $themeCode = $this->themeCode;
            $parentThemeCode = $this->themeObj->parent;

            $theme_views = ['/', '/layouts/', '/partials/'];
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

    public function getPartialComponents($partialName)
    {
        if (!isset($this->layoutComponents[$partialName]))
            return null;

        return $this->layoutComponents[$partialName];
    }

    protected function initLayoutComponents()
    {
        $attachedComponents = $this->getAttachedComponentsByRoute();
        if (!is_array($attachedComponents))
            return;

        foreach ($attachedComponents as $partialName => $components) {
            $this->attachComponents($partialName, $components);
            $this->sortComponents($partialName);
        }
    }

    public function attachComponents($partialName, $components)
    {
        foreach ($components as $component) {
            $this->attachComponent($partialName, $component);
        }
    }

    public function attachComponent($partialName, $component)
    {
        if (!isset($component['module_code']) OR (isset($component['status']) AND !$component['status']))
            return;

        $componentCode = $component['module_code'];
        $registeredComponent = Components::findComponent($componentCode);
        if (!$registeredComponent)
            return;

        if (isset($component['partial']) AND in_array($component['partial'], ['top', 'left', 'right', 'bottom']))
            $component['partial'] = 'content_'.$component['partial'];

        $partialArea = $this->getPartialArea($partialName);
        $component = array_merge($registeredComponent, $component);
        $component['view'] = $this->makeComponentView($componentCode, $component, $partialArea['module_html']);
        $this->layoutComponents[$partialName][$componentCode] = $component;
    }

    protected function getAttachedComponentsByRoute()
    {
        if (APPDIR === ADMINDIR) return [];

        if (is_array($this->attachedComponents))
            return $this->attachedComponents;

        $this->CI->load->model('Layouts_model');
        $segments = $this->getLayoutRouteSegments();
        $attachedComponents = $this->CI->Layouts_model->getRouteLayoutModules(array_unique($segments));
        if (!isset($attachedComponents['uri_route']))
            return null;

        // set the current layout route
        $this->layoutRoute = $attachedComponents['uri_route'];
        unset($attachedComponents['uri_route']);

        return $this->attachedComponents = $attachedComponents;
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

    protected function sortComponents($partialName)
    {
        if (isset($this->layoutComponents[$partialName])) {
            foreach ($this->layoutComponents[$partialName] as $key => $module) {
                $components[$key] = $module['priority'];
            }

            array_multisort($components, SORT_ASC, $this->layoutComponents[$partialName]);
        }
    }

    //--------------------------------------------------------------------------
    // VIEWS LOADER
    //--------------------------------------------------------------------------

    /**
     * @deprecated since 2.2 use load->view instead
     *
     * @param $view
     * @param null $data
     *
     * @return object|string
     */
    public function load_view($view, $data = null)
    {
        return $this->CI->load->view($view, $data);
    }

    /**
     * @deprecated since 2.2 use load->partial instead
     *
     * @param $name
     * @param array $data
     *
     * @return null|object|string
     */
    public function load_partial($name, $data = [])
    {
        return $this->CI->load->partial($name, $data);
    }

    public function loadComponentArea($partialName = '', $replaceVariables = [])
    {
        $components = $this->getPartialComponents($partialName);
        if (!is_array($components))
            return $components;

        $partialArea = $this->getPartialArea($partialName);
        if ($replaceVariables)
            $partialArea = array_merge($partialArea, $replaceVariables);

        $partialArea['id'] = str_replace('_', '-', $partialArea['id'])."-".random_string();
        $partialArea['open_tag'] = $this->CI->parser->parse_string($partialArea['open_tag'], $partialArea);

        $componentView = [];
        foreach ($components as $code => $component)
            $componentView[] = $component['view'];

        $partialArea['view'] = implode(PHP_EOL, $componentView);

        $areaWrapper = "{open_tag}{view}{close_tag}";

        return $this->CI->parser->parse_string($areaWrapper, $partialArea);
    }

    protected function makeComponentView($view, $component, $htmlWrapper = null)
    {
        if (!isset($component['code']))
            show_error('Missing [code] index from component array passed to [template->renderComponent]');

        $option = $component['options'];
        $componentTitle = $option['title'];
        if ($componentTitle != '' AND $componentTitle == strip_tags($componentTitle))
            $componentTitle = "<h3 class=\"module-title\">{$componentTitle}</h3>";

        $componentCode = $component['code'];
        $parseData['id'] = "module-".str_replace('_', '-', $componentCode)."-".random_string();
        $parseData['class'] = "module-{$componentCode}";

        $componentView = Components::run($view, $this->controller, $option);

        if ($option['fixed']) {
            $parseData['class'] .= ' affix-module';
            $fixedTag = "<div data-spy=\"affix\" data-offset-top=\"{$option['fixed_top_offset']}\" data-offset-bottom=\"{$option['fixed_bottom_offset']}\">";
            $parseData['module'] = $fixedTag.$componentTitle.$componentView.'</div>';
        } else {
            $parseData['module'] = $componentTitle.$componentView;
        }

        // Parse component wrapper variables
        $htmlWrapper = $this->CI->parser->parse_string($htmlWrapper, $parseData);

        return $htmlWrapper;
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