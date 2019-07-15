<?php

namespace Admin\ActivityTypes;

use Admin\Models\Reservations_model;
use AdminAuth;
use Igniter\Flame\ActivityLog\Contracts\ActivityInterface;
use Igniter\Flame\ActivityLog\Models\Activity;
use Igniter\Flame\Auth\Models\User;

class ReservationAssigned implements ActivityInterface
{
    public $reservation;

    public $user;

    public function __construct(Reservations_model $reservation, User $user)
    {
        $this->reservation = $reservation;
        $this->user = $user;
    }

    public static function pushActivityLog(Reservations_model $model)
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
        return $this->reservation;
    }

    /**
     * {@inheritdoc}
     */
    public function getProperties()
    {
        return [
            'reservation_id' => $this->reservation->reservation_id,
            'assignee_id' => $this->reservation->assignee_id,
            'assignee_name' => $this->reservation->assignee->staff_name,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function getType()
    {
        return 'reservationAssigned';
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
        return lang('admin::lang.reservations.activity_event_log_assigned');
    }
}
