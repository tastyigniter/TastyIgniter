<?php

declare(strict_types=1);

namespace Igniter\User\Actions;

use Igniter\Flame\Exception\ApplicationException;
use Igniter\User\Facades\Auth;
use Igniter\User\Models\Customer;
use Igniter\User\Models\CustomerGroup;
use Illuminate\Support\Facades\Event;

class RegisterCustomer
{
    public Customer $customer;

    public function handle(array $data = [], ?bool $activate = null): Customer
    {
        Event::dispatch('igniter.user.beforeRegister', [&$data]);

        if (array_key_exists('customer_group_id', $data)) {
            $customerGroup = CustomerGroup::query()->find($data['customer_group_id']);
        } else {
            $customerGroup = CustomerGroup::getDefault();
            $data['customer_group_id'] = $customerGroup?->getKey();
        }

        if (is_null($activate)) {
            /** @var CustomerGroup|null $customerGroup */
            $requireActivation = $customerGroup?->requiresApproval();
            $autoActivation = !$requireActivation;
        } else {
            $autoActivation = $activate;
        }

        /** @var Customer $customer */
        $customer = Auth::getProvider()->register($data, $autoActivation);

        Event::dispatch('igniter.user.register', [$customer, $data]);

        if ($autoActivation) {
            Auth::login($customer);
        }

        return $this->customer = $customer;
    }

    public function activate(string $code)
    {
        throw_unless($customer = Customer::whereActivationCode($code)->first(), new ApplicationException(
            lang('igniter.user::default.reset.alert_activation_failed'),
        ));

        /** @var Customer $customer */
        throw_unless($customer->completeActivation($code), new ApplicationException('User is already active!'));

        Auth::login($customer);

        return $this->customer = $customer;
    }
}
