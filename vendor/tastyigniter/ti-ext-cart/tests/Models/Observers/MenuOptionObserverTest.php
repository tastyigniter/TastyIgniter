<?php

declare(strict_types=1);

namespace Igniter\Cart\Tests\Models\Observers;

use Igniter\Cart\Models\MenuOption;
use Igniter\Cart\Models\Observers\MenuOptionObserver;
use Mockery;

beforeEach(function(): void {
    $this->observer = new MenuOptionObserver;
    $this->menuOption = Mockery::mock(MenuOption::class)->makePartial();
});

it('restores purged values when saved', function(): void {
    $this->menuOption->shouldReceive('restorePurgedValues')->once();

    $this->observer->saved($this->menuOption);
});

it('adds option values when values attribute exists', function(): void {
    $attributes = ['values' => ['value1', 'value2']];
    $this->menuOption->shouldReceive('getAttributes')->andReturn($attributes);
    $this->menuOption->shouldReceive('addOptionValues')->with(['value1', 'value2'])->once();

    $this->observer->saved($this->menuOption);
});

it('does not add option values when values attribute does not exist', function(): void {
    $attributes = [];
    $this->menuOption->shouldReceive('getAttributes')->andReturn($attributes);
    $this->menuOption->shouldNotReceive('addOptionValues');

    $this->observer->saved($this->menuOption);
});

it('detaches locations when deleting', function(): void {
    $this->menuOption->shouldReceive('locations->detach')->once();

    $this->observer->deleting($this->menuOption);
});
