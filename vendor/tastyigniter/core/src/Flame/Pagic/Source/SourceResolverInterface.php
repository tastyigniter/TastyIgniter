<?php

declare(strict_types=1);

namespace Igniter\Flame\Pagic\Source;

interface SourceResolverInterface
{
    /**
     * Get a source instance.
     */
    public function source(?string $name = null): SourceInterface;

    /**
     * Add a source to the resolver.
     */
    public function addSource(string $name, SourceInterface $source): void;

    /**
     * Check if a source has been registered.
     */
    public function hasSource(string $name): bool;

    /**
     * Get the default source name.
     */
    public function getDefaultSourceName(): string;

    /**
     * Set the default source name.
     */
    public function setDefaultSourceName(string $name);
}
