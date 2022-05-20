<?php

namespace Main\Classes;

use Admin\Facades\AdminAuth;
use Exception;
use Igniter\Flame\Exception\AjaxException;
use Igniter\Flame\Exception\ApplicationException;
use Igniter\Flame\Exception\SystemException;
use Igniter\Flame\Exception\ValidationException;
use Igniter\Flame\Flash\Facades\Flash;
use Igniter\Flame\Pagic\Cache\FileSystem;
use Igniter\Flame\Pagic\Environment;
use Igniter\Flame\Pagic\Parsers\FileParser;
use Igniter\Flame\Traits\EventEmitter;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Main\Components\BlankComponent;
use Main\Template\ComponentPartial;
use Main\Template\Content;
use Main\Template\Extension\BladeExtension as MainBladeExtension;
use Main\Template\Layout as LayoutTemplate;
use Main\Template\Loader;
use Main\Template\Partial;
use System\Classes\BaseComponent;
use System\Classes\BaseController;
use System\Classes\ComponentManager;
use System\Helpers\ViewHelper;
use System\Models\Request_logs_model;
use System\Template\Extension\BladeExtension as SystemBladeExtension;
use System\Traits\AssetMaker;
use System\Traits\VerifiesCsrfToken;

/**
 * Main Controller Class
 */
class MainController extends BaseController
{
    use AssetMaker;
    use EventEmitter;
    use VerifiesCsrfToken;

    /**
     * @var \Main\Classes\Theme The main theme processed by the controller.
     */
    protected $theme;

    /**
     * @var \Main\Classes\Router The Router object.
     */
    protected $router;

    /**
     * @var \Main\Template\Loader The template loader.
     */
    protected $loader;

    /**
     * @var \Igniter\Flame\Pagic\Environment The template environment object.
     */
    protected $template;

    /**
     * @var \Main\Template\Code\LayoutCode The template object used by the layout.
     */
    protected $layoutObj;

    /**
     * @var \Main\Template\Code\PageCode The template object used by the page.
     */
    protected $pageObj;

    /**
     * @var \Main\Template\Layout The main layout template used by the page.
     */
    protected $layout;

    /**
     * @var \Main\Template\Page The main page template being processed.
     */
    protected $page;

    /**
     * @var self Cache of this controller
     */
    protected static $controller;

    /**
     * @var string Contains the rendered page contents string.
     */
    protected $pageContents;

    /**
     * @var array A list of variables to pass to the page.
     */
    public $vars = [];

    /**
     * @var array A list of BaseComponent objects used on this page
     */
    public $components = [];

    /**
     * @var \System\Classes\BaseComponent Object of the active component, used internally.
     */
    protected $componentContext;

    /**
     * @var bool Prevents the automatic view display.
     */
    public $suppressView = false;

    /**
     * @var array Default actions which cannot be called as actions.
     */
    public $hiddenActions = [
        'pageAction',
        'pageCycle',
        'handleError',
    ];

    /**
     * @var string Body class property used for customising the layout on a controller basis.
     */
    public $bodyClass;

    /**
     * Class constructor
     *
     * @param null $theme
     *
     * @throws \Igniter\Flame\Exception\ApplicationException
     */
    public function __construct($theme = null)
    {
        $this->theme = $theme ?: ThemeManager::instance()->getActiveTheme();
        if (!$this->theme)
            throw new ApplicationException(Lang::get('main::lang.not_found.active_theme'));

        $this->theme->loadThemeFile();

        $this->assetPath[] = $this->theme->getPath().'/assets';
        if ($this->theme->hasParent())
            $this->assetPath[] = $this->theme->getParentPath().'/assets';

        parent::__construct();

        $this->theme->loadThemeFile();

        $this->router = new Router($this->theme);

        $this->initTemplateEnvironment();

        // @deprecated This event will be deprecated soon, use controller.beforeRemap
        $this->fireEvent('controller.afterConstructor', [$this]);

        self::$controller = $this;
    }

    public function remap($url = null)
    {
        $this->fireSystemEvent('main.controller.beforeRemap');

        if ($url === null)
            $url = Request::path();

        if (!strlen($url))
            $url = '/';

        $page = $this->router->findByUrl($url);

        // Show maintenance message if maintenance is enabled
        if (setting('maintenance_mode') == 1 && !AdminAuth::isLogged())
            return Response::make(
                View::make('main::maintenance', ['message' => setting('maintenance_message')]),
                $this->statusCode
            );

        // If the page was not found,
        // render the 404 page - either provided by the theme or the built-in one.
        if (!$page || $url === '404') {
            if (!Request::ajax())
                $this->setStatusCode(404);

            // Log the 404 request
            if (!App::runningUnitTests())
                Request_logs_model::createLog(404);

            if (!$page = $this->router->findByUrl('/404'))
                return Response::make(View::make('main::404'), $this->statusCode);
        }

        // Loads the requested controller action
        $output = $this->runPage($page);

        // Extensibility
        if ($event = $this->fireEvent('controller.beforeResponse', [$url, $page, $output])) {
            return $event;
        }

        if (!is_string($output)) {
            return $output;
        }

        return Response::make($output, $this->statusCode);
    }

    public function runPage($page)
    {
        $this->page = $page;

        if (!$page->layout) {
            $layout = LayoutTemplate::initFallback($this->theme);
        }
        elseif (($layout = LayoutTemplate::loadCached($this->theme, $page->layout)) === null) {
            throw new ApplicationException(sprintf(
                Lang::get('main::lang.not_found.layout_name'), $page->layout
            ));
        }

        $this->layout = $layout;

        // The 'this' variable is reserved for default variables.
        $this->vars['this'] = [
            'page' => $this->page,
            'layout' => $this->layout,
            'theme' => $this->theme,
            'param' => $this->router->getParameters(),
            'controller' => $this,
            'session' => App::make('session'),
        ];

        // Initializes the custom layout and page objects.
        $this->initTemplateObjects();

        // Attach layout components matching the current URI segments
        $this->initializeComponents();

        // Give the layout and page an opportunity to participate
        // after components are initialized and before AJAX is handled.
        if ($this->layoutObj) {
            $this->layoutObj->onInit();
        }

        $this->pageObj->onInit();

        // Extensibility
        if ($event = $this->fireSystemEvent('main.page.init', [$page])) {
            return $event;
        }

        // Execute post handler and AJAX event
        if (($ajaxResponse = $this->processHandlers()) && $ajaxResponse !== true) {
            return $ajaxResponse;
        }

        // Loads the requested controller action
        if ($pageResponse = $this->execPageCycle()) {
            return $pageResponse;
        }

        if ($event = $this->fireSystemEvent('main.page.beforeRenderPage', [$page])) {
            $this->pageContents = $event;
        }
        else {
            // Render the page
            $this->loader->setSource($this->page);
            $template = $this->template->load($this->page->getFilePath());
            $this->pageContents = $template->render($this->vars);
        }

        // Render the layout
        $this->loader->setSource($this->layout);
        $template = $this->template->load($this->layout->getFilePath());

        return $template->render($this->vars);
    }

    /**
     * Invokes the current page cycle without rendering the page,
     * used by AJAX handler that may rely on the logic inside the action.
     */
    public function pageCycle()
    {
        return $this->execPageCycle();
    }

    protected function execPageCycle()
    {
        if ($event = $this->fireSystemEvent('main.page.start'))
            return $event;

        // Run layout functions
        if ($this->layoutObj) {
            // Let the layout do stuff after components are initialized and before AJAX is handled.
            $response = (
                ($result = $this->layoutObj->onStart()) ||
                ($result = $this->layout->runComponents())
            ) ? $result : null;

            if ($response) {
                return $response;
            }
        }

        // Run page functions
        $response = (
            ($result = $this->pageObj->onStart()) ||
            ($result = $this->page->runComponents()) ||
            ($result = $this->pageObj->onEnd())
        ) ? $result : null;

        if ($response) {
            return $response;
        }

        // Run remaining layout functions
        if ($this->layoutObj) {
            $response = ($result = $this->layoutObj->onEnd()) ? $result : null;
        }

        // Extensibility
        if ($event = $this->fireSystemEvent('main.page.end')) {
            return $event;
        }

        return $response;
    }

    //
    //
    //

    /**
     * Returns the AJAX handler for the current request, if available.
     * @return string
     */
    public function getHandler()
    {
        if (Request::ajax() && $handler = Request::header('X-IGNITER-REQUEST-HANDLER'))
            return trim($handler);

        if ($handler = post('_handler'))
            return trim($handler);

        return null;
    }

    protected function processHandlers()
    {
        if (!$handler = $this->getHandler())
            return false;

        if (!$this->verifyCsrfToken())
            return false;

        try {
            $this->validateHandler($handler);

            $partials = $this->validateHandlerPartials();

            $response = [];

            // Process Components handler
            if (!$result = $this->runHandler($handler)) {
                throw new ApplicationException(sprintf(Lang::get('main::lang.not_found.ajax_handler'), $handler));
            }

            foreach ($partials as $partial) {
                $response[$partial] = $this->renderPartial($partial);
            }

            if ($result instanceof RedirectResponse) {
                $response['X_IGNITER_REDIRECT'] = $result->getTargetUrl();
                $result = null;
            }
            elseif (Request::header('X-IGNITER-REQUEST-FLASH') && Flash::messages()->isNotEmpty()) {
                $response['X_IGNITER_FLASH_MESSAGES'] = Flash::all();
            }

            if (is_array($result)) {
                $response = array_merge($response, $result);
            }
            elseif (is_string($result)) {
                $response['result'] = $result;
            }
            elseif (is_object($result)) {
                return $result;
            }

            return Response::make($response, $this->statusCode);
        }
        catch (ValidationException $ex) {
            $response['X_IGNITER_ERROR_FIELDS'] = $ex->getFields();
            $response['X_IGNITER_ERROR_MESSAGE'] = $ex->getMessage();
            throw new AjaxException($response);
        }
        catch (Exception $ex) {
            throw $ex;
        }
    }

    protected function runHandler($handler)
    {
        if (strpos($handler, '::')) {
            [$componentName, $handlerName] = explode('::', $handler);

            $componentObj = $this->findComponentByAlias($componentName);

            if ($componentObj && $componentObj->methodExists($handlerName)) {
                $this->componentContext = $componentObj;
                $result = $componentObj->runEventHandler($handlerName);

                return $result ?: true;
            }
        } // Process page specific handler (index_onSomething)
        else {
            $pageHandler = $this->action.'_'.$handler;
            if ($this->methodExists($pageHandler)) {
                $result = call_user_func_array([$this, $pageHandler], array_values($this->params));

                return $result ?: true;
            }

            if (($componentObj = $this->findComponentByHandler($handler)) !== null) {
                $this->componentContext = $componentObj;
                $result = $componentObj->runEventHandler($handler);

                return $result ?: true;
            }
        }

        return false;
    }

    protected function validateHandler($handler)
    {
        if (!preg_match('/^(?:\w+\:{2})?on[A-Z]{1}[\w+]*$/', $handler)) {
            throw new SystemException("Invalid ajax handler name: {$handler}");
        }
    }

    protected function validateHandlerPartials()
    {
        if (!$partials = trim(Request::header('X-IGNITER-REQUEST-PARTIALS')))
            return [];

        $partials = explode('&', $partials);

        foreach ($partials as $partial) {
            if (!preg_match('/^(?:\w+\:{2}|@)?[a-z0-9\_\-\.\/]+$/i', $partial)) {
                throw new SystemException("Invalid partial name: $partial");
            }
        }

        return $partials;
    }

    //
    // Getters
    //

    /**
     * Returns an existing instance of the controller.
     * If the controller doesn't exists, returns null.
     * @return self Returns the controller object or null.
     */
    public static function getController()
    {
        return self::$controller;
    }

    /**
     * Returns the Layout object being processed by the controller.
     * @return \Main\Template\Code\LayoutCode Returns the Layout object or null.
     */
    public function getLayoutObj()
    {
        return $this->layoutObj;
    }

    /**
     * Returns the current theme.
     * @return \Main\Classes\Theme
     */
    public function getTheme()
    {
        return $this->theme;
    }

    /**
     * Returns the routing object.
     * @return \Main\Classes\Router
     */
    public function getRouter()
    {
        return $this->router;
    }

    /**
     * Returns the template page object being processed by the controller.
     * The object is not available on the early stages of the controller
     * initialization.
     * @return \Main\Template\Page Returns the Page object or null.
     */
    public function getPage()
    {
        return $this->page;
    }

    //
    // Initialization
    //

    /**
     * Initializes the Template environment and loader.
     * @return void
     */
    protected function initTemplateEnvironment()
    {
        $this->loader = new Loader;

        $options = [
            'auto_reload' => true,
            'cache' => true,
            'templateClass' => 'Main\\Classes\\Template',
            'debug' => Config::get('app.debug', false),
        ];

        $useCache = true;
        if ($useCache) {
            $options['cache'] = new FileSystem(config('view.compiled'));
        }

        $this->template = new Environment($this->loader, $options);
        $this->template->addExtension(new MainBladeExtension);
        $this->template->addExtension(new SystemBladeExtension);
    }

    public function initTemplateObjects()
    {
        $parser = FileParser::on($this->layout);
        $this->layoutObj = $parser->source($this->page, $this->layout, $this);

        $parser = FileParser::on($this->page);
        $this->pageObj = $parser->source($this->page, $this->layout, $this);
    }

    protected function initializeComponents()
    {
        foreach ($this->layout->settings['components'] as $component => $properties) {
            [$name, $alias] = strpos($component, ' ')
                ? explode(' ', $component)
                : [$component, $component];

            $this->addComponent($name, $alias, $properties, true);
        }

        foreach ($this->page->settings['components'] as $component => $properties) {
            [$name, $alias] = strpos($component, ' ')
                ? explode(' ', $component)
                : [$component, $component];

            $this->addComponent($name, $alias, $properties);
        }

        // Extensibility
        $this->fireSystemEvent('main.layout.initializeComponents', [$this->layoutObj]);
    }

    //
    // Rendering
    //

    /**
     * Renders a requested page.
     * The framework uses this method internally.
     */
    public function renderPage()
    {
        $contents = $this->pageContents;

        // Extensibility
        if ($event = $this->fireSystemEvent('main.page.render', [$contents]))
            return $event;

        return $contents;
    }

    public function renderPartial($name, array $params = [], $throwException = true)
    {
        // Cache variables
        $vars = $this->vars;
        $this->vars = array_merge($this->vars, $params);

        // Alias @ symbol for ::
        if (strpos($name, '@') === 0) {
            $name = '::'.substr($name, 1);
        }

        // Extensibility
        if ($event = $this->fireSystemEvent('main.page.beforeRenderPartial', [$name])) {
            $partial = $event;
        }
        // Process Component partial
        elseif (strpos($name, '::') !== false) {
            if (($partial = $this->loadComponentPartial($name, $throwException)) === false)
                return false;

            // Set context for self access
            $this->vars['__SELF__'] = $this->componentContext;
        }
        // Process theme partial
        elseif (($partial = $this->loadPartial($name, $throwException)) === false) {
            return false;
        }

        // Render the partial
        $this->loader->setSource($partial);
        $template = $this->template->load($partial->getFilePath());
        $partialContent = $template->render($this->vars);

        // Restore variables
        $this->vars = $vars;

        // Extensibility
        if ($event = $this->fireSystemEvent('main.page.renderPartial', [$name, &$partialContent]))
            return $event;

        return $partialContent;
    }

    /**
     * Renders a requested content file.
     *
     * @param string $name The content view to load.
     * @param array $params Parameter variables to pass to the view.
     *
     * @return string
     * @throws \Igniter\Flame\Exception\ApplicationException
     */
    public function renderContent($name, array $params = [])
    {
        // Extensibility
        if ($event = $this->fireSystemEvent('main.page.beforeRenderContent', [$name])) {
            $content = $event;
        }
        // Load content from theme
        elseif (($content = Content::loadCached($this->theme, $name)) === null) {
            throw new ApplicationException(sprintf(
                Lang::get('main::lang.not_found.content'), $name
            ));
        }

        $fileContent = $content->getMarkup();

        // Inject global view variables
        $globalVars = ViewHelper::getGlobalVars();
        if (!empty($globalVars)) {
            $params += $globalVars;
        }

        // Parse basic template variables
        if (!empty($params)) {
            $fileContent = parse_values($params, $fileContent);
        }

        // Extensibility
        if ($event = $this->fireSystemEvent('main.page.renderContent', [$name, &$fileContent])) {
            return $event;
        }

        return $fileContent;
    }

    /**
     * Renders a requested component default partial.
     * This method is used internally.
     *
     * @param string $name The component to load.
     * @param array $params Parameter variables to pass to the view.
     * @param bool $throwException Throw an exception if the partial is not found.
     *
     * @return mixed Partial contents or false if not throwing an exception.
     * @throws \Igniter\Flame\Exception\ApplicationException
     */
    public function renderComponent($name, array $params = [], $throwException = true)
    {
        $previousContext = $this->componentContext;
        if (!$componentObj = $this->findComponentByAlias($name)) {
            $this->handleException(sprintf(lang('main::lang.not_found.component'), $name), $throwException);

            return false;
        }

        $componentObj->id = uniqid($name);
        $this->componentContext = $componentObj;
        $componentObj->setProperties(array_merge($componentObj->getProperties(), $params));
        if ($result = $componentObj->onRender()) {
            return $result;
        }

        $result = $this->renderPartial($name.'::'.$componentObj->defaultPartial, [], false);
        $this->componentContext = $previousContext;

        return $result;
    }

    //
    // Component helpers
    //

    /**
     * Adds a component to the layout object
     *
     * @param mixed $name Component class name or short name
     * @param string $alias Alias to give the component
     * @param array $properties Component properties
     * @param bool $addToLayout
     *
     * @return \System\Classes\BaseComponent Component object
     * @throws \Exception
     */
    public function addComponent($name, $alias, $properties = [], $addToLayout = false)
    {
        $codeObj = $addToLayout ? $this->layoutObj : $this->pageObj;
        $templateObj = $addToLayout ? $this->layout : $this->page;

        $manager = ComponentManager::instance();
        $componentObj = $manager->makeComponent($name, $codeObj, $properties);

        $componentObj->alias = $alias;
        $this->vars[$alias] = $componentObj;
        $templateObj->components[$alias] = $componentObj;

        $componentObj->initialize();

        return $componentObj;
    }

    public function hasComponent($alias)
    {
        if (!$componentObj = $this->findComponentByAlias($alias))
            return false;

        if ($componentObj instanceof BlankComponent)
            return false;

        return true;
    }

    /**
     * Searches the layout components by an alias
     *
     * @param $alias
     *
     * @return \System\Classes\BaseComponent The component object, if found
     */
    public function findComponentByAlias($alias)
    {
        if (isset($this->page->components[$alias]))
            return $this->page->components[$alias];

        if (isset($this->layout->components[$alias]))
            return $this->layout->components[$alias];

        return null;
    }

    /**
     * Searches the layout components by an AJAX handler
     *
     * @param string $handler
     *
     * @return \System\Classes\BaseComponent The component object, if found
     */
    public function findComponentByHandler($handler)
    {
        foreach ($this->layout->components as $component) {
            if ($component->methodExists($handler)) {
                return $component;
            }
        }

        return null;
    }

    /**
     * Searches the layout and page components by a partial file
     *
     * @param string $partial
     *
     * @return \System\Classes\BaseComponent The component object, if found
     */
    public function findComponentByPartial($partial)
    {
        foreach ($this->page->components as $component) {
            if (ComponentPartial::check($component, $partial)) {
                return $component;
            }
        }

        foreach ($this->layout->components as $component) {
            if (ComponentPartial::check($component, $partial)) {
                return $component;
            }
        }

        return null;
    }

    public function setComponentContext(BaseComponent $component = null)
    {
        $this->componentContext = $component;
    }

    protected function loadComponentPartial($name, $throwException = true)
    {
        [$componentAlias, $partialName] = explode('::', $name);

        // Component alias not supplied
        if (!strlen($componentAlias)) {
            if (!is_null($this->componentContext)) {
                $componentObj = $this->componentContext;
            }
            elseif (($componentObj = $this->findComponentByPartial($partialName)) === null) {
                $this->handleException(sprintf(lang('main::lang.not_found.partial'), $partialName), $throwException);

                return false;
            }
        }
        elseif (($componentObj = $this->findComponentByAlias($componentAlias)) === null) {
            $this->handleException(sprintf(lang('main::lang.not_found.component'), $componentAlias), $throwException);

            return false;
        }

        $partial = null;
        $this->componentContext = $componentObj;

        // Check if the theme has an override
        if (strpos($partialName, '/') === false) {
            $partial = ComponentPartial::loadOverrideCached($this->theme, $componentObj, $partialName);
        }

        // Check the component partial
        if ($partial === null)
            $partial = ComponentPartial::loadCached($componentObj, $partialName);

        if ($partial === null) {
            $this->handleException(sprintf(lang('main::lang.not_found.partial'), $name), $throwException);

            return false;
        }

        return $partial;
    }

    protected function loadPartial($name, $throwException = true)
    {
        if (($partial = Partial::loadCached($this->theme, $name)) === null) {
            $this->handleException(sprintf(lang('main::lang.not_found.partial'), $name), $throwException);

            return false;
        }

        return $partial;
    }

    //
    // Helpers
    //

    public function url($path = null, $params = [])
    {
        if (is_null($path))
            return $this->currentPageUrl($params);

        if (!$url = $this->router->findByFile($path, $params))
            $url = $path;

        return URL::to($url);
    }

    public function pageUrl($path = null, $params = [])
    {
        $params = array_merge($this->router->getParameters(), $params);

        if (!is_array($params))
            $params = [];

        if (in_array($path, [setting('reservation_page'), setting('menus_page')]))
            $params = $this->bindLocationRouteParameter($params);

        return $this->url($path, $params);
    }

    public function currentPageUrl($params = [])
    {
        $params = array_merge($this->router->getParameters(), $params);

        return $this->pageUrl($this->page->getFileName(), $params);
    }

    public function themeUrl($url = null)
    {
        $themeDir = $this->getTheme()->getDirName();

        $path = Config::get('system.themesDir', '/themes').'/'.$themeDir;

        return URL::asset(($url !== null) ? $path.'/'.$url : $path);
    }

    public function param($name, $default = null)
    {
        return $this->router->getParameter($name, $default);
    }

    public function refresh()
    {
        return Redirect::back();
    }

    public function redirect($path, $status = 302, $headers = [], $secure = null)
    {
        return Redirect::to($path, $status, $headers, $secure);
    }

    public function redirectGuest($path, $status = 302, $headers = [], $secure = null)
    {
        return Redirect::guest($path, $status, $headers, $secure);
    }

    public function redirectIntended($path, $status = 302, $headers = [], $secure = null)
    {
        return Redirect::intended($path, $status, $headers, $secure);
    }

    public function redirectBack()
    {
        return Redirect::back();
    }

    protected function handleException($message, $throwException)
    {
        if ($throwException)
            throw new ApplicationException($message);

        flash()->danger($message);
    }

    protected function bindLocationRouteParameter($params)
    {
        if (!App::bound('location'))
            return $params;

        if (isset($params['location']))
            return $params;

        if (!$location = App::make('location')->current())
            $location = App::make('location')->getDefault();

        $params['location'] = $location ? $location->permalink_slug : null;

        return $params;
    }
}
