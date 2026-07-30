<?php

declare(strict_types=1);

namespace Igniter\Flame\Translation;

use Illuminate\Support\Str;
use Illuminate\Translation\Translator as BaseTranslator;
use Override;

class Translator extends BaseTranslator
{
    protected $replaceNamespaces = [
        'admin::lang.' => 'igniter::admin.',
        'main::lang.' => 'igniter::main.',
        'system::lang.' => 'igniter::system.',
    ];

    #[Override]
    public function get($key, array $replace = [], $locale = null, $fallback = true)
    {
        if (Str::startsWith($key, 'lang:')) {
            $key = substr($key, 5);
        }

        if (Str::startsWith($key, array_keys($this->replaceNamespaces))) {
            $key = Str::replace(array_keys($this->replaceNamespaces), array_values($this->replaceNamespaces), $key);
        }

        return parent::get($key, $replace, $locale, $fallback);
    }
}
