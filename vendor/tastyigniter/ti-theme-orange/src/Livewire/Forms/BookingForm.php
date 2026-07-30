<?php

declare(strict_types=1);

namespace Igniter\Orange\Livewire\Forms;

use Igniter\User\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Form;

final class BookingForm extends Form
{
    public ?string $firstName = null;

    public ?string $lastName = null;

    public ?string $email = null;

    public ?string $telephone = null;

    public ?string $comment = null;

    public function validationAttributes(): array
    {
        return [
            'firstName' => lang('igniter.reservation::default.label_first_name'),
            'lastName' => lang('igniter.reservation::default.label_last_name'),
            'email' => lang('igniter.reservation::default.label_email'),
            'telephone' => lang('igniter.reservation::default.label_telephone'),
            'comment' => lang('igniter.reservation::default.label_comment'),
        ];
    }

    public function rules(): array
    {
        return [
            'firstName' => 'required|between:1,48',
            'lastName' => 'required|between:1,48',
            'email' => ['sometimes', 'required', 'email:filter', 'max:96', Rule::unique('customers', 'email')->ignore(Auth::customer()?->getKey(), 'customer_id')],
            'telephone' => 'sometimes|nullable|regex:/^([0-9\s\-\+\(\)]*)$/i',
            'comment' => 'max:500',
        ];
    }
}
