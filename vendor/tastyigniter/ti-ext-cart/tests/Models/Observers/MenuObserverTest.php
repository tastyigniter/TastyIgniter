<?php

declare(strict_types=1);

namespace Igniter\Cart\Tests\Models\Observers;

use Igniter\Cart\Models\Menu;
use Igniter\Cart\Models\Observers\MenuObserver;
use Mockery;

beforeEach(function(): void {
    $this->observer = new MenuObserver;
    $this->menu = Mockery::mock(Menu::class)->makePartial();
});

it('restores purged values when saved', function(): void {
    $this->menu->shouldReceive('restorePurgedValues')->once();

    $this->observer->saved($this->menu);
});

it('adds menu options when menu_options attribute exists', function(): void {
    $attributes = ['menu_options' => ['option1', 'option2']];
    $this->menu->shouldReceive('getAttributes')->andReturn($attributes);
    $this->menu->shouldReceive('addMenuOption')->with(['option1', 'option2'])->once();

    $this->observer->saved($this->menu);
});

it('adds menu specials when special attribute exists', function(): void {
    $attributes = ['special' => ['special1', 'special2']];
    $this->menu->shouldReceive('getAttributes')->andReturn($attributes);
    $this->menu->shouldReceive('addMenuSpecial')->with(['special1', 'special2'])->once();

    $this->observer->saved($this->menu);
});

it('does not add menu options when menu_options attribute does not exist', function(): void {
    $attributes = [];
    $this->menu->shouldReceive('getAttributes')->andReturn($attributes);
    $this->menu->shouldNotReceive('addMenuOption');

    $this->observer->saved($this->menu);
});

it('does not add menu specials when special attribute does not exist', function(): void {
    $attributes = [];
    $this->menu->shouldReceive('getAttributes')->andReturn($attributes);
    $this->menu->shouldNotReceive('addMenuSpecial');

    $this->observer->saved($this->menu);
});

it('detaches categories, mealtimes, ingredients, and locations when deleting', function(): void {
    $this->menu->shouldReceive('menu_options->delete')->once();
    $this->menu->shouldReceive('special->delete')->once();
    $this->menu->shouldReceive('categories->detach')->once();
    $this->menu->shouldReceive('mealtimes->detach')->once();
    $this->menu->shouldReceive('ingredients->detach')->once();
    $this->menu->shouldReceive('locations->detach')->once();

    $this->observer->deleting($this->menu);
});
