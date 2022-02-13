<?php

namespace Admin\BulkActionWidgets;

use Admin\Classes\BaseBulkActionWidget;
use Illuminate\Support\Facades\DB;

class Delete extends BaseBulkActionWidget
{
    public function handleAction($requestData, $records)
    {
        // Delete records
        if ($count = $records->count()) {
            DB::transaction(function () use ($records) {
                foreach ($records as $record) {
                    $record->delete();
                }
            });

            $prefix = ($count > 1) ? ' records' : 'record';
            flash()->success(sprintf(lang('admin::lang.alert_success'), '['.$count.']'.$prefix.' '.lang('admin::lang.text_deleted')));
        }
        else {
            flash()->warning(sprintf(lang('admin::lang.alert_error_nothing'), lang('admin::lang.text_deleted')));
        }
    }
}
