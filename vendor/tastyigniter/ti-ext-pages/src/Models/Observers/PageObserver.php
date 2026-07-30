<?php

declare(strict_types=1);

namespace Igniter\Pages\Models\Observers;

use Igniter\Pages\Models\Page;
use Igniter\System\Models\Language;

class PageObserver
{
    public function saving(Page $model): void
    {
        if (is_null($model->language_id)) {
            $model->language_id = Language::getDefault()->getKey();
        }
    }
}
