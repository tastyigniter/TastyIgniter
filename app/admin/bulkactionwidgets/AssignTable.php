<?php

namespace Admin\BulkActionWidgets;

class AssignTable extends \Admin\Classes\BaseBulkActionWidget
{
    public function handleAction($requestData, $records)
    {
        $noTablesFound = [];
        $tablesAssigned = [];

        foreach ($records->sortBy('reservation_datetime') as $record) {
            if ($record->tables->count() > 0) {
                continue;
            }

            if ($record->assignTable()) {
                $tablesAssigned[] = $record->reservation_id;
            }
            else {
                $noTablesFound[] = $record->reservation_id;
            }
        }

        if ($noTablesFound) {
            flash()->warning(
                sprintf(lang('admin::lang.reservations.alert_no_assignable_table'), implode(', ', $noTablesFound))
            )->important();
        }

        if ($tablesAssigned) {
            flash()->success(lang('admin::lang.reservations.alert_table_assigned'));
        }
    }
}
