<?php

namespace System\Classes;

use Igniter\Flame\Exception\ApplicationException;
use Igniter\Flame\Exception\ErrorHandler as BaseErrorHandler;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;
use Main\Classes\MainController;
use Main\Classes\Router;
use Main\Classes\ThemeManager;
use Symfony\Component\HttpFoundation\Response;

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
        if (Config::get('app.debug', false)) {
            return false;
        }

        if (!App::hasDatabase())
            return View::make('main::error');

        $theme = ThemeManager::instance()->getActiveTheme();
        $router = new Router($theme);

        // Use the default view if no "/error" URL is found.
        if (!$router || !$router->findByUrl('/error')) {
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
}
