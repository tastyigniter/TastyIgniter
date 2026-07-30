<?php

declare(strict_types=1);

namespace Igniter\Admin\BulkActionWidgets;

use Igniter\Admin\Classes\BaseBulkActionWidget;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Override;

class Status extends BaseBulkActionWidget
{
    public $statusColumn = 'status_id';

    #[Override]
    public function initialize(): void
    {
        $this->fillFromConfig([
            'statusColumn',
        ]);
    }

    #[Override]
    public function handleAction(array $requestData, Collection $records): void
    {
        $code = array_get($requestData, 'code');
        [, $statusCode] = explode('.', (string)$code, 2);
        $statusColumn = $this->statusColumn;

        if (($count = $records->count()) !== 0) {
            DB::transaction(function() use ($records, $statusColumn, $statusCode) {
                foreach ($records as $record) {
                    $record->$statusColumn = ($statusCode === 'enable');
                    $record->save();
                }
            });

            $prefix = ($count > 1) ? ' records' : 'record';
            flash()->success(sprintf(lang('igniter::admin.alert_success'),
                '['.$count.']'.$prefix.' '.strtolower(lang('igniter::admin.text_'.$statusCode.'d'))
            ));
        } else {
            flash()->warning(sprintf(lang('igniter::admin.alert_error_nothing'), strtolower(lang('igniter::admin.text_'.$statusCode.'d'))));
        }
    }
}
