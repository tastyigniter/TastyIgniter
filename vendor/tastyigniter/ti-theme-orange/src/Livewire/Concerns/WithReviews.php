<?php

declare(strict_types=1);

namespace Igniter\Orange\Livewire\Concerns;

use Igniter\Local\Facades\Location;
use Igniter\Local\Models\Review as ReviewModel;
use Igniter\System\Facades\Assets;
use Livewire\WithPagination;

trait WithReviews
{
    use WithPagination;

    public int $itemPerPage = 20;

    public string $sortOrder = 'created_at desc';

    public function mountListReviews(): void
    {
        Assets::addCss('igniter.local::/css/starrating.css', 'starrating-css');
        Assets::addJs('igniter.local::/js/starrating.js', 'starrating-js');
    }

    protected function loadReviewList($page = null)
    {
        if (!$location = Location::current()) {
            return null;
        }

        return ReviewModel::query()
            ->with([
                'customer' => fn($query) => $query->select('customer_id', 'address_id'),
                'customer.address' => fn($query) => $query->select('address_id', 'customer_id', 'city'),
            ])
            ->isApproved()
            ->listFrontEnd([
                'page' => $page ?? $this->getPage(),
                'pageLimit' => $this->itemPerPage,
                'sort' => $this->sortOrder,
                'location' => $location->getKey(),
            ]);
    }

    public static function getSortOrderOptionsWithReviews(): array
    {
        return collect((new ReviewModel)->queryModifierGetSorts())->mapWithKeys(fn($value, $key): array => [$value => $value])->all();
    }
}
