<?php

declare(strict_types=1);

namespace Square\Models;

class CatalogDiscountModifyTaxBasis
{
    /**
     * Application of the discount will modify the tax basis.
     */
    public const MODIFY_TAX_BASIS = 'MODIFY_TAX_BASIS';

    /**
     * Application of the discount will not modify the tax basis.
     */
    public const DO_NOT_MODIFY_TAX_BASIS = 'DO_NOT_MODIFY_TAX_BASIS';
}
