<?php

declare(strict_types=1);

namespace Igniter\Pages\Tests\Models;

use Igniter\Flame\Database\Traits\HasPermalink;
use Igniter\Flame\Database\Traits\Sortable;
use Igniter\Main\Classes\Theme;
use Igniter\Main\Classes\ThemeManager;
use Igniter\Main\Template\Layout;
use Igniter\Pages\Models\Page;
use Igniter\System\Models\Concerns\Switchable;
use Igniter\System\Models\Language;

it('returns dropdown options for enabled pages', function(): void {
    $options = Page::getDropdownOptions();

    expect($options->isNotEmpty())->toBeTrue()
        ->and($options)
        ->toContain('About Us')
        ->toContain('Policy');
});

it('loads enabled pages in alphabetical order', function(): void {
    Page::$pagesCache = null;
    $pages = Page::loadPages();

    expect($pages->isNotEmpty())->toBeTrue()
        ->and($pages->first()->title)->toBe('About Us')
        ->and($pages->last()->title)->toBe('Terms and Conditions');
});

it('returns layout options for active theme', function(): void {
    $themeManager = mock(ThemeManager::class);
    $themeManager->shouldReceive('getActiveTheme')->andReturn(new Theme('tests-theme-path', ['code' => 'igniter-orange']));
    app()->instance(ThemeManager::class, $themeManager);

    $page = new Page;
    $options = $page->getLayoutOptions();

    expect($options)->toBeArray()
        ->and($options)->toHaveKeys(['static', 'default']);
});

it('returns layout object for the page', function(): void {
    $page = new Page(['layout' => 'default', 'theme' => 'igniter-orange']);

    $layout = $page->getLayoutObject();

    expect($layout)->toBeInstanceOf(Layout::class)
        ->and($layout->fileName)->toBe('default.blade.php');
});

it('returns null when layout is not found', function(): void {
    $page = new Page(['layout' => 'nonexistent', 'theme' => 'igniter-orange']);

    $layout = $page->getLayoutObject();

    expect($layout)->toBeNull();
});

it('returns null when no available layout in active theme', function(): void {
    $page = new Page(['theme' => 'tests-theme']);
    $themeManager = mock(ThemeManager::class);
    $themeManager->shouldReceive('getActiveTheme')->andReturn(new Theme('tests-theme-path', ['code' => 'tests-theme']));
    app()->instance(ThemeManager::class, $themeManager);

    $layout = $page->getLayoutObject();

    expect($layout)->toBeNull();
});

it('decodes HTML entities in content attribute', function(): void {
    $page = new Page(['content' => 'Test &amp; Content']);

    $content = $page->getContentAttribute($page->content);

    expect($content)->toBe('Test & Content');
});

it('strips script tags from content attribute', function(): void {
    $page = new Page(['content' => '<p>Safe</p><script>alert(1)</script>']);

    expect($page->content)
        ->toContain('<p>Safe</p>')
        ->not->toContain('<script>');
});

it('strips script tags when saving page content', function(): void {
    Page::$pagesCache = null;
    Language::clearDefaultModel();
    $language = Language::factory()->create(['status' => 1]);
    $language->makeDefault();

    $page = new Page;
    $page->title = 'XSS Save Test';
    $page->content = '<p>Safe</p><script>alert(1)</script>';
    $page->status = true;
    $page->save();

    expect($page->fresh()->content)
        ->toContain('<p>Safe</p>')
        ->not->toContain('<script>');
});

it('sets default language id before saving', function(): void {
    Page::$pagesCache = null;
    Language::clearDefaultModel();
    $language = Language::factory()->create(['status' => 1]);
    $language->makeDefault();

    $page = new Page;
    $page->title = 'Test Page';
    $page->content = 'Test Content';
    $page->status = true;
    $page->save();
    $page = $page->fresh();

    expect($page->language_id)->toBe($language->getKey());
});

it('configures page model correctly', function(): void {
    $page = new Page;

    expect(class_uses_recursive($page))
        ->toContain(HasPermalink::class)
        ->toContain(Sortable::class)
        ->toContain(Switchable::class)
        ->and(Page::SORT_ORDER)->toEqual('priority')
        ->and($page->getTable())->toBe('pages')
        ->and($page->getKeyName())->toBe('page_id')
        ->and($page->getGuarded())->toEqual([])
        ->and($page->timestamps)->toBeTrue()
        ->and($page->getCasts())->toEqual([
            'page_id' => 'int',
            'language_id' => 'integer',
            'metadata' => 'json',
            'status' => 'boolean',
        ])
        ->and($page->relation)->toEqual([
            'belongsTo' => [
                'language' => Language::class,
            ],
        ])
        ->and($page->permalinkable())->toEqual([
            'permalink_slug' => [
                'source' => 'title',
            ],
        ]);
});
