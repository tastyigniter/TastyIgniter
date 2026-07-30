<?php

declare(strict_types=1);

namespace Igniter\Reservation\Notifications;

use Igniter\Reservation\Models\Reservation;
use Igniter\User\Classes\Notification;
use Igniter\User\Models\User;
use Override;

/**
 * ReservationCreatedNotification Class
 *
 * @property Reservation|null $subject
 */
class ReservationCreatedNotification extends Notification
{
    #[Override]
    public function getRecipients(): array
    {
        return User::query()->whereIsEnabled()
            ->whereHasOrDoesntHaveLocation($this->subject->location->getKey())
            ->get()->all();
    }

    #[Override]
    public function getTitle(): string
    {
        return lang('igniter.reservation::default.notify_reservation_created_title');
    }

    #[Override]
    public function getUrl(): string
    {
        $url = 'reservations';
        if ($this->subject) {
            $url .= '/edit/'.$this->subject->getKey();
        }

        return admin_url($url);
    }

    #[Override]
    public function getMessage(): string
    {
        return sprintf(lang('igniter.reservation::default.notify_reservation_created'), $this->subject->customer_name);
    }

    #[Override]
    public function getIcon(): ?string
    {
        return 'fa-chair';
    }

    #[Override]
    public function getAlias(): string
    {
        return 'reservation-created';
    }
}
