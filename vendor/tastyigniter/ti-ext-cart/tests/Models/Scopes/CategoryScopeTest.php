<?php

declare(strict_types=1);

namespace Igniter\Cart\Tests\Models\Observers;

use Igniter\Cart\Models\Scopes\CategoryScope;
use Illuminate\Database\Eloquent\Builder;
use Mockery;

beforeEach(function(): void {
    $this->scope = new CategoryScope;
    $this->builder = Mockery::mock(Builder::class);
});

it('applies menus filter with status 1', function(): void {
    $this->builder->shouldReceive('whereHas')->with('menus')->andReturnSelf();
    $this->builder->shouldReceive('where')->with('status', 1)->andReturnSelf();

    $applyMenus = $this->scope->addWhereHasMenus();
    $applyMenus($this->builder);

    $this->builder->shouldHaveReceived('whereHas')->with('menus')->once();
    $this->builder->shouldHaveReceived('where')->with('status', 1)->once();
});
