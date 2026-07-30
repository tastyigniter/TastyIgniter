<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\BatchUpsertCatalogObjectsRequest;

/**
 * Builder for model BatchUpsertCatalogObjectsRequest
 *
 * @see BatchUpsertCatalogObjectsRequest
 */
class BatchUpsertCatalogObjectsRequestBuilder
{
    /**
     * @var BatchUpsertCatalogObjectsRequest
     */
    private $instance;

    private function __construct(BatchUpsertCatalogObjectsRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new batch upsert catalog objects request Builder object.
     */
    public static function init(string $idempotencyKey, array $batches): self
    {
        return new self(new BatchUpsertCatalogObjectsRequest($idempotencyKey, $batches));
    }

    /**
     * Initializes a new batch upsert catalog objects request object.
     */
    public function build(): BatchUpsertCatalogObjectsRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
