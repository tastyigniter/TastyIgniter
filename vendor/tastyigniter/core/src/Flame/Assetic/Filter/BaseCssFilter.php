<?php

declare(strict_types=1);

/*
 * This file is part of the Assetic package, an OpenSky project.
 *
 * (c) 2010-2014 OpenSky Project Inc
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Igniter\Flame\Assetic\Filter;

use Igniter\Flame\Assetic\Util\CssUtils;

/**
 * An abstract filter for dealing with CSS.
 *
 * @author Kris Wallsmith <kris.wallsmith@gmail.com>
 */
abstract class BaseCssFilter implements FilterInterface
{
    /**
     * @param int $limit
     * @param int $count
     * @return string
     * @see CssUtils::filterReferences()
     */
    protected function filterReferences($content, $callback, $limit = -1, &$count = 0)
    {
        return CssUtils::filterReferences($content, $callback);
    }

    /**
     * @param int $limit
     * @param int $count
     * @param bool $includeUrl
     * @return string
     * @see CssUtils::filterImports()
     */
    protected function filterImports($content, $callback, $limit = -1, &$count = 0, $includeUrl = true)
    {
        return CssUtils::filterImports($content, $callback, $includeUrl);
    }
}
