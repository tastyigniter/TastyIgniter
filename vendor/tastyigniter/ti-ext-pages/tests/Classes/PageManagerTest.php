<?php

declare(strict_types=1);

namespace Igniter\Pages\Tests\Classes;

use Igniter\Flame\Exception\ApplicationException;
use Igniter\Flame\Pagic\Model;
use Igniter\Main\Models\Theme;
use Igniter\Pages\Classes\PageManager;

beforeEach(function(): void {
    Theme::syncAll();
});

it('initializes page with valid URL', function(): void {
    $url = 'about-us';

    $page = (new PageManager)->initPage($url);

    expect($page)->not->toBeNull()
        ->and($page->permalink)->toEqual($url)
        ->and($page['staticPage']->content)->not->toBeEmpty();
});

it('returns null for uninitialized page with invalid URL', function(): void {
    $url = 'invalid-url';

    expect((new PageManager)->initPage($url))->toBeNull();
});

it('gets page contents for initialized page', function(): void {
    $url = 'about-us';

    $pageManager = new PageManager;

    $page = $pageManager->initPage($url);

    expect($pageManager->getPageContents($page))->not->toBeEmpty();
});

it('gets empty page contents for non static page', function(): void {
    $url = 'empty-page';

    $pageManager = new PageManager;

    $page = $pageManager->initPage($url);

    expect($pageManager->getPageContents($page))->toBeNull();
});

it('throws exception when no active theme', function(): void {
    config(['igniter-system.defaultTheme' => 'invalid-theme']);

    $url = 'about-us';

    $pageManager = new PageManager;

    expect(fn(): ?Model => $pageManager->initPage($url))->toThrow(ApplicationException::class);
});

it('lists page slugs for enabled pages', function(): void {
    $slugs = (new PageManager)->listPageSlugs();

    expect($slugs)->toContain('about-us', 'policy', 'terms-and-conditions');
});
