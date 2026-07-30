<?php

declare(strict_types=1);

namespace Igniter\Flame\Database\Attach\Events;

use Igniter\Flame\Database\Model;
use Igniter\Flame\Traits\EventDispatchable;

class MediaTagCleared
{
    use EventDispatchable;

    final public function __construct(public Model $model, public ?string $tag) {}

    public static function eventName(): string
    {
        return 'attach.mediaTagCleared';
    }
}
