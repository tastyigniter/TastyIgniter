<?php

declare(strict_types=1);

namespace Igniter\System\Rules;

use Closure;
use Igniter\Flame\Exception\SystemException;
use Igniter\Flame\Pagic\SandboxProfile;
use Igniter\Flame\Pagic\TemplateSandbox;
use Illuminate\Contracts\Validation\ValidationRule;

class SafeMailTemplateContent implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!is_string($value) || $value === '') {
            return;
        }

        try {
            resolve(TemplateSandbox::class)->assertSafe($value, SandboxProfile::Mail);
        } catch (SystemException $systemException) {
            $fail($systemException->getMessage());
        }
    }
}
