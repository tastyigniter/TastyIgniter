<?php

declare(strict_types=1);

namespace Igniter\System\Notifications;

use Igniter\System\Contracts\StickyNotification;
use Igniter\User\Classes\Notification;
use Igniter\User\Models\User;
use Override;

class SystemUpdateNotification extends Notification implements StickyNotification
{
    public function __construct(protected int $count = 0) {}

    #[Override]
    public function getRecipients(): array
    {
        return User::whereIsEnabled()->whereIsSuperUser()->get()->all();
    }

    #[Override]
    public function getTitle(): string
    {
        return $this->count > 0
            ? lang('igniter::system.updates.notify_new_update_found_title')
            : lang('igniter::system.updates.notify_no_update_found_title');
    }

    #[Override]
    public function getUrl(): string
    {
        return admin_url('updates');
    }

    #[Override]
    public function getMessage(): string
    {
        if ($this->count > 1) {
            return sprintf(lang('igniter::system.updates.notify_new_updates_found'), $this->count);
        }

        if ($this->count === 1) {
            return lang('igniter::system.updates.notify_new_update_found');
        }

        return lang('igniter::system.updates.notify_no_update_found');
    }

    #[Override]
    public function getIcon(): ?string
    {
        return 'fa-cloud-arrow-down';
    }

    #[Override]
    public function getIconColor(): ?string
    {
        return 'success';
    }

    #[Override]
    public function getAlias(): string
    {
        return 'update-found';
    }
}
