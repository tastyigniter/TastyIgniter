<?php

namespace Admin\ActivityTypes;

use Admin\Models\Reservations_model;
use Admin\Models\Status_history_model;
use AdminAuth;
use Igniter\Flame\ActivityLog\Contracts\ActivityInterface;
use Igniter\Flame\ActivityLog\Models\Activity;
use Igniter\Flame\Auth\Models\User;

class ReservationStatusUpdated implements ActivityInterface
{
    public $reservation;

    public $user;

    /**
     * ReservationStatusUpdated constructor.
     * @param \Admin\Models\Reservations_model
     * @param \Igniter\Flame\Auth\Models\User $user
     */
    public function __construct(Reservations_model $reservation, User $user)
    {
        $this->reservation = $reservation;
        $this->user = $user;
    }

    public static function pushActivityLog(Status_history_model $model, Reservations_model $object)
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
        return $this->reservation;
    }

    /**
     * {@inheritdoc}
     */
    public function getProperties()
    {
        return [
            'reservation_id' => $this->reservation->reservation_id,
            'status_id' => $this->reservation->status_id,
            'status_name' => $this->reservation->status->status_name,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function getType()
    {
        return 'reservationStatusUpdated';
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubjectModel()
    {
        return Reservations_model::class;
    }

    public static function getUrl(Activity $activity)
    {
        $url = 'reservations';
        if ($activity->subject)
            $url .= '/edit/'.$activity->subject->reservation_id;

        return admin_url($url);
    }

    public static function getMessage(Activity $activity)
    {
        return lang('admin::lang.reservations.activity_event_log');
    }
}
