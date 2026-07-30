<?php

declare(strict_types=1);

namespace Igniter\Orange\Livewire;

use Igniter\Main\Traits\ConfigurableComponent;
use Igniter\Main\Traits\UsesPage;
use Igniter\Orange\Livewire\Forms\LoginForm;
use Igniter\User\Actions\LoginCustomer;
use Igniter\User\Facades\Auth;
use Igniter\User\Models\Customer;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Url;
use Livewire\Component;
use Throwable;

final class Login extends Component
{
    use ConfigurableComponent;
    use UsesPage;

    public LoginForm $form;

    public bool $registrationAllowed = true;

    public string $redirectPage = 'account.account';

    public bool $intendedRedirect = true;

    #[Url]
    public string $redirect = '';

    public static function componentMeta(): array
    {
        return [
            'code' => 'igniter-orange::login',
            'name' => 'igniter.orange::default.component_login_title',
            'description' => 'igniter.orange::default.component_login_desc',
        ];
    }

    public function defineProperties(): array
    {
        return [
            'redirectPage' => [
                'label' => 'Page to redirect to after login.',
                'type' => 'select',
                'options' => self::getThemePageOptions(...),
                'validationRule' => 'required|regex:/^[a-z0-9\-_\.]+$/i',
            ],
            'intendedRedirect' => [
                'label' => 'Force redirect to the previous page, this will override the redirect page.',
                'type' => 'switch',
                'default' => true,
                'validationRule' => 'required|boolean',
            ],
        ];
    }

    public function render(): View
    {
        return view('igniter-orange::livewire.login');
    }

    public function mount(): void
    {
        $this->registrationAllowed = (bool)setting('allow_registration', true);

        if ($this->intendedRedirect && $intendedRedirectUrl = $this->getRedirectIntendedUrl()) {
            redirect()->setIntendedUrl($intendedRedirectUrl);
        }
    }

    public function customer(): ?Customer
    {
        if (!Auth::check()) {
            return null;
        }

        return Auth::getUser();
    }

    public function onLogin(): void
    {
        $this->form->validate();

        rescue(function(): void {
            resolve(LoginCustomer::class, [
                'credentials' => $this->form->except('remember'),
                'remember' => $this->form->remember,
            ])->handle();

            if ($this->redirect !== '') {
                $this->redirect(page_url($this->redirect));
            } else {
                $this->intendedRedirect
                    ? $this->redirectIntended(page_url($this->redirectPage))
                    : $this->redirect(page_url($this->redirectPage));
            }
        }, function(Throwable $e): never {
            throw ValidationException::withMessages(['form.email' => $e->getMessage()]);
        });
    }

    protected function getRedirectIntendedUrl(): ?string
    {
        if (redirect()->getIntendedUrl()) {
            return null;
        }

        $previousUrl = url()->previous();
        if (!$previousUrl || $previousUrl === url()->current() || !str_starts_with($previousUrl, url('/'))) {
            return null;
        }

        return $previousUrl;
    }
}
