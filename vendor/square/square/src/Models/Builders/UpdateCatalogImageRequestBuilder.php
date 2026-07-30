<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\UpdateCatalogImageRequest;

/**
 * Builder for model UpdateCatalogImageRequest
 *
 * @see UpdateCatalogImageRequest
 */
class UpdateCatalogImageRequestBuilder
{
    /**
     * @var UpdateCatalogImageRequest
     */
    private $instance;

    private function __construct(UpdateCatalogImageRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new update catalog image request Builder object.
     */
    public static function init(string $idempotencyKey): self
    {
        return new self(new UpdateCatalogImageRequest($idempotencyKey));
    }

    /**
     * Initializes a new update catalog image request object.
     */
    public function build(): UpdateCatalogImageRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
