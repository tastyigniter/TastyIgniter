<?php

declare(strict_types=1);

namespace Igniter\Main\Classes;

use Carbon\Carbon;
use Igniter\Flame\Support\Facades\File;
use Igniter\System\Models\Settings;

class MediaItem
{
    public const string TYPE_FILE = 'file';

    public const string TYPE_FOLDER = 'folder';

    public const string FILE_TYPE_IMAGE = 'image';

    public const string FILE_TYPE_DOCUMENT = 'document';

    public const string FILE_TYPE_VIDEO = 'video';

    public const string FILE_TYPE_AUDIO = 'audio';

    /** The item basename. */
    public string $name;

    /** The item path relative to the Library root. */
    public string $path;

    /** The item file type. ex. image, audio, video */
    public ?string $fileType = null;

    /**
     * Contains a default list of image files.
     * Override with config: system.assets.media.imageExtensions
     */
    protected static ?array $imageExtensions = null;

    /**
     * Contains a default list of video files.
     * Override with config: system.assets.media.videoExtensions
     */
    protected static ?array $videoExtensions = null;

    /**
     * Contains a default list of audio files.
     * Override with config: system.assets.media.audioExtensions
     */
    protected static ?array $audioExtensions = null;

    public function __construct(
        string $path,
        public ?int $size,
        /** The last modification time (Unix timestamp). */
        public ?int $lastModified,
        /** The item type. ex. file or folder */
        public string $type,
        /** Specifies the public URL of the item. */
        public ?string $publicUrl,
    ) {
        $this->name = basename($path);
        $this->path = $path;
        $this->fileType = $this->getFileType();
    }

    public function isFile(): bool
    {
        return $this->type === self::TYPE_FILE;
    }

    public function getFileType(): ?string
    {
        if (!self::$imageExtensions) {
            self::$imageExtensions = array_map('strtolower', Settings::imageExtensions());
        }

        if (!self::$audioExtensions) {
            self::$audioExtensions = array_map('strtolower', Settings::audioExtensions());
        }

        if (!self::$videoExtensions) {
            self::$videoExtensions = array_map('strtolower', Settings::videoExtensions());
        }

        $extension = pathinfo($this->path, PATHINFO_EXTENSION);
        if (empty($extension)) {
            return null;
        }

        if (in_array($extension, self::$imageExtensions)) {
            return self::FILE_TYPE_IMAGE;
        }

        if (in_array($extension, self::$audioExtensions)) {
            return self::FILE_TYPE_AUDIO;
        }

        if (in_array($extension, self::$videoExtensions)) {
            return self::FILE_TYPE_VIDEO;
        }

        return self::FILE_TYPE_DOCUMENT;
    }

    /**
     * Returns the item size as string.
     */
    public function sizeToString(): string
    {
        return $this->type === self::TYPE_FILE
            ? File::sizeToString($this->size)
            : $this->size.' '.trans('igniter::main.media_manager.text_items');
    }

    /**
     * Returns the item last modification date as string.
     */
    public function lastModifiedAsString(): ?string
    {
        if (!($date = $this->lastModified)) {
            return null;
        }

        return Carbon::createFromTimestamp($date)->toFormattedDateString();
    }
}
