<?php

declare(strict_types=1);

namespace Igniter\Orange\Livewire;

use Igniter\Admin\Classes\FormField;
use Igniter\Admin\Widgets\Form;
use Igniter\Cart\Models\Menu as MenuModel;
use Igniter\Local\Facades\Location;
use Igniter\Main\Traits\ConfigurableComponent;
use Igniter\Orange\Actions\ListMenuItems;
use Igniter\System\Facades\Assets;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

final class MenuItemList extends Component
{
    use ConfigurableComponent;
    use WithPagination;

    public bool $isGrouped = true;

    public int $collapseCategoriesAfter = 5;

    public int $itemsPerPage = 200;

    public string $sortOrder = 'menu_priority asc';

    public bool $showThumb = false;

    public int $menuThumbWidth = 95;

    public int $menuThumbHeight = 80;

    public int $categoryThumbWidth = 1240;

    public int $categoryThumbHeight = 256;

    public int $ingredientThumbWidth = 28;

    public int $ingredientThumbHeight = 28;

    public string $selectedCategorySlug = '';

    public bool $hideMenuSearch = false;

    public bool $hideUnavailableItems = false;

    #[Url(as: 'q')]
    public string $menuSearchTerm = '';

    #[Url(as: 'menuId')]
    public string $selectedMenuId = '';

    public static function componentMeta(): array
    {
        return [
            'code' => 'igniter-orange::menu-item-list',
            'name' => 'igniter.orange::default.component_menu_item_list_title',
            'description' => 'igniter.orange::default.component_menu_item_list_desc',
        ];
    }

    public function defineProperties(): array
    {
        return [
            'isGrouped' => [
                'label' => 'Group menu items by category.',
                'type' => 'switch',
                'span' => 'left',
                'validationRule' => 'required|boolean',
            ],
            'collapseCategoriesAfter' => [
                'label' => 'The number of categories to expand before collapsing the rest. Set to 0 to always expand all categories.',
                'type' => 'number',
                'validationRule' => 'required|numeric|min:0',
                'trigger' => [
                    'action' => 'disable',
                    'field' => 'isGrouped',
                    'condition' => 'unchecked',
                ],
            ],
            'itemsPerPage' => [
                'label' => 'Number of menu items to display per page.',
                'type' => 'number',
                'span' => 'left',
                'validationRule' => 'required|numeric|min:0',
            ],
            'sortOrder' => [
                'label' => 'Default sort order of menu items.',
                'type' => 'select',
                'span' => 'right',
                'validationRule' => 'required|string',
            ],
            'showThumb' => [
                'label' => 'Display menu item, category and allergen image thumb.',
                'type' => 'switch',
                'validationRule' => 'required|boolean',
            ],
            'menuThumbWidth' => [
                'label' => 'Menu item image thumb width',
                'type' => 'number',
                'span' => 'left',
                'validationRule' => 'required|numeric|min:0',
                'trigger' => [
                    'action' => 'show',
                    'field' => 'showThumb',
                    'condition' => 'checked',
                ],
            ],
            'menuThumbHeight' => [
                'label' => 'Menu item image thumb height',
                'type' => 'number',
                'span' => 'right',
                'validationRule' => 'required|numeric|min:0',
                'trigger' => [
                    'action' => 'show',
                    'field' => 'showThumb',
                    'condition' => 'checked',
                ],
            ],
            'categoryThumbWidth' => [
                'label' => 'Category image thumb width.',
                'type' => 'number',
                'span' => 'left',
                'validationRule' => 'required|numeric|min:0',
                'trigger' => [
                    'action' => 'show',
                    'field' => 'showThumb',
                    'condition' => 'checked',
                ],
            ],
            'categoryThumbHeight' => [
                'label' => 'Category image thumb height.',
                'type' => 'number',
                'span' => 'right',
                'validationRule' => 'required|numeric|min:0',
                'trigger' => [
                    'action' => 'show',
                    'field' => 'showThumb',
                    'condition' => 'checked',
                ],
            ],
            'ingredientThumbWidth' => [
                'label' => 'Allergen image thumb width.',
                'type' => 'number',
                'span' => 'left',
                'validationRule' => 'required|numeric|min:0',
                'trigger' => [
                    'action' => 'show',
                    'field' => 'showThumb',
                    'condition' => 'checked',
                ],
            ],
            'ingredientThumbHeight' => [
                'label' => 'Allergen image thumb height.',
                'type' => 'number',
                'span' => 'right',
                'validationRule' => 'required|numeric|min:0',
                'trigger' => [
                    'action' => 'show',
                    'field' => 'showThumb',
                    'condition' => 'checked',
                ],
            ],
            'hideMenuSearch' => [
                'label' => 'Hide the menu search form',
                'type' => 'switch',
                'validationRule' => 'required|boolean',
            ],
            'hideUnavailableItems' => [
                'label' => 'Hide unavailable menu items',
                'type' => 'switch',
                'validationRule' => 'required|boolean',
            ],
        ];
    }

    public static function getPropertyOptions(Form $form, FormField $field): array
    {
        return match ($field->getConfig('property')) {
            'sortOrder' => collect((new MenuModel)->queryModifierGetSorts())->mapWithKeys(fn($value, $key): array => [$value => $value])->all(),
            default => [],
        };
    }

    public function render(): View
    {
        $menuListAction = $this->loadList();

        return view('igniter-orange::livewire.menu-item-list', [
            'menuList' => $menuListAction->getList(),
            'menuListCategories' => $menuListAction->getCategoryList(),
        ]);
    }

    public function mount(): void
    {
        Assets::addJs('igniter-orange::/js/menus.js', 'menus-js');

        $this->selectedCategorySlug = request()->route()->parameter('category', '');
    }

    public function onAddToCart(int $menuId, int $quantity, bool $openModal = false): void
    {
        if ($openModal) {
            $this->dispatch('openModal', component: 'igniter-orange::cart-item-modal', arguments: [
                'menuId' => $menuId,
                'quantity' => $quantity,
            ]);
        } else {
            $this->dispatch('cart-box:add-item', menuId: $menuId, quantity: $quantity);
        }
    }

    protected function loadList(): ListMenuItems
    {
        $location = Location::current()?->getKey();

        $filters = [
            'sort' => $this->sortOrder,
            'location' => $location,
            'category' => $this->selectedCategorySlug,
            'search' => $this->menuSearchTerm,
            'orderType' => Location::orderType(),
            'isGrouped' => $this->isGrouped,
        ];

        if ($this->itemsPerPage > 0) {
            $filters['page'] = $this->getPage();
            $filters['pageLimit'] = $this->itemsPerPage;
        }

        $with = [];

        if ($this->showThumb) {
            $with[] = 'media';
            $with[] = 'categories.media';
            $with[] = 'ingredients.media';
        }

        return resolve(ListMenuItems::class)
            ->hideUnavailable($this->hideUnavailableItems)
            ->handle($filters, $with);
    }
}
