<?php

declare(strict_types=1);

namespace Igniter\Flame\Pagic\Contracts;

interface TemplateLoader
{
    public function getFilename(string $name): ?string;

    /**
     * Gets the markup section of a template, given its name.
     */
    public function getMarkup(string $name): ?string;

    /**
     * Gets the source code of a template, given its name.
     */
    public function getContents(string $name): ?string;

    /**
     * Gets the cache key to use for the cache for a given template name.
     */
    public function getCacheKey(string $name): string;

    /**
     * Returns true if the template is still fresh.
     */
    public function isFresh(string $name, int $time): bool;

    public function exists(string $name): bool;
}
