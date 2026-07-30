<?php

declare(strict_types=1);

namespace Igniter\Flame\Flash;

class OverlayMessage extends Message
{
    public ?string $title = '';

    public bool $overlay = true;
}
