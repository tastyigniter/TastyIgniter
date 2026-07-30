<?php

declare(strict_types=1);

namespace Igniter\Reservation\AutomationRules\Conditions;

use Igniter\Admin\Models\Status;
use Igniter\Automation\AutomationException;
use Igniter\Automation\Classes\BaseModelAttributesCondition;
use Override;

class ReservationStatusAttribute extends BaseModelAttributesCondition
{
    protected $modelClass = Status::class;

    protected $modelAttributes;

    #[Override]
    public function conditionDetails(): array
    {
        return [
            'name' => 'Reservation status attribute',
            'description' => 'Reservation status attributes',
        ];
    }

    #[Override]
    public function defineModelAttributes(): array
    {
        return [
            'status_id' => [
                'label' => 'Status ID',
            ],
            'status_name' => [
                'label' => 'Status Name',
            ],
            'notify_customer' => [
                'label' => 'Notify Customer',
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
        $status = array_get($params, 'status');
        if (!$status instanceof Status) {
            throw new AutomationException('Error evaluating the status attribute condition: the status object is not found in the condition parameters.');
        }

        return $this->evalIsTrue($status);
    }
}
