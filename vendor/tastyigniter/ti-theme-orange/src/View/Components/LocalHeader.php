<?php

declare(strict_types=1);

namespace Igniter\Orange\View\Components;

use Igniter\Local\Classes\WorkingSchedule;
use Igniter\Local\Facades\Location;
use Igniter\Local\Models\ReviewSettings;
use Igniter\Main\Traits\ConfigurableComponent;
use Igniter\Main\Traits\UsesPage;
use Igniter\Orange\Data\LocationData;
use Igniter\Orange\Livewire\Concerns\WithReviews;
use Igniter\System\Facades\Assets;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Override;

final class LocalHeader extends Component
{
    use ConfigurableComponent;
    use UsesPage;
    use WithReviews;

    public function __construct(
        public bool $showThumb = true,
        public int $localThumbWidth = 320,
        public int $localThumbHeight = 160,
        public int $reviewPerPage = 10,
        public string $reviewSortOrder = 'created_at desc',
        public string $reviewsPage = 'local.reviews',
        public string $currentPage = 'local.menus',
    ) {
        $this->itemPerPage = $this->reviewPerPage;
        $this->sortOrder = $this->reviewSortOrder;
    }

    public static function componentMeta(): array
    {
        return [
            'code' => 'igniter-orange::local-header',
            'name' => 'igniter.orange::default.component_local_header_title',
            'description' => 'igniter.orange::default.component_local_header_desc',
        ];
    }

    public function defineProperties(): array
    {
        return [
            'showThumb' => [
                'label' => 'Display the location image thumb.',
                'type' => 'switch',
            ],
            'localThumbWidth' => [
                'label' => 'Location thumb width',
                'type' => 'number',
            ],
            'localThumbHeight' => [
                'label' => 'Location thumb height',
                'type' => 'number',
            ],
            'reviewPerPage' => [
                'label' => 'Number of reviews to display per page',
                'type' => 'number',
                'validationRule' => 'integer|min:1',
            ],
            'reviewSortOrder' => [
                'label' => 'Default sort order of reviews.',
                'type' => 'select',
                'options' => self::getSortOrderOptionsWithReviews(...),
                'validationRule' => 'required|string',
            ],
            'reviewsPage' => [
                'label' => 'Page to redirect to when the "see more reviews" link is clicked.',
                'type' => 'select',
                'options' => self::getThemePageOptions(...),
                'validationRule' => 'required|regex:/^[a-z0-9\-_\.]+$/i',
            ],
        ];
    }

    #[Override]
    public function shouldRender(): bool
    {
        return !is_null(resolve('location')->current());
    }

    #[Override]
    public function render(): View
    {
        Assets::addCss('igniter.local::/css/starrating.css', 'starrating-css');
        Assets::addJs('igniter.local::/js/starrating.js', 'starrating-js');

        Location::current()->loadCount([
            'reviews' => fn($q) => $q->isApproved(),
        ]);

        return view('igniter-orange::components.local-header', [
            'locationInfo' => LocationData::current(),
            'allowReviews' => ReviewSettings::allowReviews(),
        ]);
    }

    public function listReviews()
    {
        return $this->loadReviewList(1);
    }

    public function currentSchedule($locationInfo): WorkingSchedule
    {
        return $this->currentPage === 'local.menus'
            ? $locationInfo->orderType()->getSchedule()
            : $locationInfo->openingSchedule();
    }
}
