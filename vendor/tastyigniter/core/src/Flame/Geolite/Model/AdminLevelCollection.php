<?php

declare(strict_types=1);

namespace Igniter\Flame\Geolite\Model;

use Igniter\Flame\Geolite\Exception\GeoliteException;
use Illuminate\Support\Collection;

class AdminLevelCollection extends Collection
{
    public const MAX_LEVEL_DEPTH = 5;

    /**
     * @param AdminLevel[] $items
     */
    public function __construct(array $items = [])
    {
        $this->items = $this->validateAdminLevels($items);
    }

    protected function checkLevel(int $level)
    {
        if ($level <= 0 || $level > self::MAX_LEVEL_DEPTH) {
            throw new GeoliteException(sprintf(
                'Administrative level should be an integer in [1,%d], %d given',
                self::MAX_LEVEL_DEPTH, $level,
            ));
        }
    }

    protected function validateAdminLevels(array $items): array
    {
        $levels = [];
        foreach ($items as $adminLevel) {
            $level = $adminLevel->getLevel();
            $this->checkLevel($level);

            if (isset($levels[$level])) {
                throw new GeoliteException(sprintf('Administrative level %d is defined twice', $level));
            }

            $levels[$level] = $adminLevel;
        }

        ksort($levels, SORT_NUMERIC);

        return $levels;
    }
}
