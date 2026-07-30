<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\DisputeEvidenceFile;

/**
 * Builder for model DisputeEvidenceFile
 *
 * @see DisputeEvidenceFile
 */
class DisputeEvidenceFileBuilder
{
    /**
     * @var DisputeEvidenceFile
     */
    private $instance;

    private function __construct(DisputeEvidenceFile $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new dispute evidence file Builder object.
     */
    public static function init(): self
    {
        return new self(new DisputeEvidenceFile());
    }

    /**
     * Sets filename field.
     */
    public function filename(?string $value): self
    {
        $this->instance->setFilename($value);
        return $this;
    }

    /**
     * Unsets filename field.
     */
    public function unsetFilename(): self
    {
        $this->instance->unsetFilename();
        return $this;
    }

    /**
     * Sets filetype field.
     */
    public function filetype(?string $value): self
    {
        $this->instance->setFiletype($value);
        return $this;
    }

    /**
     * Unsets filetype field.
     */
    public function unsetFiletype(): self
    {
        $this->instance->unsetFiletype();
        return $this;
    }

    /**
     * Initializes a new dispute evidence file object.
     */
    public function build(): DisputeEvidenceFile
    {
        return CoreHelper::clone($this->instance);
    }
}
