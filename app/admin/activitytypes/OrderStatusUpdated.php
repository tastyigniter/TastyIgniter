<?php

namespace Admin\ActivityTypes;

use Admin\Helpers\ActivityMessage;
use Admin\Models\Orders_model;
use AdminAuth;
use Igniter\Flame\ActivityLog\Contracts\ActivityInterface;
use Igniter\Flame\ActivityLog\Models\Activity;
use Igniter\Flame\Auth\Models\User;

class OrderStatusUpdated implements ActivityInterface
{
    public $order;

    public $user;

    /**
     * OrderStatusUpdated constructor.
     * @param \Admin\Models\Orders_model
     * @param \Igniter\Flame\Auth\Models\User $user
     */
    public function __construct(Orders_model $order, User $user = null)
    {
        $this->order = $order;
        $this->user = $user;
    }

    /**
     * @param \Admin\Models\Orders_model|mixed $order
     */
    public static function log($order)
    {
        $user = AdminAuth::user();

        $recipients = [];
        if ($order->assignee AND $order->assignee->getKey() !== $user->staff->getKey())
            $recipients[] = $order->assignee->user;

        $statusHistory = $order->getLatestStatusHistory();
        if ($order->customer AND $statusHistory AND $statusHistory->notify)
            $recipients[] = $order->customer;

        activity()->logActivity(new self($order, $user), $recipients);
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
            'status_id' => $this->order->status_id,
            'status_name' => $this->order->status->status_name,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function getType()
    {
        return 'orderStatusUpdated';
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
        return ActivityMessage::attachCauserPlaceholders(
            'admin::lang.orders.activity_event_log', $activity
        );
    }
}
