<?php

declare(strict_types=1);

namespace Igniter\Orange\Livewire\Forms;

use Livewire\Form;

final class AddressBookForm extends Form
{
    public ?int $address_id = null;

    public ?string $address_1 = null;

    public ?string $address_2 = null;

    public ?string $city = null;

    public ?string $state = null;

    public ?string $postcode = null;

    public ?int $country_id = null;

    public bool $is_default = false;

    public function validationAttributes(): array
    {
        return [
            'address_id' => lang('igniter.user::default.account.label_address_id'),
            'address_1' => lang('igniter.user::default.account.label_address_1'),
            'address_2' => lang('igniter.user::default.account.label_address_2'),
            'city' => lang('igniter.user::default.account.label_city'),
            'state' => lang('igniter.user::default.account.label_state'),
            'postcode' => lang('igniter.user::default.account.label_postcode'),
            'country_id' => lang('igniter.user::default.account.label_country'),
            'is_default' => lang('igniter.user::default.text_set_default'),
        ];
    }

    public function rules(): array
    {
        return [
            'address_id' => 'nullable|integer',
            'address_1' => 'required|min:3|max:128',
            'address_2' => 'max:128',
            'city' => 'required|min:2|max:128',
            'state' => 'max:128',
            'postcode' => 'min:2|max:11',
            'country_id' => 'required|integer',
            'is_default' => 'boolean',
        ];
    }

    public function fillFrom($address, $defaultAddressId = null): void
    {
        $this->address_id = $address?->address_id;
        $this->address_1 = $address?->address_1;
        $this->address_2 = $address?->address_2;
        $this->city = $address?->city;
        $this->state = $address?->state;
        $this->postcode = $address?->postcode;
        $this->country_id = $address?->country_id;
        $this->is_default = $address->address_id == $defaultAddressId;
    }
}
