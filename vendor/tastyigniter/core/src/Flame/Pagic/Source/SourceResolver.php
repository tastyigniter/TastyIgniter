<?php

declare(strict_types=1);

namespace Igniter\Flame\Pagic\Source;

use Override;

class SourceResolver implements SourceResolverInterface
{
    /**
     * All the registered sources.
     */
    protected array $sources = [];

    /**
     * The default source name.
     */
    protected ?string $default = null;

    /**
     * Create a new source resolver instance.
     */
    public function __construct(array $sources = [])
    {
        foreach ($sources as $name => $source) {
            $this->addSource($name, $source);
        }
    }

    /**
     * Get a source instance.
     */
    #[Override]
    public function source(?string $name = null): SourceInterface
    {
        if (is_null($name)) {
            $name = $this->getDefaultSourceName();
        }

        return $this->sources[$name];
    }

    /**
     * Add a source to the resolver.
     */
    #[Override]
    public function addSource(string $name, SourceInterface $source): void
    {
        $this->sources[$name] = $source;
    }

    /**
     * Check if a source has been registered.
     */
    #[Override]
    public function hasSource(string $name): bool
    {
        return isset($this->sources[$name]);
    }

    /**
     * Get the default source name.
     */
    #[Override]
    public function getDefaultSourceName(): string
    {
        return $this->default;
    }

    /**
     * Set the default source name.
     */
    #[Override]
    public function setDefaultSourceName(string $name): void
    {
        $this->default = $name;
    }
}
