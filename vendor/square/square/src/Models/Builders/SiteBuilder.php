<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\Site;

/**
 * Builder for model Site
 *
 * @see Site
 */
class SiteBuilder
{
    /**
     * @var Site
     */
    private $instance;

    private function __construct(Site $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new site Builder object.
     */
    public static function init(): self
    {
        return new self(new Site());
    }

    /**
     * Sets id field.
     */
    public function id(?string $value): self
    {
        $this->instance->setId($value);
        return $this;
    }

    /**
     * Sets site title field.
     */
    public function siteTitle(?string $value): self
    {
        $this->instance->setSiteTitle($value);
        return $this;
    }

    /**
     * Unsets site title field.
     */
    public function unsetSiteTitle(): self
    {
        $this->instance->unsetSiteTitle();
        return $this;
    }

    /**
     * Sets domain field.
     */
    public function domain(?string $value): self
    {
        $this->instance->setDomain($value);
        return $this;
    }

    /**
     * Unsets domain field.
     */
    public function unsetDomain(): self
    {
        $this->instance->unsetDomain();
        return $this;
    }

    /**
     * Sets is published field.
     */
    public function isPublished(?bool $value): self
    {
        $this->instance->setIsPublished($value);
        return $this;
    }

    /**
     * Unsets is published field.
     */
    public function unsetIsPublished(): self
    {
        $this->instance->unsetIsPublished();
        return $this;
    }

    /**
     * Sets created at field.
     */
    public function createdAt(?string $value): self
    {
        $this->instance->setCreatedAt($value);
        return $this;
    }

    /**
     * Sets updated at field.
     */
    public function updatedAt(?string $value): self
    {
        $this->instance->setUpdatedAt($value);
        return $this;
    }

    /**
     * Initializes a new site object.
     */
    public function build(): Site
    {
        return CoreHelper::clone($this->instance);
    }
}
