<?php

declare(strict_types=1);

namespace Igniter\User\MainMenuWidgets;

use Igniter\Admin\Classes\BaseMainMenuWidget;
use Override;

class NotificationList extends BaseMainMenuWidget
{
    #[Override]
    public function render(): string
    {
        $this->prepareVars();

        return $this->makePartial('notificationlist/notificationlist');
    }

    public function prepareVars(): void
    {
        $user = $this->getController()->getUser();
        $this->vars['unreadCount'] = $user->unreadNotifications()->count();
    }

    public function onDropdownOptions(): array
    {
        $user = $this->getController()->getUser();
        $this->vars['notifications'] = $user->notifications()->get();

        return [
            '#'.$this->getId('options') => $this->makePartial('notificationlist/items'),
        ];
    }

    public function onMarkAsRead(): array
    {
        $user = $this->getController()->getUser();

        $user->unreadNotifications()->update(['read_at' => now()]);

        // Return a partial if item has a path defined
        return [
            '~#'.$this->getId() => $this->render(),
        ];
    }
}
