<?php

declare(strict_types=1);

namespace Igniter\Orange\Livewire;

use Igniter\Main\Traits\ConfigurableComponent;
use Igniter\Orange\Livewire\Concerns\SearchesNearby;
use Illuminate\Contracts\View\View;
use Livewire\Component;

final class LocalSearch extends Component
{
    use ConfigurableComponent;
    use SearchesNearby;

    public bool $hideSearch = false;

    public static function componentMeta(): array
    {
        return [
            'code' => 'igniter-orange::local-search',
            'name' => 'igniter.orange::default.component_local_search_title',
            'description' => 'igniter.orange::default.component_local_search_desc',
        ];
    }

    public function defineProperties(): array
    {
        return array_merge([
            'hideSearch' => [
                'label' => 'Hide the search field and display a view menu button.',
                'type' => 'switch',
            ],
        ], $this->definePropertiesSearchNearby());
    }

    public function render(): View
    {
        return view('igniter-orange::livewire.local-search');
    }
}
