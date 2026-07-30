<?php

declare(strict_types=1);

namespace Igniter\Flame\Translation\Contracts;

interface Driver
{
    /**
     * @return mixed
     */
    public function load($locale, $group, $namespace = null);
}
