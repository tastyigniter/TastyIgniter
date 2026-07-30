<?php

declare(strict_types=1);

namespace Igniter\Pages\Tests\Http\Controllers;

use Igniter\Main\Classes\MainController;
use Igniter\Pages\Classes\PageManager;
use Igniter\Pages\Models\Page;
use Illuminate\Support\Facades\Event;

it('loads static pages page', function(): void {
    actingAsSuperUser()
        ->get(route('igniter.pages.pages'))
        ->assertOk();
});

it('loads create static page', function(): void {
    actingAsSuperUser()
        ->get(route('igniter.pages.pages', ['slug' => 'create']))
        ->assertOk();
});

it('loads edit static page', function(): void {
    $page = Page::firstWhere('permalink_slug', 'about-us');

    actingAsSuperUser()
        ->get(route('igniter.pages.pages', ['slug' => 'edit/'.$page->getKey()]))
        ->assertOk();
});

it('creates static page', function(): void {
    actingAsSuperUser()
        ->post(route('igniter.pages.pages', ['slug' => 'create']), [
            'Page' => [
                'title' => 'Test Page',
                'permalink_slug' => 'test-page',
                'content' => 'Test page content',
                'status' => 1,
                'language_id' => 1,
                'metadata' => ['navigation_hidden' => 0],
            ],
        ], [
            'X-Requested-With' => 'XMLHttpRequest',
            'X-IGNITER-REQUEST-HANDLER' => 'onSave',
        ])
        ->assertOk();

    expect(Page::where('permalink_slug', 'test-page')->exists())->toBeTrue();
});

it('updates static page', function(): void {
    $page = Page::firstWhere('permalink_slug', 'about-us');

    actingAsSuperUser()
        ->post(route('igniter.pages.pages', ['slug' => 'edit/'.$page->getKey()]), [
            'Page' => [
                'title' => 'Test Page',
                'permalink_slug' => 'test-page',
                'content' => 'Test page content',
                'status' => 1,
                'language_id' => 1,
                'metadata' => ['navigation_hidden' => 0],
            ],
        ], [
            'X-Requested-With' => 'XMLHttpRequest',
            'X-IGNITER-REQUEST-HANDLER' => 'onSave',
        ]);

    expect(Page::where('permalink_slug', 'about-us')->exists())->toBeFalse()
        ->and(Page::where('permalink_slug', 'test-page')->exists())->toBeTrue();
});

it('deletes static page', function(): void {
    $page = Page::firstWhere('permalink_slug', 'about-us');

    actingAsSuperUser()
        ->post(route('igniter.pages.pages', ['slug' => 'edit/'.$page->getKey()]), [], [
            'X-Requested-With' => 'XMLHttpRequest',
            'X-IGNITER-REQUEST-HANDLER' => 'onDelete',
        ]);

    expect(Page::where('page_id', $page->getKey())->exists())->toBeFalse();
});

it('strips stored XSS from rendered page content', function(): void {
    actingAsSuperUser()
        ->post(route('igniter.pages.pages', ['slug' => 'create']), [
            'Page' => [
                'title' => 'XSS Test Page',
                'permalink_slug' => 'xss-test-page',
                'content' => '<h1>Safe heading</h1><script>alert(1)</script><img src=x onerror=alert(1)>',
                'status' => 1,
                'language_id' => 1,
                'metadata' => ['navigation_hidden' => 0],
            ],
        ], [
            'X-Requested-With' => 'XMLHttpRequest',
            'X-IGNITER-REQUEST-HANDLER' => 'onSave',
        ])
        ->assertOk();

    expect(Page::where('permalink_slug', 'xss-test-page')->exists())->toBeTrue()
        ->and(Page::where('permalink_slug', 'xss-test-page')->first()->content)
        ->not->toContain('<script>');
});

it('sanitizes page contents in beforeRenderPage listener', function(): void {
    $slug = 'about-us';

    Page::where('permalink_slug', $slug)->update([
        'content' => '<p>About</p><script>alert(1)</script>',
    ]);

    $controller = MainController::getController();
    $page = (new PageManager)->initPage($slug);

    $result = Event::dispatch('main.page.beforeRenderPage', [$controller, $page]);

    expect($result[0])
        ->toContain('<p>About</p>')
        ->not->toContain('<script>');
});
