<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps\Http\Controllers;

use Igniter\Admin\Classes\AdminController;
use Igniter\Admin\Facades\AdminMenu;
use Igniter\Admin\Facades\Template;

abstract class AdminPageController extends AdminController
{
    /** RestaurantOps pages use explicit Laravel routes, never the native slug catch-all. */
    public static bool $skipRouteRegister = true;

    /**
     * Dispatch explicit RestaurantOps routes with Laravel's resolved route arguments.
     *
     * Native AdminController::callAction discards named route arguments and prepends
     * an action/context string. These controllers deliberately use the standard
     * Laravel action contract while retaining the native admin rendering helpers.
     */
    public function callAction($method, $parameters): mixed
    {
        $this->initialize();

        return $this->{$method}(...array_values($parameters));
    }

    protected function renderAdminPage(string $view, array $data, string $title, string $menuItem): string
    {
        AdminMenu::setContext($menuItem, 'restaurant-operations');

        if (! isset($this->widgets['mainmenu'])) {
            $this->initialize();
        }

        Template::setTitle($title);
        Template::setHeading($title);

        $contents = $this->makeViewContent($view, $data);
        Template::setBlock('body', $contents);

        return $this->makeLayout();
    }
}
