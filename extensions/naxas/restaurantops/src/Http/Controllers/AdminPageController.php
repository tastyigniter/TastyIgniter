<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps\Http\Controllers;

use Igniter\Admin\Classes\AdminController;
use Igniter\Admin\Facades\AdminMenu;
use Igniter\Admin\Facades\Template;

abstract class AdminPageController extends AdminController
{
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
