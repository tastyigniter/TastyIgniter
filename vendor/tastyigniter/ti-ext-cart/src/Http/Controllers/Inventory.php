<?php

declare(strict_types=1);

namespace Igniter\Cart\Http\Controllers;

use Exception;
use Igniter\Admin\Classes\AdminController;
use Igniter\Admin\Facades\AdminMenu;
use Igniter\Admin\Http\Actions\ListController;
use Igniter\Cart\Models\Stock;
use Igniter\Flame\Exception\ApplicationException;
use Igniter\Local\Facades\Location as LocationFacade;
use Igniter\Local\Http\Actions\LocationAwareController;
use Illuminate\Support\Carbon;

class Inventory extends AdminController
{
    private const string REQUEST_TYPE_DURATION = 'duration';

    private const string REQUEST_TYPE_CLOSING = 'closing';

    public array $implement = [
        ListController::class,
        LocationAwareController::class,
    ];

    public array $listConfig = [
        'list' => [
            'model' => Stock::class,
            'title' => 'lang:igniter.cart::default.stocks.text_inventory_title',
            'emptyMessage' => 'lang:igniter.cart::default.stocks.text_empty',
            'defaultSort' => ['updated_at', 'DESC'],
            'configFile' => 'inventory',
        ],
    ];

    protected null|string|array $requiredPermissions = 'Admin.Inventory';

    public static function getSlug(): string
    {
        return 'inventory';
    }

    public function __construct()
    {
        parent::__construct();

        AdminMenu::setContext('inventory', 'restaurant');
    }

    public function listExtendQuery($query): void
    {
        $query->with(['stockable', 'location'])->where('is_tracked', true);
    }

    public function index_onMarkOutOfStock(): array
    {
        $type = post('outOfStockType');

        throw_unless(in_array($type, [
            Stock::OOS_INDEFINITELY, self::REQUEST_TYPE_CLOSING, Stock::OOS_CUSTOM, self::REQUEST_TYPE_DURATION,
        ]), new ApplicationException(lang('igniter.cart::default.stocks.alert_invalid_oos_type')));

        $stock = $this->findStockOrFail();
        $untilDate = $this->resolveOutOfStockUntil($type, $stock);

        $stock->applyOutOfStockOverride($type, $untilDate);

        flash()->success(lang('igniter.cart::default.stocks.alert_marked_as_out_of_stock'));

        return $this->refreshList();
    }

    public function index_onClearOutOfStock(): array
    {
        $stock = $this->findStockOrFail();
        $stock->clearOutOfStockOverride();

        flash()->success(lang('igniter.cart::default.stocks.alert_back_in_stock'));

        return $this->refreshList();
    }

    private function findStockOrFail(): Stock
    {
        $stockId = (int) post('recordId');

        throw_unless($stockId > 0, new ApplicationException(
            lang('igniter.cart::default.stocks.alert_invalid_stock_id')
        ));

        $query = Stock::query();

        if ($ids = LocationFacade::currentOrAssigned()) {
            $query->whereHasLocation($ids);
        }

        return $query->findOrFail($stockId);
    }

    private function resolveOutOfStockUntil(string &$type, Stock $stock): ?Carbon
    {
        return match ($type) {
            self::REQUEST_TYPE_DURATION => $this->resolveDuration($type),
            self::REQUEST_TYPE_CLOSING => $this->resolveClosingTime($type, $stock),
            Stock::OOS_CUSTOM => $this->resolveCustomDate(),
            default => null,
        };
    }

    private function resolveDuration(string &$type): Carbon
    {
        $duration = (int) post('outOfStockDuration');

        throw_unless($duration > 0, new ApplicationException(
            lang('igniter.cart::default.stocks.alert_invalid_oos_duration')
        ));

        $type = Stock::OOS_CUSTOM;

        return now()->addMinutes($duration);
    }

    private function resolveClosingTime(string &$type, Stock $stock): Carbon
    {
        try {
            $closeAt = $stock->location->newWorkingSchedule('opening')->nextCloseAt(now());
        } catch (Exception) {
            $closeAt = null;
        }

        throw_unless($closeAt, new ApplicationException(
            lang('igniter.cart::default.stocks.alert_no_closing_time')
        ));

        $type = Stock::OOS_CUSTOM;

        return Carbon::instance($closeAt);
    }

    private function resolveCustomDate(): Carbon
    {
        $until = post('outOfStockUntil');

        throw_unless($until, new ApplicationException(
            lang('igniter.cart::default.stocks.alert_oos_date_required')
        ));

        try {
            $untilDate = Carbon::parse($until);
        } catch (Exception) {
            throw new ApplicationException(lang('igniter.cart::default.stocks.alert_invalid_oos_date'));
        }

        throw_unless($untilDate->isFuture(), new ApplicationException(
            lang('igniter.cart::default.stocks.alert_oos_date_must_be_future')
        ));

        return $untilDate;
    }
}
