<?php

declare(strict_types=1);

namespace Igniter\Cart\Notifications;

use Igniter\Flame\Database\Model;
use Igniter\User\Classes\Notification;
use Igniter\User\Models\User;
use Override;

class OrderCreatedNotification extends Notification
{
    #[Override]
    public function getRecipients(): array
    {
        return User::query()->whereIsEnabled()
            ->whereHasOrDoesntHaveLocation($this->subject->location?->getKey())
            ->get()->all();
    }

    #[Override]
    public function getTitle(): string
    {
        return lang('igniter.cart::default.checkout.notify_order_created_title');
    }

    #[Override]
    public function getUrl(): string
    {
        $url = 'orders';
        if ($this->subject instanceof Model) {
            $url .= '/edit/'.$this->subject->getKey();
        }

        return admin_url($url);
    }

    #[Override]
    public function getMessage(): string
    {
        return sprintf(lang('igniter.cart::default.checkout.notify_order_created'), $this->subject->customer_name);
    }

    #[Override]
    public function getIcon(): ?string
    {
        return 'fa-clipboard-list';
    }

    #[Override]
    public function getAlias(): string
    {
        return 'order-created';
    }
}
