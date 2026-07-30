<?php

declare(strict_types=1);

namespace Igniter\Admin\BulkActionWidgets;

use Igniter\Admin\Classes\BaseBulkActionWidget;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Override;

class Delete extends BaseBulkActionWidget
{
    #[Override]
    public function handleAction(array $requestData, Collection $records): void
    {
        // Delete records
        if (($count = $records->count()) !== 0) {
            DB::transaction(function() use ($records) {
                foreach ($records as $record) {
                    $record->delete();
                }
            });

            $prefix = ($count > 1) ? ' records' : 'record';
            flash()->success(sprintf(lang('igniter::admin.alert_success'), '['.$count.']'.$prefix.' '.lang('igniter::admin.text_deleted')));
        } else {
            flash()->warning(sprintf(lang('igniter::admin.alert_error_nothing'), lang('igniter::admin.text_deleted')));
        }
    }
}
