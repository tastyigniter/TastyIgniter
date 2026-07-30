<?php

declare(strict_types=1);

namespace Igniter\Automation\AutomationRules\Actions;

use Igniter\Automation\AutomationException;
use Igniter\Automation\Classes\BaseAction;
use Igniter\User\Models\Concerns\Assignable;
use Igniter\User\Models\UserGroup;
use Override;

class AssignToGroup extends BaseAction
{
    #[Override]
    public function actionDetails(): array
    {
        return [
            'name' => 'Assign to staff group',
            'description' => 'Automatically assign an order/reservation to a staff group',
        ];
    }

    #[Override]
    public function defineFormFields(): array
    {
        return [
            'fields' => [
                'staff_group_id' => [
                    'label' => 'lang:igniter.automation::default.label_assign_to_staff_group',
                    'type' => 'select',
                    'options' => UserGroup::getDropdownOptions(...),
                ],
            ],
        ];
    }

    #[Override]
    public function triggerAction($params): void
    {
        if (!$groupId = $this->model->staff_group_id) {
            throw new AutomationException('AssignToGroup: Missing valid staff group to assign to.');
        }

        if (!$assigneeGroup = UserGroup::find($groupId)) {
            throw new AutomationException('AssignToGroup: Invalid staff group to assign to.');
        }

        $assignable = array_get($params, 'order', array_get($params, 'reservation'));
        if (!$assignable || !in_array(Assignable::class, class_uses_recursive($assignable::class))) {
            throw new AutomationException('AssignToGroup: Missing assignable model.');
        }

        $assignable->assignToGroup($assigneeGroup);
    }
}
