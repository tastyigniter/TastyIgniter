<?php

declare(strict_types=1);

namespace Igniter\System\DashboardWidgets;

use Facades\Igniter\System\Helpers\CacheHelper;
use Igniter\Admin\Classes\BaseDashboardWidget;
use Igniter\System\Helpers\CacheUsage;
use Override;

class Cache extends BaseDashboardWidget
{
    /**
     * @var string A unique alias to identify this widget.
     */
    protected string $defaultAlias = 'cache';

    #[Override]
    public function render(): string
    {
        $this->prepareVars();

        return $this->makePartial('cache/cache');
    }

    #[Override]
    public function defineProperties(): array
    {
        return [
            'title' => [
                'label' => 'igniter::admin.dashboard.label_widget_title',
                'default' => 'igniter::admin.dashboard.text_cache_usage',
                'type' => 'text',
            ],
        ];
    }

    protected function prepareVars()
    {
        $usage = CacheUsage::sizes();

        $this->vars['cacheSizes'] = $usage['cacheSizes'];
        $this->vars['totalCacheSize'] = $usage['totalCacheSize'];
        $this->vars['formattedTotalCacheSize'] = $usage['formattedTotalCacheSize'];
    }

    public function onClearCache(): array
    {
        rescue(fn() => CacheHelper::clear());

        $this->prepareVars();

        return [
            '#'.$this->getId() => $this->makePartial('cache/cache'),
        ];
    }
}
