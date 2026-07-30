<?php

declare(strict_types=1);

namespace Igniter\Orange\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

final class LoginForm extends Form
{
    #[Validate('required|email:filter|max:96', as: 'lang:igniter.user::default.settings.label_email')]
    public string $email;

    #[Validate('required|min:8|max:40', as: 'lang:igniter.user::default.login.label_password')]
    public string $password;

    #[Validate('nullable|boolean', as: 'lang:igniter.user::default.login.label_remember')]
    public bool $remember = true;
}
