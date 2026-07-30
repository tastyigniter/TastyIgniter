<?php

declare(strict_types=1);

namespace Igniter\Flame\Html;

use Illuminate\Support\Facades\Facade;
use Override;

/**
 * @method static string attributes(array $attributes)
 *
 * @see HtmlBuilder
 */
class HtmlFacade extends Facade
{
    /**
     * Get the registered name of the component.
     */
    #[Override]
    protected static function getFacadeAccessor(): string
    {
        return 'html';
    }
}
