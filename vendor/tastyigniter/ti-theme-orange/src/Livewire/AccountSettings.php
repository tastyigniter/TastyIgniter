<?php

declare(strict_types=1);

namespace Igniter\Orange\Livewire;

use Igniter\Cart\Facades\Cart;
use Igniter\Flame\Exception\ApplicationException;
use Igniter\Main\Traits\ConfigurableComponent;
use Igniter\Orange\Livewire\Forms\SettingsForm;
use Igniter\User\Actions\LogoutCustomer;
use Igniter\User\Facades\Auth;
use Illuminate\Contracts\View\View;
use Livewire\Component;

final class AccountSettings extends Component
{
    use ConfigurableComponent;

    public SettingsForm $form;

    public string $loginPage = 'account.login';

    public static function componentMeta(): array
    {
        return [
            'code' => 'igniter-orange::account-settings',
            'name' => 'igniter.orange::default.component_account_settings_title',
            'description' => 'igniter.orange::default.component_account_settings_desc',
        ];
    }

    public function defineProperties(): array
    {
        return [
            'loginPage' => [
                'label' => 'Login page',
                'type' => 'select',
                'options' => [self::class, 'getThemePageOptions'],
            ],
        ];
    }

    public function render(): View
    {
        return view('igniter-orange::livewire.account-settings');
    }

    public function mount(): void
    {
        $this->form->fillFrom(Auth::customer());
    }

    public function cartCount()
    {
        return Cart::count();
    }

    public function cartTotal()
    {
        return Cart::total();
    }

    public function onUpdate()
    {
        throw_unless($customer = Auth::customer(),
            new ApplicationException('You must be logged in to manage your address book'),
        );

        $oldEmail = $customer->email;

        $this->form->validate();

        $customer->fill($this->form->except(['old_password', 'password_confirmation']));
        $customer->save();

        if ($this->form->old_password || $customer->email !== $oldEmail) {
            Cart::keepSession(function(): void {
                resolve(LogoutCustomer::class)->handle();
            });

            return redirect()->to(page_url($this->loginPage));
        }

        flash()->success(lang('igniter.user::default.settings.alert_updated_success'));

        return null;
    }
}
