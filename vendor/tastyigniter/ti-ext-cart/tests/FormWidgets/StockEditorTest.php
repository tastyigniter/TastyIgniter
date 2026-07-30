<?php

declare(strict_types=1);

namespace Igniter\Cart\Tests\FormWidgets;

use Igniter\Admin\Classes\FormField;
use Igniter\Cart\FormWidgets\StockEditor;
use Igniter\Cart\Http\Controllers\Menus;
use Igniter\Cart\Models\Menu;
use Igniter\Local\Models\Location;
use Igniter\User\Facades\AdminAuth;

beforeEach(function(): void {
    $this->menuItem = Menu::factory()->create();
    $this->stockEditorWidget = new StockEditor(
        resolve(Menus::class),
        new FormField('test_field', 'Stock editor'),
        [
            'model' => $this->menuItem,
        ],
    );
});

it('initializes with config', function(): void {
    expect($this->stockEditorWidget->form)->toBe('stock')
        ->and($this->stockEditorWidget->quantityKeyFrom)->toBe('stock_qty');
});

it('prepares vars', function(): void {
    $this->stockEditorWidget->prepareVars();

    expect($this->stockEditorWidget->vars['field'])->toBeInstanceOf(FormField::class)
        ->and($this->stockEditorWidget->vars['value'])->toBe(0)
        ->and($this->stockEditorWidget->vars['previewMode'])->toBeFalse();
});

it('gets save value', function(): void {
    expect($this->stockEditorWidget->getSaveValue('test'))->toBe(FormField::NO_SAVE_DATA);
});

it('loads record', function(): void {
    AdminAuth::shouldReceive('user')->andReturnSelf();
    AdminAuth::shouldReceive('getAvailableLocations')->andReturn([Location::factory()->create()]);

    expect($this->stockEditorWidget->onLoadRecord())->toBeString();
});

it('saves record', function(): void {
    $this->menuItem->locations()->save(Location::factory()->create());

    expect($this->stockEditorWidget->onSaveRecord())->toBeArray();
});

it('loads history', function(): void {
    expect($this->stockEditorWidget->onLoadHistory())->toBeString();
});
