<?php

namespace Stevebauman\Purify\Definitions;

use HTMLPurifier_HTMLDefinition;

interface Definition
{
    /**
     * Apply rules to the HTML Purifier definition.
     *
     * @param HTMLPurifier_HTMLDefinition $definition
     *
     * @return void
     */
    public static function apply(HTMLPurifier_HTMLDefinition $definition);
}
