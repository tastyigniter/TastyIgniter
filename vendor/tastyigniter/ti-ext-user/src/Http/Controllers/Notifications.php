<?php

declare(strict_types=1);

namespace Igniter\User\Http\Controllers;

use Igniter\Admin\Classes\AdminController;
use Igniter\Admin\Http\Actions\ListController;
use Igniter\User\Models\Notification;
use Illuminate\Http\RedirectResponse;

/**
 * @mixin ListController
 */
class Notifications extends AdminController
{
    public array $implement = [
        ListController::class,
    ];

    public array $listConfig = [
        'list' => [
            'model' => Notification::class,
            'title' => 'lang:igniter.user::default.notifications.text_title',
            'emptyMessage' => 'lang:igniter.user::default.notifications.text_empty',
            'defaultSort' => ['updated_at', 'DESC'],
            'configFile' => 'notification',
        ],
    ];

    protected null|string|array $requiredPermissions = 'Admin.Notifications';

    public static function getSlug(): string
    {
        return 'notifications';
    }

    public function onMarkAsRead(): RedirectResponse
    {
        $this->currentUser->unreadNotifications()->update(['read_at' => now()]);

        return $this->redirectBack();
    }

    public function listExtendQuery($query): void
    {
        $query->whereNotifiable($this->currentUser);
    }
}
