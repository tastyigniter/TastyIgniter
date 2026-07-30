<?php

declare(strict_types=1);

namespace Igniter\Orange\View\Components;

use Igniter\Cart\Facades\Cart;
use Igniter\Main\Traits\ConfigurableComponent;
use Igniter\User\Facades\Auth;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Override;

final class AccountDashboard extends Component
{
    use ConfigurableComponent;

    public bool $hasDefaultAddress;

    public ?int $defaultAddressId;

    public string $formattedAddress = '';

    public string $customerName = '';

    public function __construct()
    {
        $customer = Auth::getUser();
        $this->customerName = $customer->full_name ?? '';
        $this->hasDefaultAddress = !is_null($customer?->address);
        $this->defaultAddressId = $customer?->address?->getKey();
        $this->formattedAddress = $this->hasDefaultAddress ? format_address($customer?->address) : '';
    }

    public static function componentMeta(): array
    {
        return [
            'code' => 'igniter-orange::account-dashboard',
            'name' => 'igniter.orange::default.component_account_dashboard_title',
            'description' => 'igniter.orange::default.component_account_dashboard_desc',
        ];
    }

    public function cartCount()
    {
        return Cart::count();
    }

    public function cartTotal()
    {
        return Cart::total();
    }

    #[Override]
    public function render(): View
    {
        return view('igniter-orange::components.account-dashboard');
    }
}
