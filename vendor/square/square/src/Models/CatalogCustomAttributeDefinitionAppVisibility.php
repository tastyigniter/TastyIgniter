<?php

declare(strict_types=1);

namespace Square\Models;

/**
 * Defines the visibility of a custom attribute to applications other than their
 * creating application.
 */
class CatalogCustomAttributeDefinitionAppVisibility
{
    /**
     * Other applications cannot read this custom attribute.
     */
    public const APP_VISIBILITY_HIDDEN = 'APP_VISIBILITY_HIDDEN';

    /**
     * Other applications can read this custom attribute definition and
     * values.
     */
    public const APP_VISIBILITY_READ_ONLY = 'APP_VISIBILITY_READ_ONLY';

    /**
     * Other applications can read and write custom attribute values on objects.
     * They can read but cannot edit the custom attribute definition.
     */
    public const APP_VISIBILITY_READ_WRITE_VALUES = 'APP_VISIBILITY_READ_WRITE_VALUES';
}
