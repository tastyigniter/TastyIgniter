<?php namespace Admin\Classes;

use AdminAuth;
use File;
use Html;
use System\Classes\BaseController;
use System\Classes\ExtensionManager;
use Main\Classes\Page;
use Main\Classes\ThemeManager;
use SystemException;

/**
 * Template Class
 * @package Admin
 */
class Template
{
    protected $_breadcrumb = [
        'divider'    => '&raquo;',
        'tag_open'   => '<li class="{class}">',
        'tag_close'  => '</li>',
        'link_open'  => '<a href="{link}">',
        'link_close' => '</a>',
    ];

    protected $_title_separator = ' - ';

    protected $method;

    public $currentView;

    protected $themeCode;

    protected $themeObj;

    protected $partialAreas = [];

    protected $pageTitle;

    protected $pageHeading;

    protected $pageButtons = [];

    protected $pageIcons = [];

    protected $pageCrumbs = [];

//    public $data = [];

    public $blocks = [];

    /**
     * @var \System\Classes\BaseController
     */
    protected $controller;

    /**
     * @var ThemeManager
     */
    public $themeManager;

    /**
     * @var \System\Libraries\Assets
     */
//    public $assetsManager;

//    protected $overrideView;

    /**
     * Constructor - Sets Preferences
     * The constructor can be passed an array of config values
     *
     * @param array $config
     */
    public function __construct($config = [])
    {
        $this->initialize($config);
    }

    public function initialize($config = [])
    {
        if (!empty($config)) foreach ($config as $key => $val) {
            $key = '_'.$key;
            if (property_exists($this, $key))
                $this->{$key} = $val;
        }
    }

    public function setThemeManager($themeManager)
    {
        $this->themeManager = $themeManager;
    }

//    public function setAssetsManager($assetsManager)
//    {
//        $this->assetsManager = $assetsManager;
//    }

    /**
     * Returns the layout block contents but does not deletes the block from memory.
     *
     * @param string $name Specifies the block name.
     * @param string $default Specifies a default block value to use if the block requested is not exists.
     *
     * @return string
     */
    public function getBlock($name, $default = null)
    {
        if (!isset($this->blocks[$name])) {
            return $default;
        }

        return $this->blocks[$name];
    }

    /**
     * Appends a content of the layout block.
     *
     * @param string $name Specifies the block name.
     * @param string $contents Specifies the block content.
     */
    public function appendBlock($name, $contents)
    {
        if (!isset($this->blocks[$name])) {
            $this->blocks[$name] = null;
        }

        $this->blocks[$name] .= $contents;
    }

    /**
     * Sets a content of the layout block.
     *
     * @param string $name Specifies the block name.
     * @param string $contents Specifies the block content.
     */
    public function setBlock($name, $contents)
    {
        $this->blocks[$name] = $contents;
    }

//    public function render($view = null, $data = [], $return = TRUE)
//    {
//        if (is_null($view) OR $this->overrideView)
//            $view = $this->overrideView ?: $this->guessView();
//
//        if (!$this->overrideView)
//            $this->overrideView = $view;
//
////        $event = Event::trigger('Template::before_render', ['view' => $view, 'data' => $data]);
////        $data = is_null($event) ? $data : $event;
//
//        // Initialize the components for this layout using the current URI segments
////        $this->initLayoutComponents();
//
//        // Lets do the caching instead of the browser
//        if ($this->CI->config->item('cache_mode') === '1')
//            $this->CI->output->cache($this->CI->config->item('cache_time'));
//
//        // Page object is available on all pages @todo create class when rending page since all it does is hold view data
//        $this->CI->page = new PageObject($this->controller);
////        $this->load->library('page', $this);
//
//        // Make HTML head tags from customizer config
//        if (!empty($this->themeObj->config['head_tags']))
//            $this->assets()->setHeadTags($this->themeObj->config['head_tags']);
//
//        // Set whatever values are given. These will be available to all view files
//        $this->setData($data);
//
//        $this->controller->suppressView = TRUE;
//
//        // Want it returned or output to browser?
//        return $this->CI->load->view($view, $data, $return);
//
////        $event = Event::trigger('Template::after_render', ['output' => $output]);
////        $output = is_null($event) ? $output : $event;
////
////        $this->CI->output->set_output($output);
//    }
//
//    public function renderMainMenu()
//    {
//        return $this->controller->widgets['mainmenu']->render();
//    }

//    public function guessView()
//    {
//        if ($this->controller instanceof \Main\Classes\MainController)
//            return $this->guessViewPath(EXT);
//
//        return $this->guessViewPath($this->method.EXT);
//    }
//
//    public function guessViewPath($suffix = null, $suppressError = FALSE)
//    {
//        $view = $this->controller->getClass();
//        foreach ($this->_view_folders as $view_folder) {
//            if (file_exists($view_folder.$this->themeCode.DIRECTORY_SEPARATOR.$view.DIRECTORY_SEPARATOR.$suffix)) {
//                return $view.DIRECTORY_SEPARATOR.$suffix;
//            }
//            else if (file_exists($view_folder.$this->themeCode.DIRECTORY_SEPARATOR.$view.$suffix)) {
//                return $view.$suffix;
//            }
//        }
//
//        if (!$suppressError) throw new SystemException('Unable to guess view for: '.$view.DIRECTORY_SEPARATOR.$suffix);
//    }

    //--------------------------------------------------------------------------
    // GETTER METHODS
    //--------------------------------------------------------------------------

    public function getTheme()
    {
        return $this->themeCode;
    }

//    public function getPartialArea($area = null)
//    {
//        $defaultArea = array_merge([
//            'id'    => $area,
//            'class' => '',
//        ], $this->_partial_area);
//
//        if (isset($this->themeObj->partialAreas[$area]))
//            return array_merge($defaultArea, $this->themeObj->partialAreas[$area]);
//
//        return is_null($area) ? $this->themeObj->partialAreas : null;
//    }

    public function getCustomizer($item, $value = null)
    {
        if (empty($this->themeObj->customizeConfig) OR !is_array($this->themeObj->customizeConfig))
            return null;

        if ($item)
            return isset($this->themeObj->customizeConfig[$item]) ?
                $this->themeObj->customizeConfig[$item] : $value;

        return $this->themeObj->customizeConfig;
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

        foreach ($this->pageCrumbs as $crumb) {
            $replaceData = array_merge([
                'class'  => '',
                'active' => FALSE,
                'link'   => site_url(trim($crumb['uri'], '/')),
            ], $crumb['replace']);

            if ($replaceData['active']) {
                $options['link_open'] = '<span class="{class}">';
                $options['link_close'] = '</span>';
            }

            $options['tag_open'] = parse_values($replaceData, $options['tag_open']);
            $options['link_open'] = parse_values($replaceData, $options['link_open']);

            $crumbs[] = $options['tag_open'].$options['link_open'].$crumb['name'].$options['link_close'].$options['tag_close'];
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
     * @used-by    BaseController::__construct()
     *
     * @param \System\Classes\BaseController $controller
     *
     * @throws SystemException
     */
    public function setController($controller)
    {
        // What controllers or methods are in use
        if (!$controller instanceof BaseController)
            throw new SystemException('Controller set on Template library must be instance of BaseController');

        $this->controller = $controller;
    }

    public function setNavMenuContext($itemCode, $parentCode = null)
    {
        self::$navMenuContextItemCode = $itemCode;
        self::$navMenuContextParentCode = is_null($parentCode) ? $itemCode : $parentCode;
    }

    public function loadActiveTheme()
    {
//        $themeManager = $this->themeManager();
//
//        $themeCode = $themeManager->getActiveThemeCode();
//        $this->themeObj = $themeManager->getActiveTheme();
//        if (!$this->themeObj)
//            throw new SystemException('Unable to load the active theme: '.$themeCode);
//
//        $this->themeCode = $this->themeObj->getName();

        // Set the partial areas registered in the theme config
//        $this->setPartialAreas();
    }

    /**
     * @param array $partialArea
     *
     * @return $this
     */
    public function setPartialAreas()
    {
        if (!$this->themeObj->partials)
            return $this;

        $partialArea = (is_array($this->themeObj->partials))
            ? $this->themeObj->partials : [];

        $this->CI->layout->setPartialArea($partialArea);

        return $this;
    }

//    public function setView($view)
//    {
//        $this->overrideView = $view;
//
//        return $this;
//    }

//    public function setData($data)
//    {
//        $this->CI->load->vars($data);
//
////        $this->data = array_merge($this->data, $data);
//
//        return $this;
//    }

    public function setTitle($options = null)
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
        $this->pageButtons[] = '<a'.Html::attributes($attributes).'>'.$name.'</a>';
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
        $this->pageCrumbs[] = ['name' => $name, 'uri' => $uri, 'replace' => $replace];

        return $this;
    }

    //--------------------------------------------------------------------------
    // NAVIGATION
    //--------------------------------------------------------------------------

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
        return $this->CI->layout->findPartialArea($partialName);
    }

    /**
     * @deprecated since 2.2 use renderPartialArea instead
     *
     * @param string $view
     * @param array $replace
     *
     * @return mixed|string
     */
    public function get_partial($view = '', $replace = [])
    {
        return $this->renderPartialArea($view, $replace);
    }

    public function find_path($view = '')
    {
        if (!empty($this->themeCode)) {
            $themeCode = $this->themeCode;
            $parentThemeCode = $this->themeObj->parent;

            $locations = [
                app_path(app()->appContext().'/views'),
                app('path.themes'),
            ];

            $theme_views = ['/', '/_layouts/', '/_partials/'];
            foreach ($locations as $location) {
                foreach ($theme_views as $theme_view) {
                    $_view = (pathinfo($view, PATHINFO_EXTENSION)) ? $view : $view.'.php';

                    if (file_exists($path = $location.$theme_view.$_view)) {
                        return [File::localToPublic($path), $location];
                    }
                    else if (file_exists($path = $location.'/'.$themeCode.$theme_view.$_view)) {
                        return [File::localToPublic($path), $location];
                    }
                    else if (file_exists($path = $location.'/'.$parentThemeCode.$theme_view.$_view)) {
                        return [File::localToPublic($path), $location];
                    }
                }
            }
        }

        // Not found it yet?
        return [$view, null];
    }

    //--------------------------------------------------------------------------
    // VIEWS LOADER
    //--------------------------------------------------------------------------

    /**
     * @deprecated since 2.2 use TI_Loader::view instead
     *
     * @param $view
     * @param null $data
     *
     * @return object|string
     */
    public function load_view($view, $data = null)
    {
        return $this->CI->load->view($view, $data, TRUE);
    }

    /**
     * @deprecated since 2.2 use TI_Loader::partial instead
     *
     * @param $name
     * @param array $data
     *
     * @return null|object|string
     */
    public function partial($name, $data = [])
    {
        return $this->CI->load->partial($name, $data);
    }

    protected function loadPartialArea($partialArea, $partialVars)
    {
        if ($partialArea->content)
            return $this->CI->load->content($partialArea->content, $partialVars);

        $template = $partialArea->openTag;
        $template .= '{components}{component}{/components}';
        $template .= $partialArea->closeTag;

        return parse_values($partialVars, $template);
    }

    protected function loadComponent($layoutPartial, $component, $vars = [])
    {
        $componentHtml = $this->controller->renderComponent($component->alias, $vars);

        if (!$layoutPartial->componentHtml)
            return $componentHtml;

        $vars['componentId'] = $vars['id'] = $layoutPartial->getId('component');
        $vars['componentClass'] = $vars['class'] = implode(' ', $layoutPartial->componentClass);

        $isFixed = $component->property('fixed', 0);
        if ($isFixed AND $layoutPartial->affixHtml) {
            $vars['componentClass'] .= ' affix-module';
            $vars = array_merge($layoutPartial->getConfig(),
                $component->getProperties(), $vars, ['component' => $componentHtml]
            );

            $componentHtml = parse_values($vars, $layoutPartial->affixHtml);
        }

        $vars['component'] = $vars['module'] = $componentHtml;

        return parse_values($vars, $layoutPartial->componentHtml);
    }

    public function themeManager()
    {
        return $this->themeManager;
    }

    /**
     * @return \System\Libraries\Assets
     */
//    public function assetsManager()
//    {
//        return $this->assetsManager;
//    }

}