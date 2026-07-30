<?php

declare(strict_types=1);

namespace Igniter\Orange\View\Components;

use Igniter\Cart\Models\Order;
use Igniter\Main\Traits\ConfigurableComponent;
use Igniter\Main\Traits\UsesPage;
use Igniter\User\Facades\Auth;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Override;

final class OrderList extends Component
{
    use ConfigurableComponent;
    use UsesPage;

    public function __construct(
        public int $itemsPerPage = 20,
        public string $sortOrder = 'created_at desc',
        public string $orderPage = 'account.order',
    ) {}

    public static function componentMeta(): array
    {
        return [
            'code' => 'igniter-orange::order-list',
            'name' => 'igniter.orange::default.component_order_list_title',
            'description' => 'igniter.orange::default.component_order_list_desc',
        ];
    }

    public function defineProperties(): array
    {
        return [
            'itemsPerPage' => [
                'label' => 'Number of orders to display per page',
                'type' => 'number',
            ],
            'sortOrder' => [
                'label' => 'Default sort order of orders.',
                'type' => 'select',
            ],
            'orderPage' => [
                'label' => 'Page to redirect to when an order is clicked.',
                'type' => 'select',
                'options' => self::getThemePageOptions(...),
            ],
        ];
    }

    public static function getSortOrderOptions()
    {
        return collect((new Order)->queryModifierGetSorts())->mapWithKeys(fn($value, $key): array => [$value => $value])->all();
    }

    protected function loadOrders()
    {
        if (!$customer = Auth::customer()) {
            return [];
        }

        return $customer->orders()
            ->with(['location', 'status'])
            ->whereProcessed(true)
            ->listFrontEnd([
                'page' => request()->input('page', 1),
                'pageLimit' => $this->itemsPerPage,
                'sort' => $this->sortOrder,
            ]);
    }

    #[Override]
    public function render(): View
    {
        return view('igniter-orange::components.order-list', [
            'orders' => $this->loadOrders(),
        ]);
    }
}
