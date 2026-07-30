<?php

declare(strict_types=1);

namespace Igniter\Flame\Currency\Contracts;

use DateTime;

interface DriverInterface
{
    /**
     * Create a new currency.
     */
    public function create(array $params): bool;

    /**
     * Get all currencies.
     */
    public function all(): array;

    /**
     * Get given currency from storage.
     */
    public function find(string $code, int $active = 1): mixed;

    /**
     * Update given currency.
     */
    public function update(string $code, array $attributes, ?DateTime $timestamp = null): int;

    /**
     * Remove given currency from storage.
     */
    public function delete(string $code): int;
}
