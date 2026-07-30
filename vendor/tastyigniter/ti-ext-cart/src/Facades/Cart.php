<?php

declare(strict_types=1);

namespace Igniter\Cart\Facades;

use Closure;
use Igniter\Cart\CartCondition;
use Igniter\Cart\CartConditions;
use Igniter\Cart\CartContent;
use Igniter\Cart\CartItem;
use Illuminate\Support\Facades\Facade;
use Override;

/**
 * @method static \Igniter\Cart\Cart instance(string|null $instance = null)
 * @method static string currentInstance()
 * @method static array|CartItem add(void $buyable, int $qty = 0, array $options = [], void $comment = null)
 * @method static CartItem|bool update(string $rowId, mixed $qty)
 * @method static void remove(string $rowId)
 * @method static CartItem get(string $rowId)
 * @method static void destroy(mixed $identifier = null)
 * @method static CartContent content()
 * @method static int count()
 * @method static string total()
 * @method static float subtotal()
 * @method static CartContent search(Closure $search)
 * @method static void associate(string $rowId, mixed $model)
 * @method static CartConditions conditions()
 * @method static void conditionsWithoutApplied()
 * @method static CartCondition|null getCondition(string $name)
 * @method static bool removeCondition(void $name)
 * @method static void clearConditions()
 * @method static void condition(void $condition)
 * @method static void loadConditions()
 * @method static void loadCondition(CartCondition $condition)
 * @method static void clearContent()
 * @method static void store(mixed $identifier)
 * @method static void restore(mixed $identifier)
 * @method static void deleteStored(void $identifier)
 * @method static void keepSession(Closure $callback)
 *
 * @see \Igniter\Cart\Cart
 */
class Cart extends Facade
{
    /**
     * Get the registered name of the component.
     */
    #[Override]
    protected static function getFacadeAccessor(): string
    {
        return 'cart';
    }
}
