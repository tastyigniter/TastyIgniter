<?php

declare(strict_types=1);

namespace Igniter\Orange\Livewire;

use Igniter\Admin\Classes\FormField;
use Igniter\Admin\Widgets\Form;
use Igniter\Flame\Exception\ApplicationException;
use Igniter\Main\Traits\ConfigurableComponent;
use Igniter\Orange\Livewire\Forms\AddressBookForm;
use Igniter\System\Models\Country;
use Igniter\User\Facades\Auth;
use Igniter\User\Models\Address;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithPagination;

final class AddressBook extends Component
{
    use ConfigurableComponent;
    use WithPagination;

    public ?int $addressId = null;

    public ?int $defaultAddressId = null;

    public bool $showModal = false;

    public AddressBookForm $form;

    public int $itemsPerPage = 20;

    public string $sortOrder = 'created_at desc';

    public static function componentMeta(): array
    {
        return [
            'code' => 'igniter-orange::address-book',
            'name' => 'igniter.orange::default.component_address_book_title',
            'description' => 'igniter.orange::default.component_address_book_desc',
        ];
    }

    public function defineProperties(): array
    {
        return [
            'itemsPerPage' => [
                'label' => 'Number of addresses to display per page',
                'type' => 'number',
            ],
            'sortOrder' => [
                'label' => 'Default sort order of addresses',
                'type' => 'select',
            ],
        ];
    }

    public static function getPropertyOptions(Form $form, FormField $field): array
    {
        return match ($field->getConfig('property')) {
            'sortOrder' => collect((new Address)->queryModifierGetSorts())->mapWithKeys(fn($value, $key): array => [$value => $value])->all(),
            default => [],
        };
    }

    public function render(): View
    {
        if ($address = $this->getAddress($this->addressId)) {
            $this->form->fillFrom($address, Auth::customer()->address_id);
        }

        return view('igniter-orange::livewire.address-book', [
            'selectAddress' => $address,
            'addresses' => $this->loadAddressBook(),
        ]);
    }

    public function mount(): void
    {
        $this->defaultAddressId = Auth::customer()?->address_id;
        $this->form->country_id = Country::getDefaultKey();
    }

    public function updated($property, $value): void
    {
        if ($property === 'addressId') {
            $this->showModal = !empty($value);
            $this->form->reset();
            $this->resetErrorBag();
        }
    }

    public function onSave(): void
    {
        throw_unless($customer = Auth::customer(),
            new ApplicationException('You must be logged in to manage your address book'),
        );

        $this->form->validate();

        if ($this->addressId) {
            throw_unless($address = $this->getAddress($this->addressId), new ApplicationException('Address not found'));
            $address->fill($this->form->except('address_id'));
            $address->save();
        } else {
            $address = $customer->addresses()->create($this->form->except('address_id'));
        }

        if ($this->form->is_default) {
            $customer->address_id = $address->address_id;
            $customer->saveQuietly();
        }

        flash()->success(lang('igniter.user::default.account.alert_updated_success'))->now();

        $this->addressId = null;
        $this->showModal = false;
    }

    public function onSetDefault(string $addressId): void
    {
        throw_unless($customer = Auth::customer(),
            new ApplicationException('You must be logged in to manage your address book'),
        );

        $customer->saveDefaultAddress($addressId);

        $this->defaultAddressId = (int)$addressId;
    }

    public function onDelete(string $addressId): void
    {
        throw_unless($customer = Auth::customer(),
            new ApplicationException('You must be logged in to manage your address book'),
        );

        $customer->deleteCustomerAddress($addressId);

        flash()->success(lang('igniter.user::default.account.alert_deleted_success'))->now();

        $this->addressId = null;
    }

    protected function getAddress(?int $addressId)
    {
        return $addressId ? Auth::customer()?->addresses()->find($addressId) : null;
    }

    protected function loadAddressBook()
    {
        if (!$customer = Auth::customer()) {
            return [];
        }

        return $customer->addresses()->listFrontEnd([
            'page' => $this->getPage(),
            'pageLimit' => $this->itemsPerPage,
            'sort' => $this->sortOrder,
        ]);
    }
}
