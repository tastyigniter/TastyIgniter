<?php

declare(strict_types=1);

namespace Igniter\Orange\Data;

use Igniter\Cart\Models\Mealtime;
use Igniter\Cart\Models\Menu;
use Igniter\Local\Facades\Location;

class MenuItemData
{
    public int $id;

    public string $name;

    public string $description;

    protected ?float $price = null;

    public ?float $priceBeforeSpecial = null;

    public ?int $minimumQuantity = 0;

    protected ?bool $mealtimeIsAvailable = null;

    public function __construct(public Menu $model)
    {
        $this->id = $model->getBuyableIdentifier();
        $this->name = $model->getBuyableName();
        $this->description = nl2br($model->menu_description ?? '');
        $this->priceBeforeSpecial = $model->menu_price;
        $this->minimumQuantity = $model->minimum_qty;
    }

    public function price()
    {
        if (!is_null($this->price)) {
            return $this->price;
        }

        return $this->price = $this->model->getBuyablePrice();
    }

    public function hasIngredients()
    {
        return $this->ingredients()->isNotEmpty();
    }

    public function ingredients()
    {
        return $this->model->ingredients->where('status', 1);
    }

    public function mealtimeIsAvailable()
    {
        if (!is_null($this->mealtimeIsAvailable)) {
            return $this->mealtimeIsAvailable;
        }

        return $this->mealtimeIsAvailable = $this->model->isAvailable(Location::orderDateTime());
    }

    public function hasOptions(): bool
    {
        return $this->model->hasOptions();
    }

    public function getOptions()
    {
        return $this->model->menu_options->sortBy('priority');
    }

    public function hasThumb(): bool
    {
        return $this->model->hasMedia('thumb');
    }

    public function getThumb(array $options = [], ?string $tag = null)
    {
        return $this->model->getThumbOrBlank($options, $tag);
    }

    public function specialIsActive()
    {
        return $this->model->special?->active();
    }

    public function specialDaysRemaining()
    {
        return $this->model->special?->daysRemaining();
    }

    public function mealtimeTitles(): string
    {
        return $this->model->mealtimes
            ->filter(fn(Mealtime $mealtime): bool => $mealtime->isEnabled())
            ->pluck('description')
            ->join(', ');
    }

    public function getUrl(?string $pageId = null): string
    {
        $current = Location::current();
        $slug = $this->model->locations->first()?->permalink_slug;
        if ($current && ($this->model->locations->isEmpty() || $this->model->locations->firstWhere('location_id', $current->getKey()))) {
            $slug = $current->permalink_slug;
        }

        $url = page_url($pageId ?? 'local.menus', ['location' => $slug]);

        return $url.'?menuId='.$this->model->getBuyableIdentifier();
    }
}
