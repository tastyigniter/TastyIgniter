<?php

namespace Admin\ActivityTypes;

use Admin\Models\Orders_model;
use AdminAuth;
use Igniter\Flame\ActivityLog\Contracts\ActivityInterface;
use Igniter\Flame\ActivityLog\Models\Activity;
use Igniter\Flame\Auth\Models\User;

class OrderAssigned implements ActivityInterface
{
    public $order;

    public $user;

    public function __construct(Orders_model $order, User $user)
    {
        $this->order = $order;
        $this->user = $user;
    }

    public static function pushActivityLog(Orders_model $model)
    {
        if (!$model->isDirty('assignee_id') OR !$model->assignee_id)
            return;

        $model->load('assignee');
        $user = AdminAuth::user();
        if ($user->getKey() != $model->assignee_id AND $sendTo = $model->assignee)
            activity()->pushLog(new self($model, $user), [$sendTo->user]);
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
            'assignee_name' => $this->order->assignee->staff_name,
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
        return lang('admin::lang.orders.activity_event_log_assigned');
    }
}
