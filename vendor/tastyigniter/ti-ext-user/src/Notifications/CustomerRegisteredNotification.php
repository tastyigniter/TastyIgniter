<?php

declare(strict_types=1);

namespace Igniter\User\Notifications;

use Igniter\Flame\Database\Model;
use Igniter\User\Classes\Notification;
use Igniter\User\Models\User;
use Override;

class CustomerRegisteredNotification extends Notification
{
    #[Override]
    public function getRecipients(): array
    {
        return User::query()
            ->whereIsEnabled()
            ->whereIsSuperUser()
            ->get()->all();
    }

    #[Override]
    public function getTitle(): string
    {
        return lang('igniter.user::default.login.notify_registered_account_title');
    }

    #[Override]
    public function getUrl(): string
    {
        $url = 'customers';
        if ($this->subject instanceof Model) {
            $url .= '/edit/'.$this->subject->getKey();
        }

        return admin_url($url);
    }

    #[Override]
    public function getMessage(): string
    {
        return sprintf(lang('igniter.user::default.login.notify_registered_account'), $this->subject->full_name);
    }

    #[Override]
    public function getIcon(): ?string
    {
        return 'fa-user';
    }

    #[Override]
    public function getAlias(): string
    {
        return 'customer-registered';
    }
}
