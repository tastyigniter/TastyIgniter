<?php

declare(strict_types=1);

namespace Igniter\Reservation\BulkActionWidgets;

use Igniter\Admin\Classes\BaseBulkActionWidget;
use Igniter\Reservation\Models\Reservation;
use Illuminate\Support\Collection;
use Override;

class AssignTable extends BaseBulkActionWidget
{
    #[Override]
    public function handleAction(array $requestData, Collection $records): void
    {
        $noTablesFound = [];
        $tablesAssigned = [];

        foreach ($records->sortBy('reservation_datetime') as $reservation) {
            /** @var Reservation $reservation */
            if ($reservation->tables->count() > 0) {
                continue;
            }

            if ($reservation->autoAssignTable()) {
                $tablesAssigned[] = $reservation->reservation_id;
            } else {
                $noTablesFound[] = $reservation->reservation_id;
            }
        }

        if ($noTablesFound !== []) {
            flash()->warning(
                lang('igniter.reservation::default.alert_no_assignable_table').' '.implode(', ', $noTablesFound),
            )->important();
        }

        if ($tablesAssigned !== []) {
            flash()->success(lang('igniter.reservation::default.alert_table_assigned'));
        }
    }
}
