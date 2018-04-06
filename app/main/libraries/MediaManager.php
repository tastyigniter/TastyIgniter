<?php namespace Main\Libraries;

use Cache;
use Config;
use Igniter\Flame\Traits\Singleton;
use Main\Classes\MediaItem;
use Request;
use Storage;
use Str;
use SystemException;

/**
 * MediaManager Class
 * @package System
 */
class MediaManager
{
    use Singleton;

    protected static $cacheKey = 'main.media.contents';

    protected $storageDisk;

    protected $storagePath;

    protected $storageFolder;

    protected $ignoreNames;

    protected $ignorePatterns;

    protected $storageFolderNameLength;

    protected $_sub_folder;

    protected $maxSize = 300;

    protected $thumbWidth = 320;

    protected $thumbHeight = 220;

    protected $uploads = 1;

    protected $newFolder = 1;

    protected $copy = 1;

    protected $move = 1;

    protected $rename = 1;

    protected $delete = 1;

    protected $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'tiff', 'svg', 'ico'];

    protected $_hidden_files = ['index.html'];

    protected $_hidden_folders = [];

    protected $_transliteration = FALSE;

    protected $rememberDays = 7;

    protected $config = [];

    public function initialize()
    {
        $config = setting('image_manager', []);

        foreach ($config as $key => $value) {
            $key = studly_case($key);
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }

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

    public function listFolderContents($fullPath, $methodName, $recursive = FALSE)
    {
        $cached = Cache::get(self::$cacheKey, FALSE);
        $cached = $cached ? @unserialize(@base64_decode($cached)) : [];

        if (!is_array($cached)) {
            $cached = [];
        }

        $cacheSuffix = $recursive ? 'recursive' : 'single';
        $cachedKey = "{$cacheSuffix}.{$methodName}.{$fullPath}";

        if (array_has($cached, $cachedKey)) {
            $folderContents = array_get($cached, $cachedKey);
        }
        else {
            $folderContents = $this->scanFolderContents($fullPath, $methodName, $recursive);

            $cached[$cacheSuffix][$methodName][$fullPath] = $folderContents;
            Cache::put(
                self::$cacheKey,
                base64_encode(serialize($cached)),
                Config::get('system.assets.media.ttl', 10)
            );
        }

        return $folderContents;
    }

    public function listAllFolders($path = null, array $exclude = [])
    {
        return $this->listFolders($path, $exclude, TRUE);
    }

    public function listFolders($path = null, array $exclude = [], $recursive = FALSE)
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

        if ($path == '/' AND !in_array('/', $result))
            array_unshift($result, '/');

        return $result;
    }

    public function fetchFiles($path, $sortBy = [], $search = null)
    {
        $path = $this->validatePath($path);

        $fullPath = $this->getMediaPath($path);

        $files = $this->listFolderContents($fullPath, 'files');

        $this->sortFiles($files, $sortBy);

        $this->searchFiles($files, $search);

        return $files;
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

    public function validatePath($path)
    {
        $path = str_replace('\\', '/', $path);
        $path = '/'.trim($path, '/');

        return $path;
    }

    public function getMediaUrl($path)
    {
        $path = $this->validatePath($path);

        return $this->storagePath.$path;
    }

    public function getMediaPath($path)
    {
        return $this->storageFolder.$path;
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
        return $this->allowedExtensions;
    }

    public function isAllowedExtension($filename)
    {
        if (!$nameExt = pathinfo($filename, PATHINFO_EXTENSION))
            return $filename;

        if (!in_array($nameExt, $this->getAllowedExtensions()))
            return FALSE;

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

    protected function scanFolderContents($fullPath, $methodName, $recursive = FALSE)
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
            return FALSE;

        foreach ($this->ignorePatterns as $pattern) {
            if (preg_match('/'.$pattern.'/', $baseName))
                return FALSE;
        }

        return TRUE;
    }

    protected function sortFiles(&$files, $sortBy)
    {
        list($by, $direction) = $sortBy;
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
                return FALSE;
        }

        return TRUE;
    }
}