<?php

declare(strict_types=1);

namespace Igniter\Flame\Pagic\Contracts;

interface TemplateInterface
{
    /**
     * Loads the template.
     */
    public static function load(string $source, string $fileName): mixed;

    /**
     * Loads and caches the template.
     */
    public static function loadCached(string $source, string $fileName): mixed;

    /**
     * Returns the local file path to the template.
     */
    public function getFilePath(?string $fileName = null): ?string;

    /**
     * Returns the file name.
     */
    public function getFileName(): ?string;

    /**
     * Returns the file name without the extension.
     */
    public function getBaseFileName(): ?string;

    /**
     * Returns the file content.
     */
    public function getContent(): ?string;

    /**
     * Gets the markup section of a template
     */
    public function getMarkup(): ?string;

    /**
     * Gets the code section of a template
     */
    public function getCode(): ?string;

    /**
     * Returns the key used by the Template cache.
     */
    public function getTemplateCacheKey(): ?string;
}
