<?php

declare(strict_types=1);

namespace Igniter\Cart\Tests\Models\Observers;

use Igniter\Cart\Models\MenuOptionValue;
use Igniter\Cart\Models\Observers\MenuOptionValueObserver;
use Mockery;

beforeEach(function(): void {
    $this->observer = new MenuOptionValueObserver;
    $this->menuOptionValue = Mockery::mock(MenuOptionValue::class)->makePartial();
});

it('detaches ingredients when deleting', function(): void {
    $this->menuOptionValue->shouldReceive('ingredients->detach')->once();

    $this->observer->deleting($this->menuOptionValue);
});
