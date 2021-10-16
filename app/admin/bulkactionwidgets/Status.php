<?php

namespace Admin\BulkActionWidgets;

use Admin\Classes\BaseBulkActionWidget;
use Illuminate\Support\Facades\DB;

class Status extends BaseBulkActionWidget
{
    public $statusColumn = 'status_id';

    public function initialize()
    {
        $this->fillFromConfig([
            'statusColumn',
        ]);
    }

    public function handleAction($requestData, $records)
    {
        $code = array_get($requestData, 'code');
        [$actionCode, $statusCode] = explode('.', $code, 2);
        $statusColumn = $this->statusColumn;

        if ($count = $records->count()) {
            DB::transaction(function () use ($records, $statusColumn, $statusCode) {
                foreach ($records as $record) {
                    $record->$statusColumn = ($statusCode === 'enable');
                    $record->save();
                }
            });

            $prefix = ($count > 1) ? ' records' : 'record';
            flash()->success(sprintf(lang('admin::lang.alert_success'),
                '['.$count.']'.$prefix.' '.strtolower(lang('admin::lang.text_'.$statusCode.'d'))
            ));
        }
        else {
            flash()->warning(sprintf(lang('admin::lang.alert_error_nothing'), strtolower(lang('admin::lang.text_'.$statusCode.'d'))));
        }
    }
}
