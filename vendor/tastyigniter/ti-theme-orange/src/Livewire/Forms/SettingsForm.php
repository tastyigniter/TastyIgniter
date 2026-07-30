<?php

declare(strict_types=1);

namespace Igniter\Orange\Livewire\Forms;

use Igniter\User\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Form;

final class SettingsForm extends Form
{
    public string $first_name = '';

    public string $last_name = '';

    public string $telephone = '';

    public string $email = '';

    public ?bool $newsletter = false;

    public string $old_password = '';

    public string $password = '';

    public string $password_confirmation = '';

    public function fillFrom($customer): void
    {
        $this->first_name = $customer->first_name ?? '';
        $this->last_name = $customer->last_name ?? '';
        $this->telephone = $customer->telephone ?? '';
        $this->email = $customer->email ?? '';
    }

    public function validationAttributes(): array
    {
        return [
            'first_name' => lang('igniter.user::default.settings.label_first_name'),
            'last_name' => lang('igniter.user::default.settings.label_last_name'),
            'telephone' => lang('igniter.user::default.settings.label_telephone'),
            'email' => lang('igniter.user::default.settings.label_email'),
            'newsletter' => lang('igniter.user::default.settings.label_newsletter'),
            'old_password' => lang('igniter.user::default.settings.label_old_password'),
            'password' => lang('igniter.user::default.login.label_password'),
            'password_confirmation' => lang('igniter.user::default.login.label_password_confirm'),
        ];
    }

    public function rules(): array
    {
        return [
            'first_name' => ['required', 'between:1,48'],
            'last_name' => ['required', 'between:1,48'],
            'telephone' => ['string'],
            'email' => ['required', 'email:filter', 'max:96', Rule::unique('customers', 'email')->ignore(Auth::user()->getKey(), 'customer_id')],
            'newsletter' => ['boolean'],
            'old_password' => ['sometimes', 'min:6', 'max:32', 'current_password'],
            'password' => ['required_with:old_password', 'min:6', 'max:32', 'confirmed'],
            'password_confirmation' => ['string'],
        ];
    }
}
