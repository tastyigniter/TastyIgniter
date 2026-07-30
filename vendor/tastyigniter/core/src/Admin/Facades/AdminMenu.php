<?php

declare(strict_types=1);

namespace Igniter\Admin\Facades;

use Igniter\Admin\Classes\Navigation;
use Igniter\User\Auth\UserGuard;
use Illuminate\Support\Facades\Facade;
use Override;

/**
 * @method static void setContext(string $itemCode, string|null $parentCode = null)
 * @method static array getNavItems()
 * @method static array getVisibleNavItems()
 * @method static bool isActiveNavItem(string $code)
 * @method static array getMainItems()
 * @method static string render(string $partial)
 * @method static void addNavItem(string $itemCode, array $options = [], string|null $parentCode = null)
 * @method static void mergeNavItem(string $itemCode, array $options = [], string|null $parentCode = null)
 * @method static void removeNavItem(string $itemCode, string|null $parentCode = null)
 * @method static void removeMainItem(string $itemCode)
 * @method static void loadItems()
 * @method static array filterPermittedNavItems(array $items)
 * @method static Navigation setPreviousUrl(string $pathOrUrl)
 * @method static string|null getPreviousUrl()
 * @method static void registerMainItems(array|null $definitions = null)
 * @method static void registerNavItems(array|null $definitions = null, string|null $parent = null)
 * @method static void registerNavItem(string $code, array $item, string|null $parent = null)
 * @method static void registerCallback(callable $callback)
 * @method static Navigation bindEvent(string $event, callable $callback, int $priority = 0)
 * @method static Navigation bindEventOnce(string $event, callable $callback)
 * @method static Navigation unbindEvent(string | null $event = null)
 * @method static mixed fireEvent(string $event, array $params = [], bool $halt = false)
 * @method static mixed fireSystemEvent(string $event, array $params = [], bool $halt = true)
 * @method static string getViewPath(string $view, array|string|null $paths = [], string|null $prefix = null)
 * @method static string getViewName(string $view, array|string|null $paths = [], string|null $prefix = null)
 * @method static string guessViewName(string $name, string|null $prefix = 'components.')
 * @method static string makeLayout(string|null $name = null, array $vars = [], bool $throwException = true)
 * @method static string makeView(string $view, array $data = [])
 * @method static string makePartial(string $partial, array $vars = [], bool $throwException = true)
 * @method static string makeFileContent(string $filePath, array $extraParams = [])
 * @method static string compileFileContent(string $filePath)
 * @method static string makeViewContent(string $view, array $data = [])
 *
 * @see Navigation
 */
class AdminMenu extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @see UserGuard
     */
    #[Override]
    protected static function getFacadeAccessor(): string
    {
        return 'admin.menu';
    }
}
