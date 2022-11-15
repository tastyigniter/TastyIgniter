<?php

namespace Admin\Classes;

use Admin\Facades\Admin;
use Admin\Facades\AdminAuth;
use Admin\Facades\AdminLocation;
use Admin\Facades\AdminMenu;
use Admin\Widgets\Menu;
use Admin\Widgets\Toolbar;
use Exception;
use Igniter\Flame\Exception\AjaxException;
use Igniter\Flame\Exception\ApplicationException;
use Igniter\Flame\Exception\SystemException;
use Igniter\Flame\Exception\ValidationException;
use Igniter\Flame\Flash\Facades\Flash;
use Illuminate\Database\Eloquent\MassAssignmentException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Main\Widgets\MediaManager;
use System\Classes\Controller;
use System\Classes\ErrorHandler;

class AdminController extends BaseController
{
    use \Admin\Traits\HasAuthentication;
    use \Admin\Traits\ValidatesForm;
    use \Admin\Traits\WidgetMaker;
    use \System\Traits\AssetMaker;
    use \System\Traits\ConfigMaker;
    use \System\Traits\VerifiesCsrfToken;
    use \System\Traits\ViewMaker;
    use \Igniter\Flame\Traits\EventEmitter;
    use \Igniter\Flame\Traits\ExtendableTrait;

    /**
     * A list of controller behavours/traits to be implemented
     */
    public $implement = [];

    /**
     * @var object Object used for storing a fatal error.
     */
    protected $fatalError;

    /**
     * @var \Admin\Classes\BaseWidget[] A list of BaseWidget objects used on this page
     */
    public $widgets = [];

    /**
     * @var bool Prevents the automatic view display.
     */
    public $suppressView = false;

    /**
     * @var string Page method name being called.
     */
    protected $action;

    /**
     * @var array Routed parameters.
     */
    protected $params;

    /**
     * @var array Default actions which cannot be called as actions.
     */
    public $hiddenActions = [
        'checkAction',
        'pageAction',
        'execPageAction',
        'handleError',
    ];

    /**
     * @var array Array of actions available without authentication.
     */
    protected $publicActions = [];

    /**
     * @var array Controller specified methods which cannot be called as actions.
     */
    protected $guarded = [];

    /**
     * @var string Permission required to view this page.
     * ex. Admin.Banners.Access
     */
    protected $requiredPermissions;

    /**
     * @var string Page title
     */
    public $pageTitle;

    /**
     * @var string Body class property used for customising the layout on a controller basis.
     */
    public $bodyClass;

    /**
     * Class constructor
     */
    public function __construct()
    {
        $this->action = Controller::$action;
        $this->params = Controller::$segments;

        // Apply $guarded methods to hidden actions
        $this->hiddenActions = array_merge($this->hiddenActions, $this->guarded);

        // Define layout and view paths
        $this->definePaths();

        $this->extendableConstruct();
    }

    protected function definePaths()
    {
        $this->layout = $this->layout ?: 'default';
        $this->configPath = [];

        $classPath = strtolower(str_replace('\\', '/', get_called_class()));
        $relativePath = dirname($classPath, 2);
        $className = basename($classPath);

        // Add paths from the extension / module context
        $this->viewPath[] = '$/'.$relativePath.'/views';
        $this->viewPath[] = '$/'.$relativePath.'/views/'.$className;
        $this->viewPath[] = '~/app/'.$relativePath.'/views/'.$className;
        $this->viewPath[] = '~/app/'.$relativePath.'/views';
        $this->viewPath[] = '~/app/admin/views/'.$className;
        $this->viewPath[] = '~/app/admin/views';

        // Add layout paths from the extension / module context
        $this->layoutPath[] = '$/'.$relativePath.'/views/_layouts';
        $this->layoutPath[] = '~/app/'.$relativePath.'/views/_layouts';
        $this->layoutPath[] = '~/app/admin/views/_layouts';

        // Add partial paths from the extension / module context
        // We will also make sure the admin module context is always present
        $this->partialPath[] = '$/'.$relativePath.'/views/_partials';
        $this->partialPath[] = '~/app/'.$relativePath.'/views/_partials';
        $this->partialPath[] = '~/app/admin/views/_partials';
        $this->partialPath = array_merge($this->partialPath, $this->viewPath);

        $this->configPath[] = '$/'.$relativePath.'/models/config';
        $this->configPath[] = '~/app/'.$relativePath.'/models/config';

        $this->assetPath = '~/app/'.$relativePath.'/assets';
    }

    public function initialize()
    {
        // Set an instance of the admin user
        $this->setUser(AdminAuth::user());

        $this->fireSystemEvent('admin.controller.beforeInit');

        // @deprecated This event will be deprecated soon, use controller.beforeInit
        $this->fireEvent('controller.beforeConstructor', [$this]);

        // Toolbar widget is available on all admin pages
        $toolbar = new Toolbar($this, ['context' => $this->action]);
        $toolbar->bindToController();

        // Media Manager widget is available on all admin pages
        if ($this->currentUser && $this->currentUser->hasPermission('Admin.MediaManager')) {
            $manager = new MediaManager($this, ['alias' => 'mediamanager']);
            $manager->bindToController();
        }

        // Top menu widget is available on all admin pages
        $this->makeMainMenuWidget();

        // @deprecated This event will be deprecated soon, use controller.beforeRemap
        $this->fireEvent('controller.afterConstructor', [$this]);

        return $this;
    }

    public function remap($action, $params)
    {
        $this->fireSystemEvent('admin.controller.beforeRemap');

        if (!$this->verifyCsrfToken()) {
            return Response::make(lang('admin::lang.alert_invalid_csrf_token'), 403);
        }

        // Determine if this request is a public action or authentication is required
        $requireAuthentication = !(in_array($action, $this->publicActions) || !$this->requireAuthentication);

        // Ensures that a user is logged in, if required
        if ($requireAuthentication) {
            if (!$this->checkUser()) {
                return Request::ajax()
                    ? Response::make(lang('admin::lang.alert_user_not_logged_in'), 403)
                    : Admin::redirectGuest('login');
            }

            // Check that user has permission to view this page
            if ($this->requiredPermissions && !$this->getUser()->hasAnyPermission($this->requiredPermissions)) {
                return Response::make(Request::ajax()
                    ? lang('admin::lang.alert_user_restricted')
                    : $this->makeView('access_denied'), 403
                );
            }
        }

        if ($event = $this->fireSystemEvent('admin.controller.beforeResponse', [$action, $params])) {
            return $event;
        }

        if ($action === '404') {
            return Response::make($this->makeView('404'), 404);
        }

        // Execute post handler and AJAX event
        if (($handlerResponse = $this->processHandlers()) && $handlerResponse !== true) {
            return $handlerResponse;
        }

        // Loads the requested controller action
        $response = $this->execPageAction($action, $params);

        if (!is_string($response))
            return $response;

        // Return response
        return Response::make()->setContent($response);
    }

    public function checkAction($action)
    {
        if (!$methodExists = $this->methodExists($action))
            return false;

        if (in_array(strtolower($action), array_map('strtolower', $this->hiddenActions)))
            return false;

        if (method_exists($this, $action)) {
            $methodInfo = new \ReflectionMethod($this, $action);

            return $methodInfo->isPublic();
        }

        return $methodExists;
    }

    public function pageAction()
    {
        if (!$this->action) {
            return;
        }

        $this->suppressView = true;
        $this->execPageAction($this->action, $this->params);
    }

    public function getClass()
    {
        return $this->class;
    }

    public function getAction()
    {
        return $this->action;
    }

    protected function execPageAction($action, $params)
    {
        $result = null;

        if (!$this->checkAction($action)) {
            throw new Exception(sprintf(
                'Method [%s] is not found in the controller [%s]',
                $action, get_class($this)
            ));
        }

        array_unshift($params, $action);

        // Execute the action
        $result = call_user_func_array([$this, $action], array_values($params));

        // Render the controller view if not already loaded
        if (is_null($result) && !$this->suppressView) {
            return $this->makeView($this->fatalError ? 'admin::error' : $action);
        }

        return $result;
    }

    protected function makeMainMenuWidget()
    {
        if (AdminMenu::isCollapsed())
            $this->bodyClass .= 'sidebar-collapsed';

        $config = [];
        $config['alias'] = 'mainmenu';
        $config['items'] = AdminMenu::getMainItems();
        $config['context'] = class_basename($this);
        $mainMenuWidget = new Menu($this, $config);
        $mainMenuWidget->bindToController();
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

        try {
            $this->validateHandler($handler);

            $partials = $this->validateHandlerPartials();

            $response = [];

            $params = $this->params;
            array_unshift($params, $this->action);
            $result = $this->runHandler($handler, $params);

            foreach ($partials as $partial) {
                $response[$partial] = $this->makePartial($partial);
            }

            if (Request::ajax()) {
                if ($result instanceof RedirectResponse) {
                    $response['X_IGNITER_REDIRECT'] = $result->getTargetUrl();
                    $result = null;
                }
                elseif (Flash::messages()->isNotEmpty()) {
                    $response['#notification'] = $this->makePartial('flash');
                }
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

            return $response;
        }
        catch (ValidationException $ex) {
            $this->flashValidationErrors($ex->getErrors());

            $response['#notification'] = $this->makePartial('flash');
            $response['X_IGNITER_ERROR_FIELDS'] = $ex->getFields();
//            $response['X_IGNITER_ERROR_MESSAGE'] = $ex->getMessage(); avoid duplicate flash message.

            throw new AjaxException($response);
        }
        catch (MassAssignmentException $ex) {
            throw new ApplicationException(lang('admin::lang.form.mass_assignment_failed', ['attribute' => $ex->getMessage()]));
        }
        catch (Exception $ex) {
            throw $ex;
        }
    }

    protected function validateHandler($handler)
    {
        if (!preg_match('/^(?:\w+\:{2})?on[A-Z]{1}[\w+]*$/', $handler)) {
            throw new SystemException(sprintf(lang('admin::lang.alert_invalid_ajax_handler_name'), $handler));
        }
    }

    protected function validateHandlerPartials()
    {
        if (!$partials = trim(Request::header('X-IGNITER-REQUEST-PARTIALS')))
            return [];

        $partials = explode('&', $partials);

        foreach ($partials as $partial) {
            if (!preg_match('/^(?:\w+\:{2}|@)?[a-z0-9\_\-\.\/]+$/i', $partial)) {
                throw new SystemException(sprintf(lang('admin::lang.alert_invalid_ajax_partial_name'), $partial));
            }
        }

        return $partials;
    }

    //
    // Locationable
    //

    public function getUserLocation()
    {
        return AdminLocation::getLocation();
    }

    public function getLocationId()
    {
        return AdminLocation::getId();
    }

    //
    // Helper Methods
    //

    public function pageUrl($path = null, $parameters = [], $secure = null)
    {
        return Admin::url($path, $parameters, $secure);
    }

    public function redirect($path, $status = 302, $headers = [], $secure = null)
    {
        return Admin::redirect($path, $status, $headers, $secure);
    }

    public function redirectGuest($path, $status = 302, $headers = [], $secure = null)
    {
        return Admin::redirectGuest($path, $status, $headers, $secure);
    }

    public function redirectIntended($path, $status = 302, $headers = [], $secure = null)
    {
        return Admin::redirectIntended($path, $status, $headers, $secure);
    }

    public function redirectBack($status = 302, $headers = [], $fallback = false)
    {
        return Redirect::back($status, $headers, Admin::url($fallback ?: 'dashboard'));
    }

    public function refresh()
    {
        return Redirect::back();
    }

    protected function runHandler($handler, $params)
    {
        // Process Widget handler
        if (strpos($handler, '::')) {
            [$widgetName, $handlerName] = explode('::', $handler);

            // Execute the page action so widgets are initialized
            $this->pageAction();

            if (!isset($this->widgets[$widgetName])) {
                throw new Exception(sprintf(lang('admin::lang.alert_widget_not_bound_to_controller'), $widgetName));
            }

            if (($widget = $this->widgets[$widgetName]) && $widget->methodExists($handlerName)) {
                $result = call_user_func_array([$widget, $handlerName], array_values($params));

                return $result ?: true;
            }
        }
        // Process page specific handler (index_onSomething)
        else {
            $pageHandler = $this->action.'_'.$handler;

            if ($this->methodExists($pageHandler)) {
                $result = call_user_func_array([$this, $pageHandler], array_values($params));

                return $result ?: true;
            }

            // Process page global handler (onSomething)
            if ($this->methodExists($handler)) {
                $result = call_user_func_array([$this, $handler], array_values($params));

                return $result ?: true;
            }

            $this->suppressView = true;

            $this->execPageAction($this->action, $this->params);

            foreach ((array)$this->widgets as $widget) {
                if ($widget->methodExists($handler)) {
                    $result = call_user_func_array([$widget, $handler], array_values($params));

                    return $result ?: true;
                }
            }
        }

        return false;
    }

    /**
     * Sets standard page variables in the case of a controller error.
     *
     * @param \Exception $exception
     *
     * @throws \Exception
     */
    public function handleError(Exception $exception)
    {
        $errorMessage = ErrorHandler::getDetailedMessage($exception);
        $this->fatalError = $errorMessage;
        $this->vars['fatalError'] = $errorMessage;

        flash()->error($errorMessage)->important();
    }

    //
    // Extendable
    //

    public function __get($name)
    {
        return $this->extendableGet($name);
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
