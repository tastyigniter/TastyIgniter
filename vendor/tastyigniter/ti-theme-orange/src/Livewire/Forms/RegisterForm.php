<?php

declare(strict_types=1);

namespace Igniter\Orange\Livewire\Forms;

use Livewire\Form;

final class RegisterForm extends Form
{
    public string $first_name = '';

    public string $last_name = '';

    public string $email = '';

    public string $password = '';

    public string $password_confirmation = '';

    public string $telephone = '';

    public string $newsletter = '';

    public string $terms = '';

    public bool $status = true;

    public function validationAttributes(): array
    {
        return [
            'first_name' => lang('igniter.user::default.settings.label_first_name'),
            'last_name' => lang('igniter.user::default.settings.label_last_name'),
            'email' => lang('igniter.user::default.settings.label_email'),
            'password' => lang('igniter.user::default.login.label_password'),
            'password_confirmation' => lang('igniter.user::default.login.label_password_confirm'),
            'telephone' => lang('igniter.user::default.settings.label_telephone'),
            'newsletter' => lang('igniter.user::default.login.label_subscribe'),
            'terms' => lang('igniter.user::default.login.label_i_agree'),
        ];
    }

    public function rules(): array
    {
        return [
            'first_name' => ['required', 'between:1,48'],
            'last_name' => ['required', 'between:1,48'],
            'email' => ['required', 'email:filter', 'max:96', 'unique:customers,email'],
            'password' => ['required', 'min:6', 'max:32', 'confirmed'],
            'password_confirmation' => ['required'],
            'telephone' => ['required'],
            'newsletter' => ['boolean'],
            'terms' => ['sometimes', 'boolean'],
        ];
    }
}
