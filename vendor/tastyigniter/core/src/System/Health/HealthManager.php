<?php

declare(strict_types=1);

namespace Igniter\System\Health;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Event;

class HealthManager
{
    /** @var array<int, callable> */
    protected static array $callbacks = [];

    /** @var Check[] */
    protected array $checks = [];

    protected bool $loaded = false;

    public static function registerCallback(callable $callback): void
    {
        static::$callbacks[] = $callback;
    }

    public function registerChecks(array $checks): void
    {
        foreach ($checks as $check) {
            $this->checks[] = $check;
        }
    }

    public function run(): Collection
    {
        $this->loadChecks();

        return collect($this->checks)
            ->map(fn(Check $check) => [
                'check' => $check,
                'result' => $check->run(),
            ])
            ->sortBy(fn(array $item) => $item['check']->sortOrder())
            ->values();
    }

    protected function loadChecks(): void
    {
        if ($this->loaded) {
            return;
        }

        foreach (static::$callbacks as $callback) {
            $callback($this);
        }

        Event::dispatch('system.health.registerChecks', [$this]);

        $this->loaded = true;
    }
}
