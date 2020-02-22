<?php

namespace Main\Traits;

use Main\Template\Page;
use System\Models\Pages_model;

trait HasPageOptions
{
    public function findPage($id)
    {
        return Pages_model::find($id);
    }

    public function getPageSlug($pageId)
    {
        $page = $this->findPage($pageId);

        return $page ? $page->permalink_slug : '';
    }

    public static function getPageOptions()
    {
        return Page::getDropdownOptions();
    }

    public static function getPagesOptions()
    {
        return Pages_model::getDropdownOptions();
    }
}