<?php

declare(strict_types=1);

namespace Igniter\Flame\Flash\Facades;

use Igniter\Flame\Flash\FlashBag;
use Igniter\Flame\Flash\Message;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade as IlluminateFacade;
use Override;

/**
 * @method static FlashBag setSessionKey(string $key)
 * @method static string getSessionKey()
 * @method static Collection messages()
 * @method static Collection all()
 * @method static void set(string|null $level = null, string|null $message = null)
 * @method static FlashBag alert(string $message)
 * @method static FlashBag info(string $message)
 * @method static FlashBag success(string $message)
 * @method static FlashBag error(string $message)
 * @method static FlashBag danger(string $message)
 * @method static FlashBag warning(string $message)
 * @method static FlashBag message(Message | string | null $message = null, string | null $level = null)
 * @method static FlashBag overlay(string | null $message = null, string $title = '')
 * @method static FlashBag now()
 * @method static FlashBag important()
 * @method static FlashBag clear()
 *
 * @see FlashBag
 */
class Flash extends IlluminateFacade
{
    /**
     * Get the registered name of the component.
     *
     * @see FlashBag
     */
    #[Override]
    protected static function getFacadeAccessor(): string
    {
        return 'flash';
    }
}
