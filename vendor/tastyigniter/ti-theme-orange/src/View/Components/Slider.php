<?php

declare(strict_types=1);

namespace Igniter\Orange\View\Components;

use Igniter\Frontend\Models\Slider as SliderModel;
use Igniter\Main\Traits\ConfigurableComponent;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;
use Override;

final class Slider extends Component
{
    use ConfigurableComponent;

    public array|Collection $slides = [];

    public function __construct(
        public string $code = 'home-slider',
        public string $height = '60vh',
        public string $effect = 'ease',
        public int $delayInterval = 5000,
        public bool $hideControls = false,
        public bool $hideIndicators = false,
        public bool $hideCaptions = false,
    ) {}

    public static function componentMeta(): array
    {
        return [
            'code' => 'igniter-orange::slider',
            'name' => 'igniter.orange::default.component_slider_title',
            'description' => 'igniter.orange::default.component_slider_desc',
        ];
    }

    public function defineProperties(): array
    {
        return [
            'code' => [
                'label' => 'lang:igniter.frontend::default.slider.label_slider',
                'type' => 'select',
                'validationRule' => 'required|alpha_dash',
            ],
            'height' => [
                'label' => 'lang:igniter.frontend::default.banners.label_height',
                'span' => 'left',
                'type' => 'text',
                'validationRule' => 'required|string',
            ],
            'effect' => [
                'label' => 'lang:igniter.frontend::default.slider.label_effect',
                'span' => 'right',
                'type' => 'text',
                'validationRule' => 'required|string',
            ],
            'delayInterval' => [
                'label' => 'lang:igniter.frontend::default.slider.label_interval',
                'span' => 'left',
                'type' => 'number',
                'validationRule' => 'required|integer',
            ],
            'hideControls' => [
                'label' => 'lang:igniter.frontend::default.slider.label_hide_controls',
                'span' => 'right',
                'type' => 'switch',
                'validationRule' => 'required|boolean',
            ],
            'hideIndicators' => [
                'label' => 'lang:igniter.frontend::default.slider.label_hide_indicators',
                'span' => 'left',
                'type' => 'switch',
                'validationRule' => 'required|boolean',
            ],
            'hideCaptions' => [
                'label' => 'lang:igniter.frontend::default.slider.label_hide_captions',
                'span' => 'right',
                'type' => 'switch',
                'validationRule' => 'required|boolean',
            ],
        ];
    }

    public static function getCodeOptions()
    {
        return SliderModel::lists('name', 'code')->all();
    }

    #[Override]
    public function render(): View
    {
        return view('igniter-orange::components.slider', [
            'slides' => $this->slides(),
        ]);
    }

    protected function slides(): Collection|array
    {
        if ($this->code && $slider = SliderModel::whereCode($this->code)->first()) {
            /** @var SliderModel $slider */
            $this->slides = $slider->images;
        }

        return $this->slides;
    }
}
