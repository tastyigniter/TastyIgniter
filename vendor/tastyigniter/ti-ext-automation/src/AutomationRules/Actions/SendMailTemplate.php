<?php

declare(strict_types=1);

namespace Igniter\Automation\AutomationRules\Actions;

use Facades\Igniter\System\Helpers\MailHelper;
use Igniter\Automation\AutomationException;
use Igniter\Automation\Classes\BaseAction;
use Igniter\System\Models\MailTemplate;
use Igniter\User\Models\Customer;
use Igniter\User\Models\CustomerGroup;
use Igniter\User\Models\User;
use Igniter\User\Models\UserGroup;
use Illuminate\Support\Facades\DB;
use Override;

class SendMailTemplate extends BaseAction
{
    #[Override]
    public function actionDetails(): array
    {
        return [
            'name' => 'Compose a mail template',
            'description' => 'Send a message to a recipient',
        ];
    }

    #[Override]
    public function defineFormFields(): array
    {
        return [
            'fields' => [
                'template' => [
                    'label' => 'lang:igniter.user::default.label_template',
                    'type' => 'select',
                ],
                'send_to' => [
                    'label' => 'lang:igniter.user::default.label_send_to',
                    'type' => 'select',
                ],
                'staff_group' => [
                    'label' => 'lang:igniter.user::default.label_send_to_staff_group',
                    'type' => 'select',
                    'options' => UserGroup::getDropdownOptions(...),
                    'trigger' => [
                        'action' => 'show',
                        'field' => 'send_to',
                        'condition' => 'value[staff_group]',
                    ],
                ],
                'customer_group' => [
                    'label' => 'lang:igniter.automation::default.label_send_to_customer_group',
                    'type' => 'select',
                    'options' => CustomerGroup::getDropdownOptions(...),
                    'trigger' => [
                        'action' => 'show',
                        'field' => 'send_to',
                        'condition' => 'value[customer_group]',
                    ],
                ],
                'custom' => [
                    'label' => 'lang:igniter.user::default.label_send_to_custom',
                    'type' => 'text',
                    'trigger' => [
                        'action' => 'show',
                        'field' => 'send_to',
                        'condition' => 'value[custom]',
                    ],
                ],
            ],
        ];
    }

    #[Override]
    public function triggerAction($params): void
    {
        if (!$templateCode = $this->model->template) {
            throw new AutomationException('SendMailTemplate: Missing a valid mail template');
        }

        if (!$recipient = $this->getRecipientAddress($params)) {
            throw new AutomationException('SendMailTemplate: Missing a valid recipient from the event payload');
        }

        foreach ($recipient as $address => $name) {
            if (empty($address)) {
                continue;
            }

            MailHelper::sendTemplate($templateCode, $params, [$address, $name]);
        }
    }

    public function getTemplateOptions()
    {
        return MailTemplate::dropdown('label', 'code');
    }

    public function getSendToOptions(): array
    {
        return [
            'custom' => 'lang:igniter.user::default.text_send_to_custom',
            'restaurant' => 'lang:igniter.user::default.text_send_to_restaurant',
            'location' => 'lang:igniter.user::default.text_send_to_location',
            'staff' => 'lang:igniter.user::default.text_send_to_staff_email',
            'customer' => 'lang:igniter.user::default.text_send_to_customer_email',
            'customer_group' => 'lang:igniter.user::default.text_send_to_customer_group',
            'staff_group' => 'lang:igniter.user::default.text_send_to_staff_group',
            'all_staff' => 'lang:igniter.user::default.text_send_to_all_staff',
            'all_customer' => 'lang:igniter.user::default.text_send_to_all_customer',
        ];
    }

    protected function getRecipientAddress(array $params)
    {
        $mode = $this->model->send_to;

        switch ($mode) {
            case 'custom':
                return [$this->model->custom => ''];
            case 'system':
                $name = config('mail.from.name', 'Your Site');
                $address = config('mail.from.address', 'admin@domain.tld');

                return [$address => $name];
            case 'restaurant':
                $name = setting('site_name', config('app.name'));
                $address = setting('site_email', config('mail.from.address'));

                return [$address => $name];
            case 'location':
                $location = array_get($params, 'location');

                return [$location->location_email => $location->location_name];
            case 'staff_group':
                $groupId = $this->model->staff_group;
                if (!$groupId || !$staffGroup = UserGroup::find($groupId)) {
                    throw new AutomationException('SendMailTemplate: Unable to find staff group with ID: '.$groupId);
                }

                /** @var UserGroup $staffGroup */
                return $staffGroup->users()->whereIsEnabled()->lists('name', 'email');
            case 'customer_group':
                $groupId = $this->model->customer_group;
                if (!$groupId || !$customerGroup = CustomerGroup::find($groupId)) {
                    throw new AutomationException('SendMailTemplate: Unable to find customer group with ID: '.$groupId);
                }

                /** @var CustomerGroup $customerGroup */
                return $customerGroup->customers()
                    ->select('email', DB::raw('concat(first_name, last_name) as full_name'))
                    ->whereIsEnabled()
                    ->pluck('full_name', 'email')
                    ->all();
            case 'customer':
                $customer = array_get($params, 'customer');
                if (!empty($customer->email) && !empty($customer->full_name)) {
                    return [$customer->email => $customer->full_name];
                }

                $fullName = array_get($params, 'first_name').' '.array_get($params, 'last_name');
                if (array_key_exists('email', $params)) {
                    return [$params['email'] => $fullName];
                }

                throw new AutomationException('SendMailTemplate: Missing a valid customer email address');
            case 'staff':
                $staff = array_get($params, 'staff');
                if (!empty($staff->email) && !empty($staff->name)) {
                    return [$staff->email => $staff->name];
                }

                $orderOrReservation = array_get($params, 'order', array_get($params, 'reservation'));
                if ($orderOrReservation && $staff = $orderOrReservation->assignee) {
                    return [$staff->email => $staff->name];
                }

                throw new AutomationException('SendMailTemplate: Missing a valid staff email address');
            case 'all_staff':
                return User::whereIsEnabled()->pluck('name', 'email')->all();
            case 'all_customer':
                return Customer::whereIsEnabled()
                    ->selectRaw('email, concat(first_name, last_name) as full_name')
                    ->pluck('full_name', 'email')
                    ->all();
        }

        return null;
    }
}
