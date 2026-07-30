<?php

declare(strict_types=1);

namespace Square\Models;

/**
 * The level of permission that a seller or other applications requires to
 * view this custom attribute definition.
 * The `Visibility` field controls who can read and write the custom attribute values
 * and custom attribute definition.
 */
class CustomAttributeDefinitionVisibility
{
    /**
     * The custom attribute definition and values are hidden from the seller (except on export
     * of all seller data) and other developers.
     */
    public const VISIBILITY_HIDDEN = 'VISIBILITY_HIDDEN';

    /**
     * The seller and other developers can read the custom attribute definition and values
     * on resources.
     */
    public const VISIBILITY_READ_ONLY = 'VISIBILITY_READ_ONLY';

    /**
     * The seller and other developers can read the custom attribute definition,
     * and can read and write values on resources. A custom attribute definition
     * can only be edited or deleted by the application that created it.
     */
    public const VISIBILITY_READ_WRITE_VALUES = 'VISIBILITY_READ_WRITE_VALUES';
}
