<?php

declare(strict_types=1);

namespace Igniter\User\AutomationRules\Conditions;

use Igniter\Automation\AutomationException;
use Igniter\Automation\Classes\BaseModelAttributesCondition;
use Igniter\User\Models\Customer;
use Override;

class CustomerAttribute extends BaseModelAttributesCondition
{
    protected $modelClass = Customer::class;

    protected $modelAttributes;

    #[Override]
    public function conditionDetails(): array
    {
        return [
            'name' => 'Customer attribute',
            'description' => 'Customer attributes',
        ];
    }

    #[Override]
    public function defineModelAttributes(): array
    {
        return [
            'first_name' => [
                'label' => 'First Name',
            ],
            'last_name' => [
                'label' => 'Last Name',
            ],
            'telephone' => [
                'label' => 'Telephone',
            ],
            'email' => [
                'label' => 'Email address',
            ],
        ];
    }

    /**
     * Checks whether the condition is TRUE for specified parameters
     * @param array $params Specifies a list of parameters as an associative array.
     * @return bool
     */
    #[Override]
    public function isTrue(&$params)
    {
        if (!$customer = array_get($params, 'customer')) {
            throw new AutomationException('Error evaluating the customer attribute condition: the customer object is not found in the condition parameters.');
        }

        return $this->evalIsTrue($customer);
    }
}
