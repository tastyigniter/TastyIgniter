<?php

declare(strict_types=1);

namespace Igniter\Admin\Classes;

use Closure;
use Igniter\Flame\Html\HtmlFacade as Html;
use Igniter\Flame\Support\Facades\File;
use Illuminate\Support\HtmlString;

/**
 * Template Class
 */
class Template
{
    protected ?string $themeCode = null;

    protected ?string $pageTitle = null;

    protected ?string $pageHeading = null;

    protected array $pageButtons = [];

    public array $blocks = [];

    public array $renderHooks = [];

    /**
     * Returns the layout block contents but does not deletes the block from memory.
     *
     * @param string $name Specifies the block name.
     * @param ?string $default Specifies a default block value to use if the block requested is not exists.
     */
    public function getBlock(string $name, ?string $default = null): HtmlString
    {
        return new HtmlString($this->blocks[$name] ?? $default);
    }

    /**
     * Appends a content of the layout block.
     *
     * @param string $name Specifies the block name.
     * @param string $contents Specifies the block content.
     */
    public function appendBlock(string $name, string $contents): void
    {
        if (!isset($this->blocks[$name])) {
            $this->blocks[$name] = '';
        }

        $this->blocks[$name] .= $contents;
    }

    /**
     * Sets a content of the layout block.
     *
     * @param string $name Specifies the block name.
     * @param string $contents Specifies the block content.
     */
    public function setBlock(string $name, string $contents): void
    {
        $this->blocks[$name] = $contents;
    }

    public function getTitle(): ?string
    {
        return $this->pageTitle;
    }

    public function getHeading(): ?string
    {
        return $this->pageHeading;
    }

    public function getButtonList(): string
    {
        return implode(PHP_EOL, $this->pageButtons);
    }

    public function setTitle(string $title): void
    {
        $this->pageTitle = $title;
    }

    public function setHeading(string $heading): void
    {
        if (strpos($heading, ':')) {
            [$normal, $small] = explode(':', $heading);
            $heading = $normal.'&nbsp;<small>'.$small.'</small>';
        }

        $this->pageHeading = $heading;
    }

    public function setButton(string $name, array $attributes = []): void
    {
        $this->pageButtons[] = '<a'.Html::attributes($attributes).'>'.$name.'</a>';
    }

    public function renderHook(string $name): HtmlString
    {
        $hooks = array_map(fn(callable $hook) => (string)app()->call($hook),
            $this->renderHooks[$name] ?? [],
        );

        return new HtmlString(implode('', $hooks));
    }

    public function registerHook(string $name, Closure $callback): void
    {
        $this->renderHooks[$name][] = $callback;
    }

    public function renderStaticCss(): string
    {
        $file = 'igniter::build/css/static.css';

        return File::exists($file) ? File::get($file) : '';
    }
}
