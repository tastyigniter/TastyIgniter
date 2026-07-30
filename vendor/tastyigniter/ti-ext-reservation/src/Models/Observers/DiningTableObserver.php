<?php

declare(strict_types=1);

namespace Igniter\Reservation\Models\Observers;

use Igniter\Flame\Exception\SystemException;
use Igniter\Reservation\Models\DiningTable;

class DiningTableObserver
{
    public function saving(DiningTable $diningTable): void
    {
        if (!$diningTable->getRgt() || !$diningTable->getLft()) {
            $diningTable->fixTree();
        }
    }

    public function saved(DiningTable $diningTable): void
    {
        if (!is_null($diningTable->parent_id) && $diningTable->parent) {
            $diningTable->parent->name = $diningTable->parent->children->pluck('name')->join('/');
            $diningTable->parent->saveQuietly();
        }
    }

    public function deleting(DiningTable $diningTable): void
    {
        if (!is_null($diningTable->parent_id)) {
            throw new SystemException(lang('igniter.reservation::default.dining_tables.error_cannot_delete_has_parent'));
        }

        if ($diningTable->is_combo) {
            $diningTable->descendants()->each(function(DiningTable $descendant): void {
                $descendant->saveAsRoot();
            });

            (new DiningTable)->fixBrokenTreeQuietly();

            $diningTable->refreshNode();
        }
    }
}
