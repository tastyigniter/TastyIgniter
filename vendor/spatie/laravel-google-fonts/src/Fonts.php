<?php

namespace Spatie\GoogleFonts;

use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Collection;
use Illuminate\Support\HtmlString;

class Fonts implements Htmlable
{
    public function __construct(
        protected string  $googleFontsUrl,
        protected ?string $localizedUrl = null,
        protected ?string $localizedCss = null,
        protected ?string $nonce = null,
        protected bool    $preferInline = false,
        protected ?string $preloadMeta = null,
        protected bool    $preload = false,
    ) {
    }

    public function inline(): HtmlString
    {
        if (! $this->localizedCss) {
            return $this->fallback();
        }

        $attributes = $this->parseAttributes([
            'nonce' => $this->nonce ?? false,
        ]);

        $preloadMeta = '';
        if ($this->preload) {
            $preloadMeta = $this->preloadMeta;

        }

        return new HtmlString(<<<HTML
            {$preloadMeta}
            <style {$attributes->implode(' ')}>{$this->localizedCss}</style>
        HTML);
    }

    public function link(): HtmlString
    {
        if (! $this->localizedUrl) {
            return $this->fallback();
        }

        $attributes = $this->parseAttributes([
            'href' => $this->localizedUrl,
            'rel' => 'stylesheet',
            'type' => 'text/css',
            'nonce' => $this->nonce ?? false,
        ]);

        $preloadMeta = '';
        if ($this->preload) {
            $preloadMeta = $this->preloadMeta;

        }

        return new HtmlString(<<<HTML
            {$preloadMeta}
            <link {$attributes->implode(' ')}>
        HTML);
    }

    public function fallback(): HtmlString
    {
        $attributes = $this->parseAttributes([
            'href' => $this->googleFontsUrl,
            'rel' => 'stylesheet',
            'type' => 'text/css',
            'nonce' => $this->nonce ?? false,
        ]);

        if ($this->preload) {
            return new HtmlString(<<<HTML
                <link rel="preconnect" href="https://fonts.googleapis.com">
                <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
                <link {$attributes->implode(' ')}>
            HTML);
        }

        return new HtmlString(<<<HTML
            <link {$attributes->implode(' ')}>
        HTML);
    }

    public function url(): string
    {
        if (! $this->localizedUrl) {
            return $this->googleFontsUrl;
        }

        return $this->localizedUrl;
    }

    public function toHtml(): HtmlString
    {
        return $this->preferInline ? $this->inline() : $this->link();
    }

    protected function parseAttributes($attributes): Collection
    {
        return Collection::make($attributes)
            ->reject(fn ($value, $key) => in_array($value, [false, null], true))
            ->flatMap(fn ($value, $key) => $value === true ? [$key] : [$key => $value])
            ->map(fn ($value, $key) => is_int($key) ? $value : $key . '="' . $value . '"')
            ->values();
    }
}
