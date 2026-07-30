<?php

declare(strict_types=1);

namespace Igniter\Admin\FormWidgets;

use Igniter\Admin\Classes\BaseFormWidget;
use Override;

/**
 * Color picker
 * Renders a color picker field.
 *
 * Adapted from october\backend\formwidgets\ColorPicker
 */
class ColorPicker extends BaseFormWidget
{
    //
    // Configurable properties
    //

    /**
     * @var array Default available colors
     */
    public array $availableColors = [
        '#1abc9c', '#16a085',
        '#9b59b6', '#8e44ad',
        '#34495e', '#2b3e50',
        '#f1c40f', '#f39c12',
        '#e74c3c', '#c0392b',
        '#95a5a6', '#7f8c8d',
    ];

    /** Show opacity slider */
    public bool $showAlpha = false;

    /** If true, the color picker is set to read-only mode */
    public bool $readOnly = false;

    /** If true, the color picker is set to disabled mode */
    public bool $disabled = false;

    //
    // Object properties
    //

    protected string $defaultAlias = 'colorpicker';

    #[Override]
    public function initialize(): void
    {
        $this->fillFromConfig([
            'availableColors',
            'showAlpha',
            'readOnly',
            'disabled',
        ]);
    }

    #[Override]
    public function render(): string
    {
        $this->prepareVars();

        return $this->makePartial('colorpicker/colorpicker');
    }

    /**
     * Prepares the list data
     */
    public function prepareVars(): void
    {
        $this->vars['name'] = $this->formField->getName();
        $this->vars['value'] = $this->getLoadValue();
        $this->vars['availableColors'] = $this->availableColors();
        $this->vars['showAlpha'] = $this->showAlpha;
        $this->vars['readOnly'] = $this->readOnly;
        $this->vars['disabled'] = $this->disabled;
    }

    #[Override]
    public function loadAssets(): void
    {
        $this->addJs('colorpicker.js', 'colorpicker-js');
    }

    #[Override]
    public function getSaveValue(mixed $value): ?string
    {
        return !empty($value) ? $value : null;
    }

    protected function availableColors(): array
    {
        $colors = [];
        foreach ($this->availableColors as $availableColor) {
            $colors[$availableColor] = $availableColor;
        }

        return $colors;
    }
}
