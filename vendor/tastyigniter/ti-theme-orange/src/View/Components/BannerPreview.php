<?php

declare(strict_types=1);

namespace Igniter\Orange\View\Components;

use Igniter\Frontend\Models\Banner;
use Igniter\Main\Traits\ConfigurableComponent;
use Igniter\Orange\Data\BannerData;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Override;

final class BannerPreview extends Component
{
    use ConfigurableComponent;

    protected ?BannerData $banner = null;

    public function __construct(
        public string $code = '',
        public int $width = 960,
        public int $height = 360,
    ) {}

    public static function componentMeta(): array
    {
        return [
            'code' => 'igniter-orange::banner-preview',
            'name' => 'igniter.orange::default.component_banner_preview_title',
            'description' => 'igniter.orange::default.component_banner_preview_desc',
        ];
    }

    public function defineProperties(): array
    {
        return [
            'code' => [
                'label' => 'lang:igniter.frontend::default.banners.label_banner',
                'type' => 'select',
                'validationRule' => 'required|alpha_dash',
            ],
            'width' => [
                'label' => 'lang:igniter.frontend::default.banners.label_width',
                'span' => 'left',
                'type' => 'number',
                'validationRule' => 'required|integer',
            ],
            'height' => [
                'label' => 'lang:igniter.frontend::default.banners.label_height',
                'span' => 'right',
                'type' => 'number',
                'validationRule' => 'required|integer',
            ],
        ];
    }

    public static function getCodeOptions()
    {
        return Banner::query()->whereIsEnabled()->dropdown('name');
    }

    #[Override]
    public function render(): View
    {
        return view('igniter-orange::components.banner-preview', [
            'bannerData' => $this->loadBanner(),
        ]);
    }

    #[Override]
    public function shouldRender(): bool
    {
        return $this->loadBanner() !== null;
    }

    protected function loadBanner()
    {
        if ($this->banner instanceof BannerData) {
            return $this->banner;
        }

        /** @var null|Banner $model */
        $model = Banner::query()->whereIsEnabled()->whereCode($this->code)->first();

        return $this->banner = $model ? tap(new BannerData($model), function($bannerData): void {
            $bannerData->imageWidth = $this->width;
            $bannerData->imageHeight = $this->height;
        }) : null;
    }
}
