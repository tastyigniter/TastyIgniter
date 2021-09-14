<?php

namespace Admin\BulkActionWidgets;

use Admin\Classes\BaseBulkActionWidget;

class Delete extends BaseBulkActionWidget
{
    public function handleAction($requestData, $records)
    {
        // Delete records
        if ($count = $records->count()) {
            foreach ($records as $record) {
                $record->delete();
            }

            $prefix = ($count > 1) ? ' records' : 'record';
            flash()->success(sprintf(lang('admin::lang.alert_success'), '['.$count.']'.$prefix.' '.lang('admin::lang.text_deleted')));
        }
        else {
            flash()->warning(sprintf(lang('admin::lang.alert_error_nothing'), lang('admin::lang.text_deleted')));
        }
    }
}
