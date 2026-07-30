<?php

/*
 * This file is part of the League\Fractal package.
 *
 * (c) Phil Sturgeon <me@philsturgeon.uk>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace League\Fractal;

use League\Fractal\Resource\ResourceInterface;

/**
 * Creates Scope Instances for resources
 */
interface ScopeFactoryInterface
{
    public function createScopeFor(
        Manager $manager,
        ResourceInterface $resource,
        ?string $scopeIdentifier = null
    ): Scope;

    public function createChildScopeFor(
        Manager $manager,
        Scope $parentScope,
        ResourceInterface $resource,
        ?string $scopeIdentifier = null
    ): Scope;
}
