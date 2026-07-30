<?php

declare(strict_types=1);

namespace Igniter\User\Classes;

use Igniter\User\Facades\AdminAuth;
use Igniter\User\Facades\Auth;
use Illuminate\Support\Facades\Blade;

class BladeExtension
{
    public function register(): void
    {
        Blade::directive('mainauth', $this->compilesMainAuth(...));
        Blade::directive('endmainauth', $this->compilesEndMainAuth(...));
        Blade::directive('adminauth', $this->compilesAdminAuth(...));
        Blade::directive('endadminauth', $this->compilesEndAdminAuth(...));
    }

    public function compilesMainAuth($expression): string
    {
        return '<?php if('.Auth::class.'::check()): ?>';
    }

    public function compilesAdminAuth($expression): string
    {
        return '<?php if('.AdminAuth::class.'::check()): ?>';
    }

    public function compilesEndMainAuth(): string
    {
        return '<?php endif ?>';
    }

    public function compilesEndAdminAuth(): string
    {
        return '<?php endif ?>';
    }
}
