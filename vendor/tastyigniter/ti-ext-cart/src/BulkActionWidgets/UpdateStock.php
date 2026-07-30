<?php

declare(strict_types=1);

namespace Igniter\Cart\BulkActionWidgets;

use Igniter\Admin\Classes\BaseBulkActionWidget;
use Igniter\Cart\Models\Stock;
use Illuminate\Support\Collection;
use Override;

class UpdateStock extends BaseBulkActionWidget
{
    #[Override]
    public function handleAction(array $requestData, Collection $records): void
    {
        $records->each(fn(Stock $stock): bool => $stock->markAsOutOfStock());

        flash()->success(lang('igniter.cart::default.stocks.alert_marked_as_out_of_stock'));
    }
}
