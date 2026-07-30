<?php

declare(strict_types=1);

namespace Igniter\System\Classes;

use Closure;
use Igniter\Admin\Classes\AdminController;
use Igniter\Flame\Support\Facades\Igniter;
use Igniter\Flame\Support\RouterHelper;
use Igniter\Flame\Traits\ExtendableTrait;
use Igniter\Main\Classes\MainController;
use Igniter\System\Facades\Assets;
use Illuminate\Routing\Controller as IlluminateController;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;
use Override;

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
 * @see AdminController|MainController  controller class
 * @deprecated No longer used, will be removed in v5.0.0
 * @codeCoverageIgnore
 */
class Controller extends IlluminateController
{
    use ExtendableTrait;

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
    #[Override]
    public function getMiddleware()
    {
        $this->pushRequestedControllerMiddleware();

        return $this->middleware;
    }

    /**
     * Extend this object properties upon construction.
     */
    public static function extend(Closure $callback): void
    {
        self::extendableExtendCallback($callback);
    }

    /**
     * Finds and serves the request using the main controller.
     *
     * @param string $url Specifies the requested page URL.
     *
     * @return string|\Illuminate\Http\Response Returns the processed page content.
     */
    public function run($url = '/')
    {
        if (!Igniter::hasDatabase()) {
            return Response::make(View::make('igniter.system::no_database'));
        }

        return App::make(MainController::class)->remap($url);
    }

    /**
     * Finds and serves the request using the admin controller.
     *
     * @param string $url Specifies the requested page URL.
     * If the parameter is omitted, the dashboard URL used.
     *
     * @return string|\Illuminate\Http\Response Returns the processed page content.
     */
    public function runAdmin($url = '/')
    {
        if (!Igniter::hasDatabase()) {
            return Response::make(View::make('igniter.system::no_database'));
        }

        if ($result = $this->locateController($url)) {
            return $result['controller']->initialize()->remap($result['action'], $result['segments']);
        }

        return App::make(AdminController::class)->initialize()->remap('404', []);
    }

    /**
     * Combines JavaScript and StyleSheet assets.
     *
     * @param string $asset
     *
     * @return \Illuminate\Http\Response
     */
    public function combineAssets($asset)
    {
        $parts = explode('-', $asset);
        $cacheKey = $parts[0];

        return Assets::combineGetContents($cacheKey);
    }

    protected function locateController($url)
    {
        if (isset($this->requestedCache)) {
            return $this->requestedCache;
        }

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
     *
     * @return null|AdminController|MainController Returns the controller object if found, otherwise false.
     */
    protected function locateControllerInPath($controller, $modules)
    {
        if (!is_array($modules)) {
            $modules = [$modules];
        }

        $controllerClass = null;
        foreach ($modules as $namespace) {
            $controller = studly_case(str_replace(['\\', '_'], ['/', ''], $controller));
            if (class_exists($class = $namespace.'Controllers\\'.$controller)) {
                $controllerClass = $class;
                break;
            }
        }

        if (!$controllerClass || !class_exists($controllerClass)) {
            return null;
        }

        $controllerObj = App::make($controllerClass);
        if ($controllerObj->checkAction(self::$action)) {
            return $controllerObj;
        }

        return null;
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
        if (str_contains($actionName, '-')) {
            return camel_case($actionName);
        }

        return $actionName;
    }

    protected function locateControllerInApp(array $segments): ?array
    {
        $modules = [
            '\\Igniter\\Admin\\Http\\',
            '\\Igniter\\Main\\Http\\',
            '\\Igniter\\System\\Http\\',
        ];

        $controller = $segments[0] ?? 'dashboard';
        $action = isset($segments[1]) ? $this->processAction($segments[1]) : 'index';
        self::$action = $action;

        $segments = array_slice($segments, 2);
        self::$segments = $segments;

        if ($controllerObj = $this->locateControllerInPath($controller, $modules)) {
            return [
                'controller' => $controllerObj,
                'action' => $action,
                'segments' => $segments,
            ];
        }

        return null;
    }

    protected function locateControllerInExtensions($segments): ?array
    {
        if (count($segments) >= 3) {
            [$author, $extension, $controller] = $segments;
            self::$action = isset($segments[3]) ? $this->processAction($segments[3]) : 'index';
            $action = isset($segments[3]) ? $this->processAction($segments[3]) : 'index';
            self::$segments = array_slice($segments, 4);
            $segments = self::$segments;

            $extensionCode = sprintf('%s.%s', $author, $extension);
            $extension = resolve(ExtensionManager::class)->findExtension($extensionCode);
            if (!$extension || $extension->disabled) {
                return null;
            }

            $namespace = array_get($extension->extensionMeta(), 'namespace');
            if ($controllerObj = $this->locateControllerInPath(
                $controller,
                ['\\'.$namespace, sprintf('\%sHttp\\', $namespace)],
            )) {
                return [
                    'controller' => $controllerObj,
                    'action' => $action,
                    'segments' => $segments,
                ];
            }
        }

        return null;
    }

    protected function pushRequestedControllerMiddleware()
    {
        if (!Igniter::runningInAdmin()) {
            return;
        }

        $pathParts = explode('/', request()->path());
        if (Igniter::adminUri()) {
            array_shift($pathParts);
        }

        $path = implode('/', $pathParts);
        if ($result = $this->locateController($path)) {
            // Collect controller middleware and insert middleware into pipeline
            collect($result['controller']->getMiddleware())->each(function(array $data) {
                $this->middleware($data['middleware'], $data['options']);
            });
        }
    }
}
