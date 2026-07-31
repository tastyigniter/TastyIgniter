<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps\MenuConfiguration\Support;

use Naxas\RestaurantOps\MenuConfiguration\Exceptions\InvalidConfiguration;

final readonly class Context
{
    public const array SERVICE_TYPES = ['dine_in', 'delivery', 'collection', 'takeaway'];

    public const array CHANNELS = ['storefront', 'pos', 'waiter', 'kiosk', 'api'];

    public function __construct(public int $locationId, public string $serviceType, public string $channel)
    {
        if ($locationId < 1) {
            throw new InvalidConfiguration('A concrete transaction location is required.');
        }
        if (! in_array($serviceType, self::SERVICE_TYPES, true)) {
            throw new InvalidConfiguration('Unsupported service type.');
        }
        if (! in_array($channel, self::CHANNELS, true)) {
            throw new InvalidConfiguration('Unsupported channel.');
        }
    }

    public function officialServiceType(): string
    {
        return $this->serviceType === 'takeaway' ? 'collection' : $this->serviceType;
    }
}
