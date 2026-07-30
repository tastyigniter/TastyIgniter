<?php

declare(strict_types=1);

namespace Igniter\Flame\Database\Attach\Events;

use Igniter\Flame\Database\Attach\Media;
use Igniter\Flame\Traits\EventDispatchable;

class MediaAdded
{
    use EventDispatchable;

    final public function __construct(public Media $media) {}

    public static function eventName(): string
    {
        return 'attach.mediaAdded';
    }
}
