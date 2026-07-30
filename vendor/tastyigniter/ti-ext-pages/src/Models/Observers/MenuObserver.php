<?php

declare(strict_types=1);

namespace Igniter\Pages\Models\Observers;

use Igniter\Pages\Models\Menu;

class MenuObserver
{
    public function saved(Menu $model): void
    {
        $model->restorePurgedValues();

        if (array_key_exists('items', $model->getAttributes())) {
            $model->addMenuItems((array)$model->getAttribute('items'));
        }
    }
}
