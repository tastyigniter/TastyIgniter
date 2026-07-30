<?php

declare(strict_types=1);

namespace Igniter\System\Helpers;

use Igniter\Flame\Support\Facades\File;
use Illuminate\Support\Number;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class CacheUsage
{
    public const int WARN_BYTES = 104857600;

    /** @var array<int, array{path: string, color: string}> */
    protected static array $caches = [
        ['path' => 'framework/views', 'color' => '#2980b9'],
        ['path' => 'igniter/cache', 'color' => '#16a085'],
        ['path' => 'framework/cache', 'color' => '#8e44ad'],
        ['path' => 'igniter/combiner', 'color' => '#c0392b'],
    ];

    /**
     * @return array{cacheSizes: object[], totalCacheSize: int, formattedTotalCacheSize: string}
     */
    public static function sizes(): array
    {
        $totalCacheSize = 0;
        $cacheSizes = [];

        foreach (self::$caches as $cacheInfo) {
            if (!File::isDirectory($directory = storage_path().'/'.$cacheInfo['path'])) {
                continue;
            }

            $size = self::folderSize($directory);
            $cacheSizes[] = (object)[
                'label' => $cacheInfo['path'],
                'color' => $cacheInfo['color'],
                'size' => $size,
                'formattedSize' => Number::fileSize($size),
            ];

            $totalCacheSize += $size;
        }

        return [
            'cacheSizes' => $cacheSizes,
            'totalCacheSize' => $totalCacheSize,
            'formattedTotalCacheSize' => Number::fileSize($totalCacheSize),
        ];
    }

    protected static function folderSize(string $directory): int
    {
        $size = 0;

        foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory)) as $file) {
            $size += $file->getSize();
        }

        return $size;
    }
}
