<?php

namespace System\Classes;

use Closure;
use Exception;
use Igniter\Flame\Support\Facades\File;
use Igniter\Flame\Support\RouterHelper;
use Igniter\Flame\Traits\ExtendableTrait;
use Illuminate\Routing\Controller as IlluminateController;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;
use System\Facades\Assets;

/**
 * This is the base controller for all pages.
 * All requests that are prefixed with the admin URI pattern
 * OR have not been handled by the router are sent here,
 * then the URL is passed to the app controller for processing.
 * For example,
 * Request URI              Find Controller In
 * /admin/(any)             `admin`, `location` or `system` app directory
 * /admin/acme/cod/(any)    `Acme.Cod` extension
 * /(any)                   `main` app directory
 * @see \Admin\Classes\AdminController|\Main\Classes\MainController  controller class
 */
class Controller extends IlluminateController
{
    use ExtendableTrait;

    /**
     * @var array Actions implemented by this controller.
     */
    public $implement;

    public static $class;

    /**
     * @var string Allows early access to page action.
     */
    public static $action;

    /**
     * @var array Allows early access to page URI segments.
     */
    public static $segments;

    /**
     * Stores the requested controller so that the constructor is only run once
     *
     * @var array|null
     */
    protected $requestedCache;

    public function __construct()
    {
        $this->extendableConstruct();
    }

    /**
     * Get the middleware assigned to the controller.
     *
     * @return array
     */
    public function getMiddleware()
    {
        $this->pushRequestedControllerMiddleware();

        return $this->middleware;
    }

    /**
     * Extend this object properties upon construction.
     *
     * @param Closure $callback
     */
    public static function extend(Closure $callback)
    {
        self::extendableExtendCallback($callback);
    }

    /**
     * Finds and serves the request using the main controller.
     *
     * @param string $url Specifies the requested page URL.
     *
     * @return string Returns the processed page content.
     */
    public function run($url = '/')
    {
        if (!App::hasDatabase()) {
            return Response::make(View::make('system::no_database'));
        }

        return App::make(\Main\Classes\MainController::class)->remap($url);
    }

    /**
     * Finds and serves the request using the admin controller.
     *
     * @param string $url Specifies the requested page URL.
     * If the parameter is omitted, the dashboard URL used.
     *
     * @return string Returns the processed page content.
     */
    public function runAdmin($url = '/')
    {
        if (!App::hasDatabase()) {
            return Response::make(View::make('system::no_database'));
        }

        if ($result = $this->locateController($url)) {
            $result['controller']->initialize();

            return $result['controller']->remap($result['action'], $result['segments']);
        }

        return Response::make(View::make('main::404'), 404);
    }

    /**
     * Combines JavaScript and StyleSheet assets.
     *
     * @param string $asset
     *
     * @return string
     */
    public function combineAssets($asset)
    {
        try {
            $parts = explode('-', $asset);
            $cacheKey = $parts[0];

            return Assets::combineGetContents($cacheKey);
        }
        catch (Exception $ex) {
            $errorMessage = ErrorHandler::getDetailedMessage($ex);

            return '/* '.e($errorMessage).' */';
        }
    }

    protected function locateController($url)
    {
        if (isset($this->requestedCache))
            return $this->requestedCache;

        $segments = RouterHelper::segmentizeUrl($url);

        // Look for a controller within the /app directory
        if (!$result = $this->locateControllerInApp($segments)) {
            // Look for a controller within the /extensions directory
            $result = $this->locateControllerInExtensions($segments);
        }

        return $this->requestedCache = $result;
    }

    /**
     * This method is used internally.
     * Finds a controller with a callable action method.
     *
     * @param string $controller Specifies a controller name to locate.
     * @param string|array $modules Specifies a list of modules to look in.
     * @param string $inPath Base path to search the class file.
     *
     * @return bool|\Admin\Classes\AdminController|\Main\Classes\MainController
     * Returns the backend controller object
     */
    protected function locateControllerInPath($controller, $modules, $inPath)
    {
        is_array($modules) || $modules = [$modules];

        $controllerClass = null;
        $matchPath = $inPath.'/%s/controllers/%s.php';
        foreach ($modules as $module => $namespace) {
            $controller = strtolower(str_replace(['\\', '_'], ['/', ''], $controller));
            $controllerFile = File::existsInsensitive(sprintf($matchPath, $module, $controller));
            if ($controllerFile && !class_exists($controllerClass = '\\'.$namespace.'\Controllers\\'.$controller))
                include_once $controllerFile;
        }

        if (!$controllerClass || !class_exists($controllerClass))
            return null;

        $controllerObj = App::make($controllerClass);

        if ($controllerObj->checkAction(self::$action)) {
            return $controllerObj;
        }

        return FALSE;
    }

    /**
     * Process the action name, since dashes are not supported in PHP methods.
     *
     * @param string $actionName
     *
     * @return string
     */
    protected function processAction($actionName)
    {
        if (strpos($actionName, '-') !== FALSE) {
            return camel_case($actionName);
        }

        return $actionName;
    }

    protected function locateControllerInApp(array $segments)
    {
        $modules = [];
        foreach (Config::get('system.modules') as $module) {
            $modules[strtolower($module)] = $module;
        }

        $controller = $segments[0] ?? 'dashboard';
        self::$action = $action = isset($segments[1]) ? $this->processAction($segments[1]) : 'index';
        self::$segments = $segments = array_slice($segments, 2);
        if ($controllerObj = $this->locateControllerInPath($controller, $modules, app_path())) {
            return [
                'controller' => $controllerObj,
                'action' => $action,
                'segments' => $segments,
            ];
        }
    }

    protected function locateControllerInExtensions($segments)
    {
        if (count($segments) >= 3) {
            [$author, $extension, $controller] = $segments;
            self::$action = $action = isset($segments[3]) ? $this->processAction($segments[3]) : 'index';
            self::$segments = $segments = array_slice($segments, 4);

            $extensionCode = sprintf('%s.%s', $author, $extension);
            if (ExtensionManager::instance()->isDisabled($extensionCode))
                return;

            if ($controllerObj = $this->locateControllerInPath(
                $controller,
                ["{$author}/{$extension}" => "{$author}\\{$extension}"],
                extension_path()
            )) {
                return [
                    'controller' => $controllerObj,
                    'action' => $action,
                    'segments' => $segments,
                ];
            }
        }
    }

    protected function pushRequestedControllerMiddleware()
    {
        if (!App::runningInAdmin())
            return;

        $pathParts = explode('/', request()->path());
        if (Config::get('system.adminUri', 'admin'))
            array_shift($pathParts);

        $path = implode('/', $pathParts);
        if ($result = $this->locateController($path)) {
            // Collect controller middleware and insert middleware into pipeline
            collect($result['controller']->getMiddleware())->each(function ($data) {
                $this->middleware($data['middleware'], $data['options']);
            });
        }
    }
}
