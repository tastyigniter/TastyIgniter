<?php

namespace Main\Classes;

use Igniter\Flame\Database\Attach\Manipulator;
use Igniter\Flame\Exception\SystemException;
use Igniter\Flame\Support\Facades\File;
use Igniter\Flame\Support\Str;
use Igniter\Flame\Traits\Singleton;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use System\Models\Settings_model;

/**
 * MediaLibrary Class
 */
class MediaLibrary
{
    use Singleton;

    protected static $cacheKey = 'main.media.contents';

    protected $storageDisk;

    protected $storagePath;

    protected $storageFolder;

    protected $ignoreNames;

    protected $ignorePatterns;

    protected $storageFolderNameLength;

    protected $config = [];

    public function initialize()
    {
        $config = setting('image_manager', []);

        $this->storageFolder = $this->validatePath(Config::get('system.assets.media.folder', 'data'));
        $this->storagePath = rtrim(Config::get('system.assets.media.path', '/assets/images/data'), '/');

        if (!starts_with($this->storagePath, ['//', 'http://', 'https://'])) {
            $this->storagePath = asset($this->storagePath);
        }

        $this->ignoreNames = Config::get('system.assets.media.ignore', []);
        $this->ignorePatterns = Config::get('system.assets.media.ignorePatterns', ['^\..*']);
        $this->storageFolderNameLength = strlen($this->storageFolder);
        $this->config = $config;
    }

    public function listFolderContents($fullPath, $methodName, $recursive = false)
    {
        $cached = Cache::get(self::$cacheKey, false);
        $cached = $cached ? @unserialize(@base64_decode($cached)) : [];

        if (!is_array($cached)) {
            $cached = [];
        }

        $cacheSuffix = $recursive ? 'recursive' : 'single';
        $cachedKey = "{$cacheSuffix}.{$methodName}.{$fullPath}";

        if (array_has($cached, $cachedKey)) {
            $folderContents = array_get($cached, $cachedKey);
        } else {
            $folderContents = $this->scanFolderContents($fullPath, $methodName, $recursive);

            $cached[$cacheSuffix][$methodName][$fullPath] = $folderContents;
            Cache::put(
                self::$cacheKey,
                base64_encode(serialize($cached)),
                Config::get('system.assets.media.ttl', now()->addMinutes(10))
            );
        }

        return $folderContents;
    }

    public function listAllFolders($path = null, array $exclude = [])
    {
        return $this->listFolders($path, $exclude, true);
    }

    public function listFolders($path = null, array $exclude = [], $recursive = false)
    {
        if (is_null($path))
            $path = '/';

        $path = $this->validatePath($path);

        $fullPath = $this->getMediaPath($path);

        $folders = $this->listFolderContents($fullPath, 'directories', $recursive);

        $result = [];
        $folders = array_unique($folders, SORT_LOCALE_STRING);
        foreach ($folders as $folder) {
            $folder = $this->getMediaRelativePath($folder);
            if (!strlen($folder))
                $folder = '/';

            if (starts_with($folder, $exclude))
                continue;

            $result[] = $folder;
        }

        if ($path == '/' && !in_array('/', $result))
            array_unshift($result, '/');

        return $result;
    }

    public function fetchFiles($path, $sortBy = [], $options = null)
    {
        if (is_string($options))
            $options = ['search' => $options, 'filter' => 'all'];

        $path = $this->validatePath($path);

        $fullPath = $this->getMediaPath($path);

        $files = $this->listFolderContents($fullPath, 'files');

        $this->sortFiles($files, $sortBy);

        $this->searchFiles($files, array_get($options, 'search'));

        $this->filterFiles($files, array_get($options, 'filter'));

        return $files;
    }

    public function get($path, $stream = false)
    {
        $path = $this->validatePath($path);
        $fullPath = $this->getMediaPath($path);

        $storageDisk = $this->getStorageDisk();

        return $stream
            ? $storageDisk->readStream($fullPath)
            : $storageDisk->get($fullPath);
    }

    public function put($path, $contents)
    {
        $path = $this->validatePath($path);
        $fullPath = $this->getMediaPath($path);

        return $this->getStorageDisk()->put($fullPath, $contents);
    }

    public function makeFolder($name)
    {
        $path = $this->validatePath($name);

        $fullPath = $this->getMediaPath($path);

        return $this->getStorageDisk()->makeDirectory($fullPath);
    }

    public function copyFile($srcPath, $destPath)
    {
        $srcPath = $this->validatePath($srcPath);
        $fullSrcPath = $this->getMediaPath($srcPath);

        $destPath = $this->validatePath($destPath);
        $fullDestPath = $this->getMediaPath($destPath);

        return $this->getStorageDisk()->copy($fullSrcPath, $fullDestPath);
    }

    public function moveFile($path, $newPath)
    {
        $path = $this->validatePath($path);
        $fullPath = $this->getMediaPath($path);

        $newPath = $this->validatePath($newPath);
        $fullNewPath = $this->getMediaPath($newPath);

        return $this->getStorageDisk()->move($fullPath, $fullNewPath);
    }

    public function rename($path, $newPath)
    {
        $path = $this->validatePath($path);
        $fullPath = $this->getMediaPath($path);

        $newPath = $this->validatePath($newPath);
        $fullNewPath = $this->getMediaPath($newPath);

        return $this->getStorageDisk()->rename($fullPath, $fullNewPath);
    }

    public function deleteFiles($paths)
    {
        $fullPaths = [];
        foreach ($paths as $path) {
            $path = $this->validatePath($path);
            $fullPaths[] = $this->getMediaPath($path);
        }

        return $this->getStorageDisk()->delete($fullPaths);
    }

    public function deleteFolder($path)
    {
        $path = $this->validatePath($path);

        $fullPath = $this->getMediaPath($path);

        return $this->getStorageDisk()->deleteDirectory($fullPath);
    }

    public function exists($path)
    {
        $path = $this->validatePath($path);
        $fullPath = $this->getMediaPath($path);

        return $this->getStorageDisk()->exists($fullPath);
    }

    public function validatePath($path, $stripTrailingSlash = false)
    {
        $path = str_replace('\\', '/', $path);
        $path = trim($path, '/');

        return $stripTrailingSlash ? $path : '/'.$path;
    }

    public function getMediaUrl($path)
    {
        if (starts_with($path, ['http://', 'https://', '//']))
            return $path;

        $path = $this->validatePath($path);

        return $this->storagePath.$path;
    }

    public function getMediaPath($path)
    {
        if (starts_with($path, base_path()))
            return $path;

        return $this->validatePath($this->storageFolder.$path, true);
    }

    public function getMediaThumb($path, $options)
    {
        $options = array_merge([
            'fit' => 'contain',
            'width' => 0,
            'height' => 0,
            'quality' => 90,
            'sharpen' => 0,
            'extension' => 'auto',
            'default' => null,
        ], $options);

        $path = $this->validatePath($path);

        $filePath = $this->getMediaPath($path);
        if (!starts_with($path, base_path()))
            $filePath = $this->getStorageDisk()->path($filePath);

        $thumbFile = $this->getMediaThumbFile($filePath, $options);
        $thumbPath = temp_path($this->validatePath($thumbFile, true));
        $thumbPublicPath = File::localToPublic($thumbPath);

        if (File::exists($thumbPath))
            return asset($thumbPublicPath);

        $this->ensureDirectoryExists($thumbPath);

        if (!File::exists($filePath))
            $filePath = $this->getDefaultThumbPath($thumbPath, array_get($options, 'default'));

        $manipulator = Manipulator::make($filePath)->useSource(
            $this->getStorageDisk()->getDriver()
        );

        if ($manipulator->isSupported())
            $manipulator->manipulate(array_except($options, ['extension', 'default']));

        $manipulator->save($thumbPath);

        return asset($thumbPublicPath);
    }

    public function getDefaultThumbPath($thumbPath, $default = null)
    {
        if ($default)
            return $this->getStorageDisk()->path($this->getMediaPath($default));

        File::put($thumbPath, Manipulator::decodedBlankImage());

        return $thumbPath;
    }

    public function getMediaRelativePath($path)
    {
        $path = $this->validatePath($path);

        if (substr($path, 0, $this->storageFolderNameLength) == $this->storageFolder)
            return substr($path, $this->storageFolderNameLength);

        throw new SystemException(sprintf('Cannot convert Media Library path "%s" to a path relative to the Library root.', $path));
    }

    public function getConfig($key = null, $default = null)
    {
        if (is_null($key))
            return $this->config;

        return array_get($this->config, $key, $default);
    }

    public function getAllowedExtensions()
    {
        return Settings_model::defaultExtensions();
    }

    public function isAllowedExtension($filename)
    {
        if (!$nameExt = pathinfo($filename, PATHINFO_EXTENSION))
            return $filename;

        if (!in_array($nameExt, $this->getAllowedExtensions()))
            return false;

        return $nameExt;
    }

    public function resetCache()
    {
        Cache::forget(self::$cacheKey);
    }

    public function folderSize($path)
    {
        $path = $this->validatePath($path);

        $fullPath = $this->getMediaPath($path);

        $totalSize = 0;
        $files = $this->listFolderContents($fullPath, 'files');
        foreach ($files as $file) {
            $totalSize += $file->size;
        }

        return $totalSize;
    }

    protected function scanFolderContents($fullPath, $methodName, $recursive = false)
    {
        $result = [];
        switch ($methodName) {
            case 'files':
                $files = $this->getStorageDisk()->files($fullPath, $recursive);
                foreach ($files as $file) {
                    if ($libraryItem = $this->initMediaItem($file, MediaItem::TYPE_FILE))
                        $result[] = $libraryItem;
                }
                break;
            case 'directories':
                $result = $this->getStorageDisk()->directories($fullPath, $recursive);
                break;
        }

        return $result;
    }

    protected function isVisible($path)
    {
        $baseName = basename($path);

        if (in_array($baseName, $this->ignoreNames))
            return false;

        foreach ($this->ignorePatterns as $pattern) {
            if (preg_match('/'.$pattern.'/', $baseName))
                return false;
        }

        return true;
    }

    protected function sortFiles(&$files, $sortBy)
    {
        [$by, $direction] = $sortBy;
        usort($files, function ($a, $b) use ($by) {
            switch ($by) {
                case 'name':
                    return strcasecmp($a->path, $b->path);
                case 'date':
                    if ($a->lastModified > $b->lastModified)
                        return -1;

                    return $a->lastModified < $b->lastModified ? 1 : 0;
                    break;
                case 'size':
                    if ($a->size > $b->size)
                        return -1;

                    return $a->size < $b->size ? 1 : 0;
                    break;
            }
        });

        if ($direction == 'descending')
            $files = array_reverse($files);
    }

    protected function filterFiles(&$files, $filterBy)
    {
        if (!$filterBy || $filterBy === 'all') {
            return;
        }

        $result = [];
        foreach ($files as $item) {
            if ($item->getFileType() === $filterBy) {
                $result[] = $item;
            }
        }

        $files = $result;
    }

    protected function searchFiles(&$files, $filter)
    {
        if (!$filter)
            return;

        $result = [];
        foreach ($files as $item) {
            if (str_contains($item->name, $filter))
                $result[] = $item;
        }

        $files = $result;
    }

    protected function getThumbDirectory()
    {
        return $this->validatePath(Config::get('system.assets.media.thumbFolder', 'public')).'/';
    }

    protected function getStorageDisk()
    {
        if ($this->storageDisk)
            return $this->storageDisk;

        return $this->storageDisk = Storage::disk(
            Config::get('system.assets.media.disk', 'local')
        );
    }

    protected function initMediaItem($path, $itemType)
    {
        $relativePath = $this->getMediaRelativePath($path);

        if (!$this->isVisible($relativePath))
            return;

        $lastModified = $itemType == MediaItem::TYPE_FILE
            ? $this->getStorageDisk()->lastModified($path)
            : null;

        $size = $itemType == MediaItem::TYPE_FILE
            ? $this->getStorageDisk()->size($path)
            : null;

        $publicUrl = $this->storagePath.$relativePath;

        return new MediaItem($relativePath, $size, $lastModified, $itemType, $publicUrl);
    }

    protected function pathMatchesSearch($path, $words)
    {
        $path = Str::lower($path);

        foreach ($words as $word) {
            $word = trim($word);
            if (!strlen($word))
                continue;

            if (!Str::contains($path, $word))
                return false;
        }

        return true;
    }

    protected function getMediaThumbFile($filePath, $options)
    {
        $itemSignature = md5($filePath.serialize($options)).'_'.@File::lastModified($filePath);
        $thumbFilename = 'thumb_'.
            $itemSignature.'_'.
            array_get($options, 'width').'x'.
            array_get($options, 'height').'_'.
            array_get($options, 'fit', 'auto').'.'.
            File::extension($filePath);

        $partition = implode('/', array_slice(str_split($itemSignature, 3), 0, 3)).'/';

        return $this->getThumbDirectory().$partition.$thumbFilename;
    }

    protected function ensureDirectoryExists($path)
    {
        if (File::exists($directory = dirname($path)))
            return;

        File::makeDirectory($directory, 0777, true);
    }
}
