<?php

declare(strict_types=1);

namespace Igniter\Broadcast;

use Igniter\Broadcast\Classes\Manager;
use Igniter\Broadcast\Models\Settings;
use Igniter\System\Classes\BaseExtension;
use Override;

/**
 * Broadcast Extension Information File
 */
class Extension extends BaseExtension
{
    public array $singletons = [
        Manager::class,
    ];

    #[Override]
    public function register(): void
    {
        parent::register();

        resolve(Manager::class)->register($this->app);
    }

    #[Override]
    public function boot(): void
    {
        resolve(Manager::class)->boot($this->app);
    }

    #[Override]
    public function registerSettings(): array
    {
        return [
            'settings' => [
                'label' => 'Broadcast Settings',
                'description' => 'Manage pusher api and cluster settings.',
                'icon' => 'fa fa-bullhorn',
                'model' => Settings::class,
            ],
        ];
    }

    public function registerEventBroadcasts(): array
    {
        return [];
    }
}
