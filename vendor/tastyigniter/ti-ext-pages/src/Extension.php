<?php

declare(strict_types=1);

namespace Igniter\Pages;

use Igniter\Flame\Support\Facades\Igniter;
use Igniter\Pages\Classes\MenuManager;
use Igniter\Pages\Classes\Page as StaticPage;
use Igniter\Pages\Classes\PageManager;
use Igniter\Pages\Models\Menu;
use Igniter\Pages\Models\MenuItem;
use Igniter\Pages\Models\Observers\MenuObserver;
use Igniter\Pages\Models\Observers\PageObserver;
use Igniter\Pages\Models\Page;
use Igniter\System\Classes\BaseExtension;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Route;
use Override;
use Stevebauman\Purify\Facades\Purify;
use Stevebauman\Purify\PurifyServiceProvider;

class Extension extends BaseExtension
{
    protected array $morphMap = [
        'pages' => Page::class,
        'static_menus' => Menu::class,
        'static_menu_items' => MenuItem::class,
    ];

    protected $observers = [
        Page::class => PageObserver::class,
        Menu::class => MenuObserver::class,
    ];

    #[Override]
    public function register(): void
    {
        parent::register();

        $this->app->register(PurifyServiceProvider::class);

        $this->app->singleton(MenuManager::class);
        $this->app->singleton(PageManager::class);
    }

    #[Override]
    public function boot(): void
    {
        Event::listen('main.theme.activated', function(): void {
            Menu::syncAll();
        });

        Event::listen('router.beforeRoute', function($url) {
            if (!request()->routeIs('igniter.pages.*')) {
                return;
            }

            return resolve(PageManager::class)->initPage($url);
        });

        Event::listen('main.page.beforeRenderPage', function($controller, $page) {
            if ($contents = resolve(PageManager::class)->getPageContents($page)) {
                return Purify::clean($contents);
            }
        });

        Event::listen('pages.menuitem.listTypes', fn(): array => [
            'static-page' => 'igniter.pages::default.menu.text_static_page',
            'all-static-pages' => 'igniter.pages::default.menu.text_all_static_pages',
        ]);

        Event::listen('pages.menuitem.getTypeInfo', function($type): ?array {
            if ($type == 'static-page') {
                return StaticPage::getMenuTypeInfo($type);
            }

            return [];
        });

        Event::listen('pages.menuitem.resolveItem', function($item, string $url, $theme) {
            if ($theme && ($item->type == 'static-page' || $item->type == 'all-static-pages')) {
                return StaticPage::resolveMenuItem($item, $url, $theme);
            }
        });

        Relation::morphMap(['pages' => Page::class]);

        $this->defineRoutes();
    }

    #[Override]
    public function registerNavigation(): array
    {
        return [
            'design' => [
                'child' => [
                    'pages' => [
                        'priority' => 15,
                        'class' => 'pages',
                        'href' => admin_url('igniter/pages/pages'),
                        'title' => lang('admin::lang.side_menu.page'),
                        'permission' => 'Igniter.Pages.*',
                    ],
                ],
            ],
        ];
    }

    #[Override]
    public function registerPermissions(): array
    {
        return [
            'Igniter.Pages.Manage' => [
                'group' => 'igniter::admin.permissions.name',
                'description' => 'Create, modify and delete front-end pages and menus',
            ],
        ];
    }

    protected function defineRoutes()
    {
        if (!Igniter::hasDatabase()) {
            return;
        }

        Route::middleware(config('igniter-routes.middleware', []))
            ->domain(config('igniter-routes.domain'))
            ->name('igniter.pages.')
            ->prefix(Igniter::uri())
            ->group(function(Router $router): void {
                resolve(PageManager::class)->listPageSlugs()->each(function($slug) use ($router): void {
                    $router->pagic($slug)->name($slug);
                });
            });
    }
}
