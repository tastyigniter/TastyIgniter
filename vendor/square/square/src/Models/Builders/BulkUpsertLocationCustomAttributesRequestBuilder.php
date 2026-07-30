<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\BulkUpsertLocationCustomAttributesRequest;

/**
 * Builder for model BulkUpsertLocationCustomAttributesRequest
 *
 * @see BulkUpsertLocationCustomAttributesRequest
 */
class BulkUpsertLocationCustomAttributesRequestBuilder
{
    /**
     * @var BulkUpsertLocationCustomAttributesRequest
     */
    private $instance;

    private function __construct(BulkUpsertLocationCustomAttributesRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new bulk upsert location custom attributes request Builder object.
     */
    public static function init(array $values): self
    {
        return new self(new BulkUpsertLocationCustomAttributesRequest($values));
    }

    /**
     * Initializes a new bulk upsert location custom attributes request object.
     */
    public function build(): BulkUpsertLocationCustomAttributesRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
