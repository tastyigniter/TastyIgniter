<?php namespace System\Classes;

use App;
use Assets;
use Closure;
use Exception;
use File;
use Igniter\Flame\Support\RouterHelper;
use Igniter\Flame\Traits\ExtendableTrait;
use Illuminate\Routing\Controller as IlluminateController;
use Response;
use View;

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
 * @package System
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

    public function __construct()
    {
//        $this->extendableConstruct();
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
            return Response::make(View::make('system::no_database'), 200);
        }

        return App::make('Main\Classes\MainController')->remap($url);
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
        $segments = RouterHelper::segmentizeUrl($url);

        if (!App::hasDatabase()) {
            return Response::make(View::make('system::no_database'), 200);
        }

        // Look for a controller within app/admin & app/system
        $controller = $segments[0] ?? 'dashboard';
        self::$action = $action = isset($segments[1]) ? $this->processAction($segments[1]) : 'index';
        self::$segments = $params = array_slice($segments, 2);
        if ($controllerObj = $this->locateController(
            $controller,
            ['admin' => 'Admin', 'system' => 'System'],
            app_path()
        )) {
            return $controllerObj->remap($action, $params);
        }

        // Look for a controller within extensions
        if (count($segments) >= 3) {
            list($author, $extension, $controller) = $segments;
            self::$action = $action = isset($segments[3]) ? $this->processAction($segments[3]) : 'index';
            self::$segments = $params = array_slice($segments, 4);

            if ($controllerObj = $this->locateController(
                $controller,
                ["{$author}/{$extension}" => "{$author}\\{$extension}"],
                extension_path()
            )) {
                return $controllerObj->remap($action, $params);
            }
        }

        return App::make('Main\Classes\MainController')->remap($url);
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
    protected function locateController($controller, $modules, $inPath)
    {
        is_array($modules) OR $modules = [$modules];

        $controllerClass = null;
        $matchPath = $inPath.'/%s/controllers/%s.php';
        foreach ($modules as $module => $namespace) {
            $controller = strtolower(str_replace(['\\', '_'], ['/', ''], $controller));
            if ($controllerFile = File::existsInsensitive(sprintf($matchPath, $module, $controller))) {
                if (!class_exists($controllerClass = '\\'.$namespace.'\Controllers\\'.$controller))
                    include_once $controllerFile;
            }
        }

        if (!$controllerClass OR !class_exists($controllerClass))
            return FALSE;

        $controllerObj = App::make($controllerClass);

        $action = self::$action;
        if ($controllerObj->checkAction($action)) {
            return $controllerObj;
        }

        return FALSE;
    }

    /**
     * Process the action name, since dashes are not supported in PHP methods.
     *
     * @param  string $actionName
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
}
