<?php

declare(strict_types=1);

namespace Igniter\Orange\View\Components;

use Igniter\Cart\Models\Menu;
use Igniter\Main\Traits\ConfigurableComponent;
use Igniter\Orange\Data\MenuItemData;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Override;

final class FeaturedItems extends Component
{
    use ConfigurableComponent;

    public function __construct(
        public string $title = 'igniter.frontend::default.featured.text_featured_menus',
        public array $items = [],
        public int $limit = 6,
        public int $itemsPerRow = 3,
        public bool $showThumb = true,
        public ?int $itemWidth = 400,
        public ?int $itemHeight = 300,
    ) {}

    public static function componentMeta(): array
    {
        return [
            'code' => 'igniter-orange::featured-items',
            'name' => 'igniter.orange::default.component_featured_items_title',
            'description' => 'igniter.orange::default.component_featured_items_desc',
        ];
    }

    public function defineProperties(): array
    {
        return [
            'title' => [
                'label' => 'Title',
                'type' => 'text',
                'validationRule' => 'string',
            ],
            'items' => [
                'label' => 'lang:igniter.frontend::default.featured.label_menus',
                'type' => 'selectlist',
                'mode' => 'checkbox',
                'validationRule' => 'required|array',
            ],
            'limit' => [
                'label' => 'lang:igniter.frontend::default.featured.label_limit',
                'span' => 'left',
                'type' => 'number',
                'validationRule' => 'required|integer',
            ],
            'itemsPerRow' => [
                'label' => 'lang:igniter.frontend::default.featured.label_items_per_row',
                'span' => 'right',
                'type' => 'select',
                'options' => [
                    1 => 'One',
                    2 => 'Two',
                    3 => 'Three',
                    4 => 'Four',
                    5 => 'Five',
                    6 => 'Six',
                ],
                'validationRule' => 'required|integer',
            ],
            'showThumb' => [
                'label' => 'Show thumbnail image',
                'type' => 'switch',
                'validationRule' => 'required|boolean',
            ],
            'itemWidth' => [
                'label' => 'lang:igniter.frontend::default.featured.label_dimension_w',
                'span' => 'left',
                'type' => 'number',
                'validationRule' => 'integer',
            ],
            'itemHeight' => [
                'label' => 'lang:igniter.frontend::default.featured.label_dimension_h',
                'span' => 'right',
                'type' => 'number',
                'validationRule' => 'integer',
            ],
        ];
    }

    public static function getItemsOptions()
    {
        return Menu::whereIsEnabled()->dropdown('menu_name');
    }

    #[Override]
    public function render(): View
    {
        return view('igniter-orange::components.featured-items', [
            'featuredItems' => $this->loadItems(),
        ]);
    }

    protected function loadItems()
    {
        return Menu::query()
            ->with(['locations', 'media'])
            ->whereIn('menu_id', $this->items)
            ->take($this->limit)
            ->get()
            ->mapInto(MenuItemData::class);
    }
}
