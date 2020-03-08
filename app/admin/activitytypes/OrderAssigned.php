<?php

namespace Admin\ActivityTypes;

use Admin\Helpers\ActivityMessage;
use Admin\Models\Orders_model;
use AdminAuth;
use Igniter\Flame\ActivityLog\Contracts\ActivityInterface;
use Igniter\Flame\ActivityLog\Models\Activity;
use Igniter\Flame\Auth\Models\User;

class OrderAssigned implements ActivityInterface
{
    public $order;

    public $user;

    public function __construct(Orders_model $order, User $user = null)
    {
        $this->order = $order;
        $this->user = $user;
    }

    /**
     * @param \Admin\Models\Orders_model|mixed $order
     */
    public static function log(Orders_model $order)
    {
        $staffId = AdminAuth::staff()->getKey();
        $assignees = $order->listAssignableGroupStaff();

        $recipients = [];
        foreach ($order->listGroupAssignees() as $assignee) {
            if ($assignee->getKey() === optional(AdminAuth::staff())->getKey()) continue;
            $recipients[] = $assignee->user;
        }

        activity()->logActivity(new self($order, AdminAuth::user()), $recipients);
    }

    /**
     * {@inheritdoc}
     */
    public function getCauser()
    {
        return $this->user;
    }

    /**
     * {@inheritdoc}
     */
    public function getSubject()
    {
        return $this->order;
    }

    /**
     * {@inheritdoc}
     */
    public function getProperties()
    {
        return [
            'order_id' => $this->order->order_id,
            'assignee_id' => $this->order->assignee_id,
            'assignee_name' => optional($this->order->assignee)->staff_name,
            'assignee_group_id' => $this->order->assignee_group_id,
            'assignee_group_name' => optional($this->order->assignee_group)->staff_group_name,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function getType()
    {
        return 'orderAssigned';
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubjectModel()
    {
        return Orders_model::class;
    }

    public static function getUrl(Activity $activity)
    {
        $url = 'orders';
        if ($activity->subject)
            $url .= '/edit/'.$activity->subject->order_id;

        return admin_url($url);
    }

    public static function getMessage(Activity $activity)
    {
        return ActivityMessage::attachAssignedPlaceholders(
            'admin::lang.orders.activity_event_log_assigned', $activity
        );
    }
}
