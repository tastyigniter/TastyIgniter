<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps;

use App\Services\LocationContext;
use Igniter\System\Classes\BaseExtension;
use Naxas\RestaurantOps\Contracts\AuditLogger;
use Naxas\RestaurantOps\Contracts\LocationContextContract;
use Naxas\RestaurantOps\Integrations\ActivityLogAdapter;
use Naxas\RestaurantOps\Support\PermissionDefinitions;
use Override;

class Extension extends BaseExtension
{
    #[Override]
    public function register(): void
    {
        parent::register();

        $this->app->scoped(LocationContextContract::class, fn ($app): LocationContextContract => $app->make(LocationContext::class));
        $this->app->singleton(AuditLogger::class, ActivityLogAdapter::class);
    }

    #[Override]
    public function registerPermissions(): array
    {
        return PermissionDefinitions::locationContext();
    }

    #[Override]
    public function registerNavigation(): array
    {
        // Add navigation only when an extension-owned destination exists.
        return [];
    }
}
