<?php

namespace Admin\ActivityTypes;

use Admin\Models\Orders_model;
use Admin\Models\Status_history_model;
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
    public function __construct(Orders_model $order, User $user)
    {
        $this->order = $order;
        $this->user = $user;
    }

    public static function pushActivityLog(Status_history_model $model, Orders_model $object)
    {
        if (!$object->isDirty('status_id') OR !$object->status_id)
            return;

        $user = AdminAuth::user();
        if ($user->getKey() != $model->assignee_id AND $sendTo = $model->assignee)
            activity()->pushLog(new self($object, $user), [$sendTo->user]);

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
        return lang('admin::lang.orders.activity_event_log');
    }
}
