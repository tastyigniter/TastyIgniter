<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CatalogObjectBatch;

/**
 * Builder for model CatalogObjectBatch
 *
 * @see CatalogObjectBatch
 */
class CatalogObjectBatchBuilder
{
    /**
     * @var CatalogObjectBatch
     */
    private $instance;

    private function __construct(CatalogObjectBatch $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new catalog object batch Builder object.
     */
    public static function init(array $objects): self
    {
        return new self(new CatalogObjectBatch($objects));
    }

    /**
     * Initializes a new catalog object batch object.
     */
    public function build(): CatalogObjectBatch
    {
        return CoreHelper::clone($this->instance);
    }
}
