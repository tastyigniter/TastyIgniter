<?php

namespace Main\classes;

use Carbon\Carbon;
use Config;
use File;

class MediaItem
{
    const TYPE_FILE = 'file';

    const TYPE_FOLDER = 'folder';

    const FILE_TYPE_IMAGE = 'image';

    const FILE_TYPE_DOCUMENT = 'document';

    /**
     * @var string The item basename.
     */
    public $name;

    /**
     * @var string The item path relative to the Library root.
     */
    public $path;

    /**
     * @var integer The file size or folder files count.
     */
    public $size;

    /**
     * @var integer The last modification time (Unix timestamp).
     */
    public $lastModified;

    /**
     * @var string The item type.
     */
    public $type;

    /**
     * @var string Specifies the public URL of the item.
     */
    public $publicUrl;

    /**
     * @var array Contains a default list of image files and directories to ignore.
     * Override with config: cms.storage.media.imageExtensions
     */
    protected static $imageExtensions;

    /**
     * @param string $path
     * @param int $size
     * @param int $lastModified
     * @param string $type
     * @param string $publicUrl
     */
    public function __construct($path, $size, $lastModified, $type, $publicUrl)
    {
        $this->name = basename($path);
        $this->path = $path;
        $this->size = $size;
        $this->lastModified = $lastModified;
        $this->type = $type;
        $this->publicUrl = $publicUrl;
    }

    /**
     * @return bool
     */
    public function isFile()
    {
        return $this->type == self::TYPE_FILE;
    }

    public function getFileType()
    {
        if (!$this->isFile()) {
            return null;
        }

        if (!self::$imageExtensions) {
            self::$imageExtensions = Config::get('system.assets.media.imageExtensions', ['jpg', 'jpeg', 'png']);
        }

        $extension = pathinfo($this->path, PATHINFO_EXTENSION);
        if (!strlen($extension)) {
            return self::FILE_TYPE_DOCUMENT;
        }

        if (in_array($extension, self::$imageExtensions)) {
            return self::FILE_TYPE_IMAGE;
        }

        return self::FILE_TYPE_DOCUMENT;
    }

    /**
     * Returns the item size as string.
     * @return string Returns the size as string.
     */
    public function sizeToString()
    {
        return $this->type == self::TYPE_FILE
            ? File::sizeToString($this->size)
            : $this->size.' '.trans('main::lang.media_manager.text_items');
    }

    /**
     * Returns the item last modification date as string.
     * @return string Returns the item's last modification date as string.
     */
    public function lastModifiedAsString()
    {
        if (!($date = $this->lastModified)) {
            return null;
        }

        return Carbon::createFromTimestamp($date)->toFormattedDateString();
    }
}