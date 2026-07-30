<?php

declare(strict_types=1);

namespace Igniter\Orange\Livewire;

use Igniter\Main\Traits\ConfigurableComponent;
use Igniter\Main\Traits\UsesPage;
use Igniter\User\Models\Customer;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

final class ResetPassword extends Component
{
    use ConfigurableComponent;
    use UsesPage;

    /** The reset password page*/
    public string $resetPage = 'account.reset';

    /** The login page*/
    public string $loginPage = 'account.login';

    public ?string $email = null;

    public ?string $resetCode = null;

    public ?string $password = null;

    public ?string $password_confirmation = null;

    public ?string $message = null;

    public static function componentMeta(): array
    {
        return [
            'code' => 'igniter-orange::reset-password',
            'name' => 'igniter.orange::default.component_reset_password_title',
            'description' => 'igniter.orange::default.component_reset_password_desc',
        ];
    }

    public function defineProperties(): array
    {
        return [
            'resetPage' => [
                'label' => 'Page to generate the reset password link. The selected page _permalink_ should contain the `code` parameter.',
                'type' => 'select',
                'options' => self::getThemePageOptions(...),
                'validationRule' => 'required|regex:/^[a-z0-9\-_\.]+$/i',
            ],
            'loginPage' => [
                'label' => 'Page to redirect to after the password has been reset also used to generate the login link.',
                'type' => 'select',
                'options' => self::getThemePageOptions(...),
                'validationRule' => 'required|regex:/^[a-z0-9\-_\.]+$/i',
            ],
        ];
    }

    public function render(): View
    {
        return view('igniter-orange::livewire.reset-password');
    }

    public function mount(): void
    {
        $this->resetCode = request()->route()->parameter('code');
    }

    public function onForgotPassword(): void
    {
        $this->validate([
            'email' => 'required|email:filter|max:96',
        ], [], [
            'email' => lang('igniter.user::default.reset.label_email'),
        ]);

        if ($customer = Customer::whereEmail($this->email)->first()) {
            /** @var Customer $customer */
            throw_unless($customer->enabled(), ValidationException::withMessages([
                'email' => lang('igniter.user::default.reset.alert_reset_error'),
            ]));

            throw_unless($customer->resetPassword(), ValidationException::withMessages([
                'email' => lang('igniter.user::default.reset.alert_reset_error'),
            ]));

            $customer->mailSendResetPasswordRequest([
                'reset_link' => page_url($this->resetPage, ['code' => $customer->reset_code]),
                'account_login_link' => page_url($this->loginPage),
            ]);
        }

        $this->reset();

        $this->message = lang('igniter.user::default.reset.alert_reset_request_success');
    }

    public function onResetPassword()
    {
        $this->validate([
            'resetCode' => 'required',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required',
        ], [], [
            'resetCode' => lang('igniter.user::default.reset.label_code'),
            'password' => lang('igniter.user::default.reset.label_password'),
            'password_confirmation' => lang('igniter.user::default.reset.label_password_confirm'),
        ]);

        /** @var null|Customer $customer */
        $customer = Customer::whereResetCode($this->resetCode)->first();

        if (!$customer || !$customer->completeResetPassword($this->resetCode, $this->password)) {
            throw ValidationException::withMessages(['password' => lang('igniter.user::default.reset.alert_reset_failed')]);
        }

        $customer->mailSendResetPassword(['account_login_link' => page_url($this->loginPage)]);

        flash()->success(lang('igniter.user::default.reset.alert_reset_success'));

        return $this->redirect(page_url($this->loginPage));
    }
}
