<?php

declare(strict_types=1);

namespace Igniter\User\Notifications;

use Igniter\Cart\Models\Order;
use Igniter\User\Classes\Notification;
use Igniter\User\Facades\AdminAuth;
use Override;

/**
 * AssigneeUpdatedNotification
 */
class AssigneeUpdatedNotification extends Notification
{
    #[Override]
    public function getRecipients(): array
    {
        $recipients = [];
        if (!$this->subject->assignee && $this->subject->assignee_group) {
            foreach ($this->subject->assignable->listGroupAssignees() as $assignee) {
                if (AdminAuth::user() && $assignee->getKey() === AdminAuth::user()->getKey()) {
                    continue;
                }

                $recipients[] = $assignee;
            }
        }

        if ($this->subject->assignee) {
            $recipients[] = $this->subject->assignee;
        }

        return $recipients;
    }

    #[Override]
    public function getTitle(): string
    {
        return $this->subject->assignable instanceof Order
            ? lang('igniter.cart::default.orders.notify_assigned_title')
            : lang('igniter.reservation::default.notify_assigned_title');
    }

    #[Override]
    public function getUrl(): string
    {
        $url = $this->subject->assignable instanceof Order ? 'orders' : 'reservations';
        $url .= '/edit/'.$this->subject->assignable->getKey();

        return admin_url($url);
    }

    #[Override]
    public function getMessage(): string
    {
        $lang = $this->subject->assignable instanceof Order
            ? lang('igniter.cart::default.orders.notify_assigned')
            : lang('igniter.reservation::default.notify_assigned');

        $causerName = $this->subject->user ? $this->subject->user->full_name : lang('igniter::admin.text_system');

        $assigneeName = '';
        if ($this->subject->assignee) {
            $assigneeName = lang('igniter::admin.text_you');
        } elseif ($this->subject->assignee_group) {
            $assigneeName = $this->subject->assignee_group->user_group_name;
        }

        return sprintf($lang,
            $causerName,
            $this->subject->assignable->getKey(),
            $assigneeName,
        );
    }

    #[Override]
    public function getIcon(): ?string
    {
        return 'fa-clipboard-user';
    }

    #[Override]
    public function getAlias(): string
    {
        return 'assignee-updated';
    }
}
