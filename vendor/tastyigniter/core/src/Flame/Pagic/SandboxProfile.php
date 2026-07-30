<?php

declare(strict_types=1);

namespace Igniter\Flame\Pagic;

enum SandboxProfile: string
{
    case Theme = 'theme';
    case Mail = 'mail';
}
