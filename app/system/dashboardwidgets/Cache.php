<?php namespace System\DashboardWidgets;

use Admin\Classes\BaseDashboardWidget;
use Exception;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class Cache extends BaseDashboardWidget
{
    /**
     * @var string A unique alias to identify this widget.
     */
    protected $defaultAlias = 'cache';

    protected static $caches = [
        [
            'path'  => 'system/templates',
            'color' => '#2980b9',
        ],
        [
            'path'  => 'system/cache',
            'color' => '#16a085',
        ],
        [
            'path'  => 'framework/cache',
            'color' => '#8e44ad',
        ],
        [
            'path'  => 'system/combiner',
            'color' => '#c0392b',
        ],
    ];

    public function render()
    {
        $this->prepareVars();

        return $this->makePartial('cache/cache');
    }

    public function defineProperties()
    {
        return [
            'title' => [
                'label'   => 'admin::lang.dashboard.label_widget_title',
                'default' => 'admin::lang.dashboard.text_cache_usage',
                'type'    => 'text',
            ],
        ];
    }

    protected function prepareVars()
    {
        $totalCacheSize = 0;
        $cacheSizes = [];
        foreach (self::$caches as $cacheInfo) {

            $size = $this->folderSize(storage_path().'/'.$cacheInfo['path']);

            $cacheSizes[] = (object)[
                'label'         => $cacheInfo['path'],
                'color'         => $cacheInfo['color'],
                'size'          => $size,
                'formattedSize' => $this->formatSize($size),
            ];

            $totalCacheSize += $size;
        }

        $this->vars['cacheSizes'] = $cacheSizes;
        $this->vars['totalCacheSize'] = $totalCacheSize;
        $this->vars['formattedTotalCacheSize'] = $this->formatSize($totalCacheSize);
    }

    public function onClearCache()
    {
        \Artisan::call('cache:clear');
        try {
            \Artisan::call('view:clear');
        }
        catch (Exception $ex) {
            // ...
        }

        $this->prepareVars();

        return [
            '#'.$this->getId() => $this->makePartial('cache/cache'),
        ];
    }

    protected function formatSize($size)
    {
        return round($size / 1024, 0).' KB';
    }

    protected function folderSize($directory)
    {
        if (count(scandir($directory, SCANDIR_SORT_NONE)) == 2) {
            return 0;
        }

        $size = 0;

        foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory)) as $file) {
            $size += $file->getSize();
        }

        return $size;
    }
}
