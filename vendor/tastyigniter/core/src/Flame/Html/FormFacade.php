<?php

declare(strict_types=1);

namespace Igniter\Flame\Html;

use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\Facade;
use Illuminate\Support\HtmlString;
use Override;

/**
 * @method static HtmlString open(array $options = [])
 * @method static string close()
 * @method static string token()
 * @method static HtmlString input(string $type, string $name, string $value = null, array $options = [])
 * @method static HtmlString hidden(string $name, string $value = null, array $options = [])
 * @method static string getIdAttribute(string $name, array $attributes)
 * @method static mixed getValueAttribute(string $name, string $value = null)
 * @method static mixed old(string $name)
 * @method static bool oldInputIsEmpty()
 * @method static Session getSessionStore()
 * @method static FormBuilder setSessionStore(Session $session)
 * @method static void macro(string $name, object|callable $macro)
 * @method static void mixin(object $mixin, bool $replace = true)
 * @method static bool hasMacro(string $name)
 * @method static void flushMacros()
 *
 * @see FormBuilder
 */
class FormFacade extends Facade
{
    /**
     * Get the registered name of the component.
     */
    #[Override]
    protected static function getFacadeAccessor(): string
    {
        return 'form';
    }
}
