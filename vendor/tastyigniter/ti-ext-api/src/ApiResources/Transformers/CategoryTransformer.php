<?php

declare(strict_types=1);

namespace Igniter\Api\ApiResources\Transformers;

use Igniter\Api\Traits\MergesIdAttribute;
use Igniter\Cart\Models\Category;
use Igniter\Flame\Database\Attach\Media;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\TransformerAbstract;

class CategoryTransformer extends TransformerAbstract
{
    use MergesIdAttribute;

    protected array $availableIncludes = [
        'media',
        'menus',
        'locations',
    ];

    public function transform(Category $category): array
    {
        return $this->mergesIdAttribute($category);
    }

    public function includeMedia(Category $category): ?Item
    {
        $thumb = $category->getFirstMedia();

        return ($thumb instanceof Media) ? $this->item($thumb, new MediaTransformer, 'media') : null;
    }

    public function includeMenus(Category $category): ?Collection
    {
        return $this->collection($category->menus, new MenuTransformer, 'menus');
    }

    public function includeLocations(Category $category): ?Collection
    {
        return $this->collection($category->locations, new LocationTransformer, 'locations');
    }
}
