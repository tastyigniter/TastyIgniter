<?php

namespace Admin\ActivityTypes;

use Admin\Helpers\ActivityMessage;
use Admin\Models\Status_history_model;
use Igniter\Flame\ActivityLog\Contracts\ActivityInterface;
use Igniter\Flame\ActivityLog\Models\Activity;
use Igniter\Flame\Auth\Models\User;
use Illuminate\Database\Eloquent\Model;

class StatusUpdated implements ActivityInterface
{
    public const ORDER_UPDATED_TYPE = 'orderStatusUpdated';

    public const RESERVATION_UPDATED_TYPE = 'reservationStatusUpdated';

    public $type;

    public $subject;

    public $causer;

    public function __construct(string $type, Model $subject, User $causer = null)
    {
        $this->type = $type;
        $this->subject = $subject;
        $this->causer = $causer;
    }

    /**
     * @param \Admin\Models\Status_history_model $history
     * @param \Igniter\Flame\Auth\Models\User|null $user
     */
    public static function log(Status_history_model $history, User $user = null)
    {
        $type = $history->isForOrder() ? self::ORDER_UPDATED_TYPE : self::RESERVATION_UPDATED_TYPE;

        $recipients = [];
        if ($history->object->assignee AND $history->object->assignee->getKey() !== $user->staff->getKey())
            $recipients[] = $history->object->assignee->user;

        $statusHistory = $history->object->getLatestStatusHistory();
        if ($history->object->customer AND $statusHistory AND $statusHistory->notify)
            $recipients[] = $history->object->customer;

        activity()->logActivity(new self($type, $history->object, $user), $recipients);
    }

    /**
     * @inheritDoc
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * {@inheritdoc}
     */
    public function getCauser()
    {
        return $this->causer;
    }

    /**
     * {@inheritdoc}
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * {@inheritdoc}
     */
    public function getProperties()
    {
        $keyName = $this->type == self::ORDER_UPDATED_TYPE ? 'order_id' : 'reservation_id';

        return [
            $keyName => $this->subject->getKey(),
            'status_id' => $this->subject->status_id,
            'status_name' => optional($this->subject->status)->status_name,
        ];
    }

    public static function getTitle(Activity $activity)
    {
        return lang($activity->type == self::ORDER_UPDATED_TYPE
            ? 'admin::lang.orders.activity_event_log_title'
            : 'admin::lang.reservations.activity_event_log_title');
    }

    public static function getUrl(Activity $activity)
    {
        $url = $activity->type == self::ORDER_UPDATED_TYPE ? 'orders' : 'reservations';
        if ($activity->subject)
            $url .= '/edit/'.$activity->subject->getKey();

        return admin_url($url);
    }

    public static function getMessage(Activity $activity)
    {
        $lang = $activity->type == self::ORDER_UPDATED_TYPE
            ? 'admin::lang.orders.activity_event_log'
            : 'admin::lang.reservations.activity_event_log';

        return ActivityMessage::attachCauserPlaceholders($lang, $activity);
    }
}
