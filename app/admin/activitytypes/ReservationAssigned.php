<?php

namespace Admin\ActivityTypes;

use Admin\Helpers\ActivityMessage;
use Admin\Models\Reservations_model;
use AdminAuth;
use Igniter\Flame\ActivityLog\Contracts\ActivityInterface;
use Igniter\Flame\ActivityLog\Models\Activity;
use Igniter\Flame\Auth\Models\User;

class ReservationAssigned implements ActivityInterface
{
    public $reservation;

    public $user;

    public function __construct(Reservations_model $reservation, User $user = null)
    {
        $this->reservation = $reservation;
        $this->user = $user;
    }

    /**
     * @param \Admin\Models\Reservations_model|mixed $reservation
     */
    public static function log($reservation)
    {
        $user = AdminAuth::user();

        $recipients = [];
        foreach ($reservation->listGroupAssignees() as $assignee) {
            if ($assignee->getKey() === $user->staff->getKey()) continue;
            $recipients[] = $assignee->user;
        }

        activity()->logActivity(new self($reservation, $user), $recipients);
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
        return ActivityMessage::attachAssignedPlaceholders(
            'admin::lang.reservations.activity_event_log_assigned', $activity
        );
    }
}
