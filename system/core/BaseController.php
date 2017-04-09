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
 * Base Controller Class
 *
 * @category       Libraries
 * @package        Igniter\Core\BaseController.php
 * @link           http://docs.tastyigniter.com
 *
 * @property CI_DB_query_builder $db              This is the platform-independent base Active Record implementation class.
 * @property CI_DB_forge $dbforge                 Database Utility Class
 * @property Alert $alert                         Alert Class.
 * @property Assets $assets                       Assets Class.
 * @property Country $country                     Country Class.
 * @property Currency $currency                   Currency Class.
 * @property Customer $customer                   Customer Class.
 * @property CI_Benchmark $benchmark              This class enables you to mark points and calculate the time difference between them.<br />  Memory consumption can also be displayed.
 * @property TI_Calendar $calendar                This class enables the creation of calendars
 * @property TI_Cart $cart                        Shopping Cart Class
 * @property TI_Config $config                    This class contains functions that enable config files to be managed
 * @property BaseController $controller          This class contains the requested controller
 * @property TI_Email $email                      Permits email to be sent using Mail, Sendmail, or SMTP.
 * @property CI_Encrypt $encrypt                  Provides two-way keyed encoding using XOR Hashing and Mcrypt
 * @property TI_Exceptions $exceptions            Exceptions Class
 * @property TI_Form_validation $form_validation  Form Validation Class
 * @property CI_Ftp $ftp                          FTP Class
 * @property CI_Hooks $hooks                      //dead
 * @property CI_Image_lib $image_lib              Image Manipulation class
 * @property Installer $installer                 Installer Class.
 * @property CI_Input $input                      Pre-processes global input data for security
 * @property Location $location                   Location Class.
 * @property TI_Lang $lang                        Language Class
 * @property TI_Loader $load                      Loads views and files
 * @property CI_Log $log                          Logging Class
 * @property Media_manager $media_manager         Media_manager Class.
 * @property TI_Model $model                      TastyIgniter Model Class
 * @property CI_Output $output                    Responsible for sending final output to browser
 * @property Permalink $permalink                 Permalink Class.
 * @property TI_Pagination $pagination            Pagination Class
 * @property CI_Parser $parser                    Parses pseudo-variables contained in the specified template view,<br />replacing them with the data in the second param
 * @property TI_Profiler $profiler                This class enables you to display benchmark, query, and other data<br />in order to help with debugging and optimization.
 * @property TI_Router $router                    Parses URIs and determines routing
 * @property CI_Session $session                  Session Class
 * @property Template $template                   Template Class.
 * @property CI_Table $table                      HTML table generation<br />Lets you create tables manually or from database result objects, or arrays.
 * @property CI_Trackback $trackback              Trackback Sending/Receiving Class
 * @property CI_Typography $typography            Typography Class
 * @property CI_Unit_test $unit_test              Simple testing class
 * @property CI_Upload $upload                    File Uploading Class
 * @property CI_URI $uri                          Parses URIs and determines routing
 * @property CI_User_agent $user_agent            Identifies the platform, browser, robot, or mobile devise of the browsing agent
 * @property CI_Xmlrpc $xmlrpc                    XML-RPC request handler class
 * @property CI_Xmlrpcs $xmlrpcs                  XML-RPC server class
 * @property CI_Zip $zip                          Zip Compression Class
 * @property CI_Javascript $javascript            Javascript Class
 * @property CI_Jquery $jquery                    Jquery Class
 * @property CI_Utf8 $utf8                        Provides support for UTF-8 environments
 * @property CI_Security $security                Security Class, xss, csrf, etc...
 * @property CI_Driver_Library $driver            CodeIgniter Driver Library Class
 * @property CI_Cache $cache                      CodeIgniter Caching Class
 */
class BaseController extends MX_Controller
{
    use \Igniter\Traits\ExtendableTrait;

    /**
     * A list of controller behavours/traits to be implemented
     */
    protected $implement = [];

    /**
     * @var bool Determines if controller should detect system maintenance setting
     */
    protected static $showMaintenance = FALSE;

    /**
     * @var array A list of BaseWidget objects used on this page
     */
    public $widgets = [];

    /**
     * @var string Page controller being called.
     */
    protected $controller;

    /**
     * @var string Page method being called.
     */
    protected $method;

    /**
     * @var array Default methods which cannot be called as controller methods.
     */
    public $hiddenMethods = [];

    /**
     * @var array A list of models to be auto-loaded
     */
    protected $models = [];

    /**
     * @var array A list of libraries to be auto-loaded
     */
    protected $libraries = [];

    /**
     * @var array A list of helpers to be auto-loaded
     */
    protected $helpers = [];

    /**
     * @var array A list of languages to be auto-loaded
     */
    protected $languages = [];

    /**
     * Class constructor
     */
    public function __construct()
    {
        $this->extendableConstruct();
        $this->parentConstruct();

        // Show maintenance message if maintenance is enabled
        if (self::$showMaintenance === TRUE)
            $this->showMaintenance();

        // Make sure extensions are directed to the appropriate controller
        $this->redirectExtension();

        // Enable profiler for development environments.
        $this->showProfiler();

        // After-Controller Constructor Event
        Events::trigger('after_controller_constructor', $this->controller);

        log_message('info', 'Base Controller Class Initialized');
    }

    public function _remap($method)
    {
        // Initialize template library with controller
        $this->template->setController($this, $method);

        // Loads the requested controller method
        if (in_array(strtolower($method), array_map('strtolower', $this->hiddenMethods))) {
            $this->index();
        } else if (method_exists($this, $method)) {
            $this->$method();
        } else if ($this->methodExists($method)) {
            $this->extendableCall($method, array_slice(func_get_args(), 1));
        } else {
            show_404(strtolower($this->controller).'/'.$method);
        }
    }

    private function redirectExtension()
    {
        if (APPDIR === ADMINDIR AND $_module = $this->router->fetch_module()) {
            if ($_module AND strtolower($this->uri->rsegment(1)) != 'extensions') {
                redirect('extensions/'.$this->uri->uri_string());
            }
        }
    }

    public function showMaintenance()
    {
        // Check app for maintenance in production environments.
        if (ENVIRONMENT === 'production' AND $this->config->item('maintenance_mode') == '1') {
            $this->load->library('user');
            if ($this->uri->rsegment(1) !== 'maintenance' AND !$this->user->isLogged()) {
                show_error($this->config->item('maintenance_message'), '503', 'Maintenance Enabled');
            }
        }
    }

    public function showProfiler()
    {
        if (TI_DEBUG == TRUE AND !is_cli() AND !$this->input->is_ajax_request()) {
            if (!class_exists('Console', FALSE))
                $this->load->library('Console');

            $this->output->enable_profiler(TI_DEBUG);
        }
    }

    public function pageUrl($uri = null, $params = [])
    {
        return site_url($this->pageUri($uri, $params));
    }

    public function pageUri($uri = null, $params = [])
    {
        if (!empty($params)) {
            $uri = preg_replace_callback('/{(.*?)}/', function ($preg) use ($params) {
                $preg[1] = ($preg[1] == 'id' AND !isset($params[$preg[1]])) ? singular($this->controller).'_'.$preg[1] : $preg[1];

                return isset($params[$preg[1]]) ? $params[$preg[1]] : $preg[0];
            }, $uri);
        }

        return ($uri === null) ? $this->index_url : $uri;
    }

    public function setWidgets($widgets)
    {
    }

    public function redirect($uri = null)
    {
        redirect(($uri === null) ? $this->index_url : $uri);
    }

    public function setFilter($filter = '', $value = null)
    {
        if (!isset($this->filter['page'])) $this->filter['page'] = '';
        if (!isset($this->filter['limit'])) $this->filter['limit'] = $this->config->item('page_limit');
        $this->filter['order_by'] = (isset($this->default_sort[1])) ? $this->default_sort[1] : 'ASC';
        $this->filter['sort_by'] = (isset($this->default_sort[0])) ? $this->default_sort[0] : '';

        if (is_string($filter)) {
            $filter = [$filter => $value];
        }

        foreach (array_merge($this->filter, $filter) as $name => $value) {
            $this->filter[$name] = $this->input->get($name) !== null ? $this->input->get($name) : $value;
        }
    }

    public function getFilter($filter = null)
    {
        if ($filter === null) {
            return $this->filter;
        } else if ($filter AND $this->input->get($filter)) {
            return $this->input->get($filter);
        } else if (isset($this->filter[$filter])) {
            return $this->filter[$filter];
        } else {
            return null;
        }
    }

    public function setSort($sort = [])
    {
        if (is_array($this->sort)) {
            $order_by = (isset($this->filter['order_by']) AND $this->filter['order_by'] == 'ASC') ? 'DESC' : 'ASC';
            $this->sort['order_by_active'] = $order_by.' active';
            foreach (array_merge($this->sort, $sort) as $sort_by) {
                $url = array_merge(array_filter($this->input->get()), ['sort_by' => $sort_by, 'order_by' => $order_by]);
                if ((strpos($sort_by, '.') !== FALSE)) {
                    $sort_by = explode('.', $sort_by);
                    $sort_by = end($sort_by);
                }
                $this->sort['sort_'.$sort_by] = site_url($this->uri->uri_string().'?'.http_build_query($url));
            }
        }
    }

    protected function getSort($sort_by = null)
    {
        if ($sort_by === null) {
            return $this->sort;
        } else if (isset($this->sort[$sort_by])) {
            return $this->sort[$sort_by];
        } else if (isset($this->sort['sort_'.$sort_by])) {
            return $this->sort['sort_'.$sort_by];
        }
    }

    protected function parentConstruct()
    {
        CI::$APP->controller = $this;

        $class = str_replace(CI::$APP->config->item('controller_suffix'), '', get_class($this));
        Events::trigger('before_controller', $class);

        Modules::$registry[strtolower($class)] = $this;

        /* copy a loader instance and initialize */
        $this->load = clone load_class('Loader');  // @todo: is cloning required?
        $this->load->initialize($this);

        // Handle any auto-loading here...
        $this->autoload = [
            'libraries' => $this->libraries,
            'helper' => $this->helpers,
            'language' => $this->languages,
            'model'    => $this->models,
        ];

        /* autoload module items */
        $this->load->_autoloader($this->autoload);

        $this->controller = strtolower($this->router->class);
        $this->method = $this->router->method;
    }

    public function __get($className)
    {
        if (isset(CI::$APP->$className))
            return CI::$APP->$className;

        return $this->extendableGet($className);
    }

    public function __set($name, $value)
    {
        $this->extendableSet($name, $value);
    }

    public function __call($name, $params)
    {
        return $this->extendableCall($name, $params);
    }

    public static function __callStatic($name, $params)
    {
        return self::extendableCallStatic($name, $params);
    }

    public static function extend(callable $callback)
    {
        self::extendableExtendCallback($callback);
    }
}

/* End of file BaseController.php */
/* Location: ./system/tastyigniter/core/BaseController.php */
