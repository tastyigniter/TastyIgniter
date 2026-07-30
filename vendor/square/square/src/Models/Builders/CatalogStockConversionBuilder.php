<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CatalogStockConversion;

/**
 * Builder for model CatalogStockConversion
 *
 * @see CatalogStockConversion
 */
class CatalogStockConversionBuilder
{
    /**
     * @var CatalogStockConversion
     */
    private $instance;

    private function __construct(CatalogStockConversion $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new catalog stock conversion Builder object.
     */
    public static function init(
        string $stockableItemVariationId,
        string $stockableQuantity,
        string $nonstockableQuantity
    ): self {
        return new self(
            new CatalogStockConversion($stockableItemVariationId, $stockableQuantity, $nonstockableQuantity)
        );
    }

    /**
     * Initializes a new catalog stock conversion object.
     */
    public function build(): CatalogStockConversion
    {
        return CoreHelper::clone($this->instance);
    }
}
