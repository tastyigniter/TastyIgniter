<?php

declare(strict_types=1);

namespace Igniter\Automation\Tests\Classes;

use Igniter\Automation\Classes\AbstractBase;

it('extends the class with a callback', function(): void {
    $callback = fn(): string => 'extended';

    $abstractBase = new class extends AbstractBase
    {
        public function testCallback()
        {
            return self::$extensionCallbacks[AbstractBase::class][0]();
        }
    };

    AbstractBase::extend($callback);

    expect($abstractBase->testCallback())->toBe('extended');
});
