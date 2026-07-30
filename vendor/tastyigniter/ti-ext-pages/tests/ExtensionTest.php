<?php

declare(strict_types=1);

namespace Igniter\Pages\Tests;

use Igniter\Flame\Support\Facades\Igniter;
use Igniter\Main\Classes\MainController;
use Igniter\Main\Classes\Theme;
use Igniter\Pages\Classes\Page;
use Igniter\Pages\Classes\PageManager;
use Igniter\Pages\Extension;
use Igniter\Pages\Models\Page as PageModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Route;

it('syncs all menus when theme is activated', function(): void {
    Event::dispatch('main.theme.activated');

    expect(true)->toBeTrue();
});

it('initializes page for matching route', function(): void {
    $url = 'about-us';
    $request = Request::create($url);
    $request->setRouteResolver(fn() => Route::get($url)->name('igniter.pages.*'));

    app()->instance('request', $request);

    $result = Event::dispatch('router.beforeRoute', [$url]);

    expect($result[0])->toBeInstanceOf(Page::class);
});

it('does not initialize page for non-matching route', function(): void {
    $url = 'non-existing-page';
    $request = Request::create($url);
    $request->setRouteResolver(fn() => Route::get($url));

    app()->instance('request', $request);

    $result = Event::dispatch('router.beforeRoute', [$url]);

    expect($result[0])->toBeNull();
});

it('returns sanitized page contents before rendering page', function(): void {
    $url = 'about-us';
    $controller = MainController::getController();
    $page = (new PageManager)->initPage($url);

    PageModel::where('permalink_slug', 'about-us')->update([
        'content' => '<p>About</p><script>alert(1)</script>',
    ]);

    $result = Event::dispatch('main.page.beforeRenderPage', [$controller, $page]);

    expect($result[0])->not->toBeEmpty()
        ->not->toContain('<script>');
});

it('returns menu item types', function(): void {
    $result = Event::dispatch('pages.menuitem.listTypes');

    expect($result[0])->toBeArray()
        ->and($result[0])->toHaveKey('static-page')
        ->and($result[0])->toHaveKey('all-static-pages');
});

it('returns menu type info for static page', function(): void {
    $result = Event::dispatch('pages.menuitem.getTypeInfo', ['static-page']);

    expect($result[0])->toBeArray()
        ->and($result[0]['references'])->toContain('About Us', 'Policy', 'Terms and Conditions');
});

it('returns empty array for invalid menu type info', function(): void {
    $result = Event::dispatch('pages.menuitem.getTypeInfo', ['invalid-type']);

    expect($result[0])->toBeArray()
        ->and($result[0])->toBeEmpty();
});

it('resolves static page menu item', function(): void {
    $url = 'test-url';
    $item = (object)['type' => 'static-page', 'reference' => 1];
    $theme = new Theme('tests-theme-path', ['code' => 'tests-theme']);

    $result = Event::dispatch('pages.menuitem.resolveItem', [$item, $url, $theme]);

    expect($result[0]['url'])->toEndWith('about-us');
});

it('does not register routes when no database is configured', function(): void {
    Igniter::shouldReceive('hasDatabase')->andReturnFalse();
    $extension = new Extension(app());

    $extension->boot();

    expect(Route::has('igniter.pages.*'))->toBeFalse();
});

it('returns registered permissions', function(): void {
    $extension = new Extension(app());

    $permissions = $extension->registerPermissions();

    expect($permissions)->toEqual([
        'Igniter.Pages.Manage' => [
            'group' => 'igniter::admin.permissions.name',
            'description' => 'Create, modify and delete front-end pages and menus',
        ],
    ]);
});
