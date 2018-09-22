<?php

namespace Main\Traits;

use Main\Template\Page;
use System\Models\Pages_model;

trait HasPageOptions
{
    public static function getPageOptions()
    {
        return Page::lists('baseFileName', 'baseFileName');
    }

    public static function getPagesOptions()
    {
        return Pages_model::dropdown('name');
    }
}