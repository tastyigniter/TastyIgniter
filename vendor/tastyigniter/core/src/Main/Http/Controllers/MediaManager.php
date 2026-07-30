<?php

declare(strict_types=1);

namespace Igniter\Main\Http\Controllers;

use Igniter\Admin\Classes\AdminController;
use Igniter\Admin\Facades\AdminMenu;
use Igniter\Admin\Facades\Template;

class MediaManager extends AdminController
{
    protected null|string|array $requiredPermissions = 'Admin.MediaManager';

    public function __construct()
    {
        parent::__construct();

        AdminMenu::setContext('media_manager', 'tools');
    }

    public function index(): void
    {
        Template::setTitle(lang('igniter::main.media_manager.text_title'));
        Template::setHeading(lang('igniter::main.media_manager.text_heading'));
    }
}
