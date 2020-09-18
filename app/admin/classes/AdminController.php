<?php

namespace Admin\Classes;

use Admin;
use Admin\Traits\HasAuthentication;
use Admin\Traits\ValidatesForm;
use Admin\Traits\WidgetMaker;
use Admin\Widgets\Menu;
use Admin\Widgets\Toolbar;
use AdminAuth;
use AdminLocation;
use AdminMenu;
use Exception;
use Igniter\Flame\Exception\AjaxException;
use Igniter\Flame\Exception\ApplicationException;
use Igniter\Flame\Exception\SystemException;
use Igniter\Flame\Exception\ValidationException;
use Igniter\Flame\Flash\Facades\Flash;
use Illuminate\Database\Eloquent\MassAssignmentException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\View;
use Main\Widgets\MediaManager;
use Redirect;
use Request;
use Response;
use System\Classes\BaseController;
use System\Classes\ErrorHandler;
use System\Traits\AssetMaker;
use System\Traits\ConfigMaker;
use System\Traits\ViewMaker;

class AdminController extends BaseController
{
    use AssetMaker;
    use ViewMaker;
    use ConfigMaker;
    use WidgetMaker;
    use ValidatesForm;
    use HasAuthentication;

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
    public $suppressView = FALSE;

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
        // Define layout and view paths
        $this->layout = $this->layout ?: 'default';
        $this->configPath = [];

        $this->definePaths();

        // Create a new instance of the admin user
        $this->setUser(AdminAuth::user());

        parent::__construct();

        // Toolbar widget is available on all admin pages
        $toolbar = new Toolbar($this, ['context' => $this->action]);
        $toolbar->bindToController();

        // Media Manager widget is available on all admin pages
        if ($this->currentUser AND $this->currentUser->hasPermission('Admin.MediaManager')) {
            $manager = new MediaManager($this, ['alias' => 'mediamanager']);
            $manager->bindToController();
        }

        $this->fireEvent('controller.afterConstructor', [$this]);
    }

    protected function definePaths()
    {
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

    public function remap($action, $params)
    {
        $this->action = $action;
        $this->params = $params;

        // Determine if this request is a public action or authentication is required
        $requireAuthentication = !(in_array($action, $this->publicActions) OR !$this->requireAuthentication);

        // Ensures that a user is logged in, if required
        if ($requireAuthentication) {
            if (!$this->checkUser()) {
                return Request::ajax()
                    ? Response::make(lang('admin::lang.alert_user_not_logged_in'), 403)
                    : Admin::redirectGuest('login');
            }

            // Check that user has permission to view this page
            if ($this->requiredPermissions AND !$this->getUser()->hasAnyPermission($this->requiredPermissions)) {
                return Response::make(Request::ajax()
                    ? lang('admin::lang.alert_user_restricted')
                    : View::make('admin::access_denied'), 403
                );
            }
        }

        // Top menu widget is available on all admin pages
        $this->makeMainMenuWidget();

        if ($event = $this->fireSystemEvent('admin.controller.beforeResponse', [$action, $params])) {
            return $event;
        }

        // Execute post handler and AJAX event
        if ($handlerResponse = $this->processHandlers() AND $handlerResponse !== TRUE) {
            return $handlerResponse;
        }

        // Loads the requested controller action
        $response = $this->execPageAction($action, $params);

        if (!is_string($response))
            return $response;

        // Return response
        return is_string($response)
            ? Response::make($response, $this->statusCode) : $response;
    }

    public function pageAction()
    {
        if (!$this->action) {
            return;
        }

        $this->suppressView = TRUE;
        $this->execPageAction($this->action, $this->params);
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
        $result = call_user_func_array([$this, $action], $params);

        // Render the controller view if not already loaded
        if (is_null($result) AND !$this->suppressView) {
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
        $config['context'] = $this->getClass();
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
        if (Request::ajax() AND $handler = Request::header('X-IGNITER-REQUEST-HANDLER'))
            return trim($handler);

        if ($handler = post('_handler'))
            return trim($handler);

        return null;
    }

    protected function processHandlers()
    {
        if (!$handler = $this->getHandler())
            return FALSE;

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

            if (Request::ajax())
                return ['#notification' => $this->makePartial('flash')];

            throw new AjaxException($ex->getMessage());
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

    public function redirectBack($status = 302, $headers = [], $fallback = FALSE)
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
                throw new Exception(sprintf(
                    "A widget with class name '%s' has not been bound to the controller",
                    $widgetName
                ));
            }

            if (($widget = $this->widgets[$widgetName]) AND method_exists($widget, $handlerName)) {
                $result = call_user_func_array([$widget, $handlerName], $params);

                return $result ?: TRUE;
            }
        }
        // Process page specific handler (index_onSomething)
        else {
            $pageHandler = $this->action.'_'.$handler;

            if ($this->methodExists($pageHandler)) {
                $result = call_user_func_array([$this, $pageHandler], $params);

                return $result ?: TRUE;
            }

            // Process page global handler (onSomething)
            if ($this->methodExists($handler)) {
                $result = call_user_func_array([$this, $handler], $params);

                return $result ?: TRUE;
            }

            $this->suppressView = TRUE;

            $this->execPageAction($this->action, $this->params);

            foreach ((array)$this->widgets as $widget) {
                if ($widget->methodExists($handler)) {
                    $result = call_user_func_array([$widget, $handler], $params);

                    return $result ?: TRUE;
                }
            }
        }

        return FALSE;
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
}
