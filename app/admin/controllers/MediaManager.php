<?php namespace Admin\Controllers;

use AdminMenu;
use Template;

class MediaManager extends \Admin\Classes\AdminController
{
    protected $requiredPermissions = 'Admin.MediaManager';

    public function __construct()
    {
        parent::__construct();

        AdminMenu::setContext('media_manager', 'tools');
    }

    public function index()
    {
        Template::setTitle(lang('main::lang.media_manager.text_title'));
        Template::setHeading(lang('main::lang.media_manager.text_heading'));
    }
}