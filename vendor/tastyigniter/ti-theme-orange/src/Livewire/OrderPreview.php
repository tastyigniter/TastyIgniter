<?php

declare(strict_types=1);

namespace Igniter\Orange\Livewire;

use Igniter\Cart\Classes\CartManager;
use Igniter\Cart\Classes\OrderManager;
use Igniter\Flame\Exception\ApplicationException;
use Igniter\Main\Helpers\MainHelper;
use Igniter\Main\Traits\ConfigurableComponent;
use Igniter\Main\Traits\UsesPage;
use Igniter\User\Facades\Auth;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Throwable;

final class OrderPreview extends Component
{
    use ConfigurableComponent;
    use UsesPage;

    /** The parameter name used for the order hash code */
    public string $hashParamName = 'hash';

    public ?string $hash = null;

    public string $loginPage = 'account.login';

    /** Account Orders Page */
    public string $ordersPage = 'account.orders';

    public string $checkoutPage = 'checkout.checkout';

    /** Menus Page, page to redirect to when a user clicks the re-order button */
    public string $menusPage = 'local.menus';

    public string $loginUrl = '';

    /** Whether to hide the reorder button, should be hidden on the checkout success page */
    public bool $hideReorderBtn = true;

    public bool $showCancelButton = false;

    protected OrderManager $orderManager;

    protected ?Model $order = null;

    public static function componentMeta(): array
    {
        return [
            'code' => 'igniter-orange::order-preview',
            'name' => 'igniter.orange::default.component_order_preview_title',
            'description' => 'igniter.orange::default.component_order_preview_desc',
        ];
    }

    public function defineProperties(): array
    {
        return [
            'hashParamName' => [
                'label' => 'URL routing parameter that holds the code used for displaying the order confirmation page.',
                'type' => 'text',
                'validationRule' => 'required|alpha',
            ],
            'loginPage' => [
                'label' => 'Page to redirect to when the user clicks the login button.',
                'type' => 'select',
                'options' => self::getThemePageOptions(...),
                'validationRule' => 'required|regex:/^[a-z0-9\-_\.]+$/i',
            ],
            'ordersPage' => [
                'label' => 'Page to redirect to when viewing as logged in customer and an order is incomplete or not found.',
                'type' => 'select',
                'options' => self::getThemePageOptions(...),
                'validationRule' => 'required|regex:/^[a-z0-9\-_\.]+$/i',
            ],
            'checkoutPage' => [
                'label' => 'Page to redirect to when viewing as guest and an order is incomplete or not found.',
                'type' => 'select',
                'options' => self::getThemePageOptions(...),
                'validationRule' => 'required|regex:/^[a-z0-9\-_\.]+$/i',
            ],
            'menusPage' => [
                'label' => 'Page to redirect to when the user clicks the reorder button.',
                'type' => 'select',
                'options' => self::getThemePageOptions(...),
                'validationRule' => 'required|regex:/^[a-z0-9\-_\.]+$/i',
            ],
            'hideReorderBtn' => [
                'label' => 'When rendering the component on the checkout confirmation page, hide the re-order button',
                'type' => 'switch',
                'validationRule' => 'required|boolean',
            ],
        ];
    }

    public function render(): View
    {
        return view('igniter-orange::livewire.order-preview', [
            'customer' => Auth::customer(),
            'order' => $this->getProcessedOrder(),
        ]);
    }

    public function boot(): void
    {
        $this->orderManager = resolve(OrderManager::class);
    }

    public function mount(?string $hash = null)
    {
        $this->loginUrl = $this->getLoginPageUrl();
        $this->hash = $hash ?? request()->route()->parameter($this->hashParamName);
        $this->showCancelButton = $this->showCancelButton();

        if (!$processedOrder = $this->getProcessedOrder()) {
            return $this->redirect(MainHelper::pageUrl($this->checkoutPage));
        }

        if ($this->orderManager->isCurrentOrderId($processedOrder->order_id)) {
            $this->orderManager->clearOrder();
        }

        return null;
    }

    public function getStatusWidthForProgressBars(): array
    {
        $result = [];

        $order = $this->getProcessedOrder();

        $result['default'] = 0;
        $result['processing'] = 0;
        $result['completed'] = 0;

        if ($order->status_id == setting('default_order_status')) {
            $result['default'] = 50;
        }

        if (in_array($order->status_id, setting('processing_order_status', []))) {
            $result['default'] = 100;
            $result['processing'] = 50;
        }

        if (in_array($order->status_id, setting('completed_order_status', []))) {
            $result['default'] = 100;
            $result['processing'] = 100;
            $result['completed'] = 100;
        }

        return $result;
    }

    public function showCancelButton(): bool
    {
        return $this->getProcessedOrder() && !$this->getProcessedOrder()->isCanceled() && $this->getProcessedOrder()->isCancelable();
    }

    public function onReOrder(): void
    {
        $order = $this->getProcessedOrder();

        rescue(function() use ($order): void {
            $cartManager = resolve(CartManager::class);
            $currentInstance = $cartManager->getCart()->currentInstance();
            $cartManager->cartInstance($order->location_id);

            $notes = $cartManager->restoreWithOrderMenus($order->getOrderMenus());

            $cartManager->getCart()->instance($currentInstance);

            if ($notes) {
                throw new ApplicationException(implode(PHP_EOL, $notes));
            }

            flash()->success(sprintf(
                lang('igniter.cart::default.orders.alert_reorder_success'), $order->order_id,
            ));

            $this->redirect(page_url($this->menusPage, [
                'orderId' => $order->order_id,
                'location' => $order->location->permalink_slug,
            ]));
        }, function(Throwable $ex): never {
            throw ValidationException::withMessages(['onReOrder' => $ex->getMessage()]);
        });
    }

    public function onCancel(): void
    {
        $order = $this->getProcessedOrder();

        throw_unless($this->showCancelButton(), ValidationException::withMessages([
            'onCancel' => lang('igniter.cart::default.orders.alert_cancel_failed'),
        ]));

        throw_unless($order->markAsCanceled(), ValidationException::withMessages([
            'onCancel' => lang('igniter.cart::default.orders.alert_cancel_failed'),
        ]));

        flash()->success(lang('igniter.cart::default.orders.alert_cancel_success'));
    }

    protected function getProcessedOrder()
    {
        if (!$this->hash) {
            return null;
        }

        if (!is_null($this->order)) {
            return $this->order;
        }

        $order = $this->orderManager->getOrderByHash($this->hash, Auth::customer());
        if (!$order?->isPaymentProcessed()) {
            return null;
        }

        return $this->order = $order;
    }

    protected function getLoginPageUrl(): string
    {
        $currentUrl = str_after(request()->fullUrl(), request()->root());

        return page_url($this->loginPage).'?redirect='.urlencode($currentUrl);
    }
}
