<?php

declare(strict_types=1);

namespace Igniter\Orange\Data;

use Igniter\Frontend\Models\Banner;
use Igniter\Main\Helpers\ImageHelper;

class BannerData
{
    public string $code;

    public string $id;

    public ?string $clickUrl = null;

    public ?string $altText = null;

    public array $images = [];

    public ?string $markup = null;

    public int $imageWidth = 0;

    public int $imageHeight = 0;

    public function __construct(protected Banner $model)
    {
        $this->code = $model->code;
        $this->id = $model->code.'-'.$model->banner_id.'-'.strtolower(str_random(4));
        $this->clickUrl = starts_with($model->click_url, ['http://', 'https://']) ? $model->click_url : page_url($model->click_url);
        $this->altText = $model->alt_text;
        $this->markup = $model->custom_code;
    }

    public function isCustom(): bool
    {
        return $this->model->type == 'custom';
    }

    public function isCarousel(): bool
    {
        return $this->isImage() && count($this->model->image_code ?: []) > 1;
    }

    public function isImage(): bool
    {
        return $this->model->type == 'image';
    }

    public function imageUrls(): array
    {
        if (!$this->model->image_code) {
            return [];
        }

        return array_map(fn(string $path): string => ImageHelper::resize($path, [
            'width' => $this->imageWidth,
            'height' => $this->imageHeight,
        ]), array_filter((array)$this->model->image_code));
    }
}
