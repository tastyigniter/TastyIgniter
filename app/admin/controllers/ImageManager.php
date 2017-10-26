<?php namespace Admin\Controllers;

use Admin\Models\Image_tool_model;
use AdminMenu;
use Template;

class ImageManager extends \Admin\Classes\AdminController
{
    protected $requiredPermissions = 'Admin.MediaManager';

    public function __construct()
    {
        parent::__construct();

        AdminMenu::setContext('image_manager', 'tools');
    }

    public function index()
    {
        Template::setTitle(lang('system::media_manager.text_title'));
        Template::setHeading(lang('system::media_manager.text_heading'));
    }

    public function resize()
    {
        if (get('image')) {
            $width = (get('width')) ? (int)get('width') : '';
            $height = (get('height')) ? (int)get('height') : '';

            return Image_tool_model::resize(html_entity_decode(get('image'), ENT_QUOTES, 'UTF-8'), $width, $height);
        }
    }
}