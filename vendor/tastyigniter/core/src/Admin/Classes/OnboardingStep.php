<?php

declare(strict_types=1);

namespace Igniter\Admin\Classes;

use Closure;

final class OnboardingStep
{
    public string $code;

    public string $label;

    public string $description;

    public string $icon;

    public string $url;

    public int $priority;

    public null|array|Closure $complete = null;

    public static function fromArray(array $attributes): self
    {
        $instance = new self;
        $instance->code = $attributes['code'];
        $instance->label = $attributes['label'];
        $instance->description = $attributes['description'];
        $instance->icon = $attributes['icon'];
        $instance->url = $attributes['url'];
        $instance->priority = $attributes['priority'];
        $instance->complete = $attributes['complete'];

        return $instance;
    }

    public function isCompleted(): bool
    {
        return is_callable($this->complete) ? ($this->complete)() : false;
    }
}
