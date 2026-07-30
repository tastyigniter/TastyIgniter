<?php

declare(strict_types=1);

namespace Igniter\Orange\View\Components;

use Igniter\Cart\Models\Category;
use Igniter\Local\Facades\Location;
use Igniter\Main\Traits\ConfigurableComponent;
use Igniter\Main\Traits\UsesPage;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;
use Override;

final class CategoryList extends Component
{
    use ConfigurableComponent;
    use UsesPage;

    protected static ?Collection $categoriesCache = null;

    protected static ?Category $selectedCategoryCache = null;

    public function __construct(
        public string $menusPage = 'local.menus',
        public bool $hideEmpty = true,
        public bool $useLinkAnchor = true,
    ) {}

    public static function componentMeta(): array
    {
        return [
            'code' => 'igniter-orange::category-list',
            'name' => 'igniter.orange::default.component_category_list_title',
            'description' => 'igniter.orange::default.component_category_list_desc',
        ];
    }

    public function defineProperties(): array
    {
        return [
            'menusPage' => [
                'label' => 'Page to redirect to when a category is clicked.',
                'type' => 'select',
                'options' => self::getThemePageOptions(...),
                'validationRule' => 'required|regex:/^[a-z0-9\-_\.]+$/i',
            ],
            'hideEmpty' => [
                'label' => 'Hide empty categories with no menu items',
                'type' => 'switch',
                'validationRule' => 'required|boolean',
            ],
            'useLinkAnchor' => [
                'label' => 'Use link anchor for category links',
                'type' => 'switch',
                'validationRule' => 'required|boolean',
            ],
        ];
    }

    #[Override]
    public function render(): View
    {
        return view('igniter-orange::components.category-list', [
            'categories' => $this->loadCategories(),
            'selectedCategory' => $this->findSelectedCategory(),
        ]);
    }

    protected function loadCategories()
    {
        if (!is_null(self::$categoriesCache)) {
            return self::$categoriesCache;
        }

        $location = Location::current();

        $query = Category::query()
            ->with([
                'children',
                'children.children',
            ])
            ->withCount([
                'menus' => function($query) use ($location): void {
                    if ($location) {
                        $query->whereHasOrDoesntHaveLocation($location->getKey());
                    }
                },
            ])
            ->whereIsEnabled()->sorted();

        if ($location) {
            $query->whereHasOrDoesntHaveLocation($location->getKey());
        }

        return self::$categoriesCache = $query->get();
    }

    protected function findSelectedCategory()
    {
        if ((string)($slug = request()->route()->parameter('category', '')) === '') {
            return null;
        }

        if (!is_null(self::$selectedCategoryCache)) {
            return self::$selectedCategoryCache;
        }

        $query = Category::query()->whereIsEnabled()->where('permalink_slug', $slug);
        if ($location = Location::current()) {
            $query->whereHasOrDoesntHaveLocation($location->getKey());
        }

        return self::$selectedCategoryCache = $query->first();
    }
}
