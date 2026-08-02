<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps\Console;

class UpgradeCommand extends InstallCommand
{
    protected $signature = 'restaurant-ops:upgrade {--force}';

    protected $description = 'Preflight and upgrade RestaurantOps through the native TastyIgniter lifecycle';
}
