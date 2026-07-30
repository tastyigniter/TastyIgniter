<?php

declare(strict_types=1);

namespace Igniter\Flame\Assetic;

use Igniter\Flame\Assetic\Asset\AssetCollection;

class AssetManager
{
    public function makeCollection(array $assets): AssetCollection
    {
        return new AssetCollection($assets, []);
    }
}
