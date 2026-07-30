<?php

declare(strict_types=1);

namespace Igniter\Automation\Tests\Jobs;

use Igniter\Automation\Classes\EventManager;
use Igniter\Automation\Jobs\EventParams;
use Mockery;

it('handles the event with serialized parameters', function(): void {
    $eventClass = 'SomeEventClass';
    $params = ['param1' => 'value1', 'param2' => 'value2'];

    $eventManager = Mockery::mock(EventManager::class);
    $eventManager->shouldReceive('fireEvent')->with($eventClass, $params)->once();
    app()->instance(EventManager::class, $eventManager);

    $job = new EventParams($eventClass, $params);
    $job->handle();
});
