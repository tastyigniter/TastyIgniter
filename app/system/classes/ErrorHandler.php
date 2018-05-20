<?php namespace System\Classes;

use App;
use ApplicationException;
use Config;
use Igniter\Flame\Exception\ErrorHandler as BaseErrorHandler;
use Log;
use Main\Classes\MainController;
use Main\Classes\Router;
use Main\Classes\ThemeManager;
use Symfony\Component\HttpFoundation\Response;
use View;

/**
 * System Error Handler
 * Handles application exception events.
 * Based on: october\ErrorHandler
 */
class ErrorHandler extends BaseErrorHandler
{
    public function beforeHandleError($exception)
    {
        if ($exception instanceof ApplicationException) {
            Log::error($exception);
        }
    }

    /**
     * Looks up an error page using the route "/error". If the route does not
     * exist, this function will use the error view found in the MAIN app.
     * @return mixed Error page contents.
     */
    public function handleCustomError()
    {
        if (Config::get('app.debug', FALSE)) {
            return FALSE;
        }

        if (!App::hasDatabase())
            return View::make('main::error');

        $theme = ThemeManager::instance()->getActiveTheme();
        $router = new Router($theme);

        // Use the default view if no "/error" URL is found.
        if (!$router OR !$router->findByUrl('/error')) {
            return View::make('main::error');
        }

        // Route to the main error page.
        $controller = new MainController($theme);
        $result = $controller->remap('/error');

        // Extract content from response object
        if ($result instanceof Response) {
            $result = $result->getContent();
        }

        return $result;
    }

    /**
     * Displays the detailed system exception page.
     *
     * @param $exception
     *
     * @return \View Object containing the error page.
     */
    public function handleDetailedError($exception)
    {
        // Ensure System view path is registered
        View::addNamespace('system', app_path('system/views'));

        return View::make('system::exception', ['exception' => $exception]);
    }
}
