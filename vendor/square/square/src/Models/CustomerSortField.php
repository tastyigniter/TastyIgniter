<?php

declare(strict_types=1);

namespace Square\Models;

/**
 * Specifies customer attributes as the sort key to customer profiles returned from a search.
 */
class CustomerSortField
{
    /**
     * Use the default sort key. By default, customers are sorted
     * alphanumerically by concatenating their `given_name` and `family_name`. If
     * neither name field is set, string comparison is performed using one of the
     * remaining fields in the following order: `company_name`, `email`,
     * `phone_number`.
     */
    public const DEFAULT_ = 'DEFAULT';

    /**
     * Use the creation date attribute (`created_at`) of customer profiles as the sort key.
     */
    public const CREATED_AT = 'CREATED_AT';
}
