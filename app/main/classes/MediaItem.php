<?php

namespace Main\classes;

use Carbon\Carbon;
use Igniter\Flame\Support\Facades\File;
use System\Models\Settings_model;

class MediaItem
{
    const TYPE_FILE = 'file';
    const TYPE_FOLDER = 'folder';
    const FILE_TYPE_IMAGE = 'image';
    const FILE_TYPE_DOCUMENT = 'document';
    const FILE_TYPE_VIDEO = 'video';
    const FILE_TYPE_AUDIO = 'audio';

    /**
     * @var string The item basename.
     */
    public $name;

    /**
     * @var string The item path relative to the Library root.
     */
    public $path;

    /**
     * @var int The file size or folder files count.
     */
    public $size;

    /**
     * @var int The last modification time (Unix timestamp).
     */
    public $lastModified;

    /**
     * @var string The item type. ex. file or folder
     */
    public $type;

    /**
     * @var string The item file type. ex. image, audio, video
     */
    public $fileType;

    /**
     * @var string Specifies the public URL of the item.
     */
    public $publicUrl;

    /**
     * @var array Contains a default list of image files.
     * Override with config: system.assets.media.imageExtensions
     */
    protected static $imageExtensions;

    /**
     * @var array Contains a default list of video files.
     * Override with config: system.assets.media.videoExtensions
     */
    protected static $videoExtensions;

    /**
     * @var array Contains a default list of audio files.
     * Override with config: system.assets.media.audioExtensions
     */
    protected static $audioExtensions;

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
        $this->fileType = $this->getFileType();
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

        if (!self::$imageExtensions)
            self::$imageExtensions = array_map('strtolower', Settings_model::imageExtensions());

        if (!self::$audioExtensions)
            self::$audioExtensions = array_map('strtolower', Settings_model::audioExtensions());

        if (!self::$videoExtensions)
            self::$videoExtensions = array_map('strtolower', Settings_model::videoExtensions());

        $extension = pathinfo($this->path, PATHINFO_EXTENSION);
        if (!strlen($extension))
            return self::FILE_TYPE_DOCUMENT;

        if (in_array($extension, self::$imageExtensions))
            return self::FILE_TYPE_IMAGE;

        if (in_array($extension, self::$audioExtensions))
            return self::FILE_TYPE_AUDIO;

        if (in_array($extension, self::$videoExtensions))
            return self::FILE_TYPE_VIDEO;

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
