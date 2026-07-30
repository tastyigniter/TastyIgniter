<?php

declare(strict_types=1);

namespace Igniter\Flame\Database\Attach;

use FilesystemIterator;
use Igniter\Flame\Database\Builder;
use Igniter\Flame\Database\Model;
use Igniter\Flame\Database\Traits\Sortable;
use Igniter\Flame\Support\Facades\File;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use LogicException;
use RuntimeException;
use Symfony\Component\HttpFoundation\File\File as SymfonyFile;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @property int $id
 * @property string $disk
 * @property string $name
 * @property string $file_name
 * @property string $mime_type
 * @property int $size
 * @property string|null $tag
 * @property string|null $attachment_type
 * @property int|null $attachment_id
 * @property int $is_public
 * @property array<array-key, mixed>|null $custom_properties
 * @property int|null $priority
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Model|null $attachment
 * @property-read mixed $extension
 * @property-read string $height
 * @property-read mixed $human_readable_size
 * @property-read string $path
 * @property-read string $type
 * @property-read string $width
 * @method static Builder<static>|Media applyFilters(array $options = [])
 * @method static Builder<static>|Media applySorts(array $sorts = [])
 * @method static Builder<static>|Media listFrontEnd(array $options = [])
 * @method static Builder<static>|Media newModelQuery()
 * @method static Builder<static>|Media newQuery()
 * @method static Builder<static>|Media query()
 * @method static Builder<static>|Media sorted()
 * @mixin \Illuminate\Database\Eloquent\Model
 */
class Media extends Model
{
    use Sortable;

    public const string SORT_ORDER = 'priority';

    protected $table = 'media_attachments';

    public $timestamps = true;

    protected $guarded = ['disk'];

    /**
     * @var array Known image extensions.
     */
    public static $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

    /**
     * Hidden fields from array/json access
     */
    protected $hidden = ['attachment_type', 'attachment_id', 'is_public'];

    /**
     * Add fields to array/json access
     */
    protected $appends = ['path', 'extension'];

    /**
     * @var array<string, string> The attributes that should be cast to native types.
     */
    protected $casts = [
        'manipulations' => 'array',
        'custom_properties' => 'array',
    ];

    /**
     * @var array Mime types
     */
    protected $autoMimeTypes = [
        'gif' => 'image/gif',
        'png' => 'image/png',
        'jpg' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'webp' => 'image/webp',
        'pdf' => 'application/pdf',
        'docx' => 'application/msword',
        'xlsx' => 'application/excel',
    ];

    public $fileToAdd;

    /**
     * Set the polymorphic relation.
     */
    public function attachment()
    {
        return $this->morphTo('attachment');
    }

    /**
     * Creates a file object from a file an uploaded file.
     */
    public function addFromRequest(UploadedFile $uploadedFile, ?string $tag = null, ?string $disk = null): self
    {
        $this->getMediaAdder()
            ->useDisk($disk)
            ->performedOn($this->attachment)
            ->useMediaTag($tag)
            ->fromFile($uploadedFile);

        return $this;
    }

    /**
     * Creates a file object from a file on the disk.
     */
    public function addFromFile(string $filePath, ?string $tag = null, ?string $disk = null): self
    {
        $this->getMediaAdder()
            ->useDisk($disk)
            ->performedOn($this->attachment)
            ->useMediaTag($tag)
            ->fromFile(new SymfonyFile($filePath));

        return $this;
    }

    /**
     * Creates a file object from raw data.
     */
    public function addFromRaw(mixed $rawData, string $filename, ?string $tag = null): self
    {
        $tempPath = $this->getTempPath().$filename;
        if (!File::isDirectory(dirname($tempPath))) {
            File::makeDirectory(dirname($tempPath), 775, true);
        }

        File::put($tempPath, $rawData);

        $this->addFromFile($tempPath, $tag);
        File::delete($tempPath);

        return $this;
    }

    /**
     * Creates a file object from url
     * @param $url string URL
     * @param $filename string Filename
     * @throws RuntimeException
     */
    public function addFromUrl(string $url, $filename = null, ?string $tag = null): self
    {
        $response = Http::get($url);
        if (!$response->successful()) {
            throw new RuntimeException(sprintf('Error opening file "%s"', $url));
        }

        return $this->addFromRaw(
            $response->resource(),
            !empty($filename) ? $filename : File::basename($url),
            $tag,
        );
    }

    //
    // Attribute mutators
    //

    /**
     * Helper attribute for getPath.
     */
    public function getPathAttribute(): string
    {
        return $this->getPath();
    }

    /**
     * Determine the type of file.
     *
     * @return string
     */
    public function getTypeAttribute()
    {
        return $this->getMimeType();
    }

    public function getExtensionAttribute()
    {
        return $this->getExtension();
    }

    /**
     * Helper attribute for get image width.
     * @return string
     */
    public function getWidthAttribute()
    {
        return $this->isImage() ? $this->getImageDimensions()[0] : null;
    }

    /**
     * Helper attribute for get image height.
     * @return string
     */
    public function getHeightAttribute()
    {
        return $this->isImage() ? $this->getImageDimensions()[1] : null;
    }

    public function getHumanReadableSizeAttribute()
    {
        return $this->sizeToString();
    }

    //
    // Getters
    //

    /**
     * Returns the file name without path
     */
    public function getFilename()
    {
        return $this->file_name;
    }

    /**
     * Returns the file extension.
     */
    public function getExtension()
    {
        return File::extension($this->file_name);
    }

    /**
     * Returns the last modification date as a UNIX timestamp.
     * @return int
     */
    public function getLastModified($fileName = null)
    {
        if (!$fileName) {
            $fileName = $this->name;
        }

        return $this->getStorageDisk()->lastModified($this->getStoragePath().$fileName);
    }

    /**
     * Returns the public address to access the file.
     */
    public function getPath(): string
    {
        return $this->getPublicPath().$this->getPartitionDirectory().$this->name;
    }

    /**
     * Returns a local path to this file. If the file is stored remotely,
     * it will be downloaded to a temporary directory.
     */
    public function getFullDiskPath(): string
    {
        return $this->getStorageDisk()->path($this->getDiskPath());
    }

    /**
     * Returns the path to the file, relative to the storage disk.
     */
    public function getDiskPath(): string
    {
        return $this->getStoragePath().$this->name;
    }

    /**
     * Determines if the file is flagged "public" or not.
     */
    public function isPublic()
    {
        if (is_null($this->is_public)) {
            return true;
        }

        return $this->is_public;
    }

    /**
     * Returns the file size as string.
     * @return string Returns the size as string.
     */
    public function sizeToString()
    {
        return File::sizeToString($this->size);
    }

    public function getMimeType()
    {
        if (!is_null($this->mime_type)) {
            return $this->mime_type;
        }

        if ($type = $this->getTypeFromExtension()) {
            return $this->mime_type = $type;
        }

        return null;
    }

    public function getTypeFromExtension()
    {
        $ext = $this->getExtension();

        return $this->autoMimeTypes[$ext] ?? null;
    }

    /**
     * Generates a unique name from the supplied file name.
     */
    public function getUniqueName()
    {
        if (!is_null($this->name)) {
            return $this->name;
        }

        $ext = strtolower((string)$this->getExtension());

        $name = str_replace('.', '', uniqid('', true));

        return $this->name = $name.(!empty($ext) ? '.'.$ext : '');
    }

    public function getDiskName(): string
    {
        if (!is_null($this->disk)) {
            return $this->disk;
        }

        $diskName = config('igniter-system.assets.attachment.disk');
        if (is_null(config('filesystems.disks.'.$diskName))) {
            throw new LogicException(sprintf('Disk %s is not configured.', $diskName));
        }

        return $this->disk = $diskName;
    }

    public function getDiskDriverName(): string
    {
        return strtolower((string)config(sprintf('filesystems.disks.%s.driver', $this->getDiskName())));
    }

    //
    //
    //

    /**
     * Delete all thumbnails for this file.
     */
    public function deleteThumbs(): void
    {
        $pattern = 'thumb_'.$this->id.'_';

        $directory = $this->getStoragePath();
        $allFiles = $this->getStorageDisk()->files($directory);
        $paths = array_filter($allFiles, fn($file): bool => starts_with(basename((string)$file), $pattern));

        $this->getStorageDisk()->delete($paths);
    }

    /**
     * Delete file contents from storage device.
     */
    public function deleteFile(?string $fileName = null): void
    {
        if (!$fileName) {
            $fileName = $this->name;
        }

        $directory = $this->getStoragePath();
        $filePath = $directory.$fileName;

        if ($this->getStorageDisk()->exists($filePath)) {
            $this->getStorageDisk()->delete($filePath);
        }

        $this->deleteEmptyDirectory($directory);
    }

    /**
     * Checks if directory is empty then deletes it,
     * three levels up to match the partition directory.
     * @param string $directory
     */
    protected function deleteEmptyDirectory($directory = null): ?bool
    {
        if (!$this->isDirectoryEmpty($directory)) {
            return false;
        }

        $this->getStorageDisk()->deleteDirectory($directory);

        $directory = File::dirname($directory);
        if (!$this->isDirectoryEmpty($directory)) {
            return false;
        }

        $this->getStorageDisk()->deleteDirectory($directory);

        $directory = File::dirname($directory);
        if (!$this->isDirectoryEmpty($directory)) {
            return false;
        }

        return $this->getStorageDisk()->deleteDirectory($directory);
    }

    /**
     * Returns true if a directory contains no files.
     */
    protected function isDirectoryEmpty($directory): bool
    {
        $path = $this->getStorageDisk()->path($directory);

        return !(new FilesystemIterator($path))->valid();
    }

    /**
     * Check file exists on storage device.
     * @param string $fileName
     * @return bool
     */
    protected function hasFile($fileName = null)
    {
        $filePath = $this->getStoragePath().$fileName;

        return $this->getStorageDisk()->exists($filePath);
    }

    //
    // Image handling
    //

    /**
     * Checks if the file extension is an image and returns true or false.
     */
    public function isImage(): bool
    {
        return in_array(strtolower((string)$this->getExtension()), static::$imageExtensions);
    }

    /**
     * Generates and returns a thumbnail url.
     */
    public function getThumb(string|array $options = []): string
    {
        if (!$this->isImage()) {
            return $this->getPath();
        }

        $options = $this->getDefaultThumbOptions($options);

        $thumbFile = $this->getThumbFilename($options);
        if (!$this->hasFile($thumbFile)) {
            $this->makeThumb($thumbFile, $options);
        }

        return $this->getPublicPath().$this->getPartitionDirectory().$thumbFile;
    }

    public function outputThumb($options = []) {}

    public function getDefaultThumbPath($thumbPath, $default = null)
    {
        if (!$default) {
            $this->getStorageDisk()->put($thumbPath, Manipulator::decodedBlankImage());
            $default = $thumbPath;
        }

        return $this->getStorageDisk()->path($default);
    }

    /**
     * Get image dimensions
     */
    protected function getImageDimensions(): array|false
    {
        return getimagesize($this->getFullDiskPath());
    }

    /**
     * Generates a thumbnail filename.
     */
    protected function getThumbFilename(array $options): string
    {
        return 'thumb_'
            .$this->id.'_'
            .$options['width'].'_'.$options['height'].'_'.$options['fit'].'_'
            .substr(md5(serialize(array_except($options, ['width', 'height', 'fit']))), 0, 8).
            '.'.$options['extension'];
    }

    /**
     * Returns the default thumbnail options.
     */
    protected function getDefaultThumbOptions(string|array $override = []): array
    {
        $defaultOptions = [
            'fit' => 'contain',
            'width' => 0,
            'height' => 0,
            'quality' => 90,
            'sharpen' => 0,
            'extension' => 'auto',
        ];

        if (!is_array($override)) {
            $override = ['fit' => $override];
        }

        $options = array_merge($defaultOptions, $override);

        if (strtolower((string)$options['extension']) === 'auto') {
            $options['extension'] = strtolower((string)$this->getExtension());
        }

        return $options;
    }

    /**
     * Generate the thumbnail
     */
    protected function makeThumb(string $thumbFile, array $options): void
    {
        $thumbFile = $this->getStoragePath().$thumbFile;
        $filePath = $this->hasFile($this->name) ? $this->getDiskPath() : $this->getDefaultThumbPath(
            $thumbFile, array_get($options, 'default'),
        );

        $manipulator = Manipulator::make($filePath)->useSource(
            $this->getStorageDisk(),
        );

        if ($manipulator->isSupported()) {
            $manipulator->manipulate(array_except($options, ['extension', 'default']));
        }

        $manipulator->save($thumbFile);
    }

    //
    // Custom Properties
    //

    public function getCustomProperties()
    {
        return $this->custom_properties;
    }

    /*
     * Determine if the media item has a custom property with the given name.
     */
    public function hasCustomProperty($propertyName)
    {
        return array_has($this->custom_properties, $propertyName);
    }

    /**
     * Get if the value of custom property with the given name.
     */
    public function getCustomProperty(string $propertyName, mixed $default = null): mixed
    {
        return array_get($this->custom_properties, $propertyName, $default);
    }

    public function setCustomProperty(string $name, mixed $value): Media
    {
        $customProperties = $this->custom_properties;

        array_set($customProperties, $name, $value);

        $this->custom_properties = $customProperties;

        return $this;
    }

    /**
     * @param string $name
     */
    public function forgetCustomProperty($name): static
    {
        $customProperties = $this->custom_properties;

        array_forget($customProperties, $name);

        $this->custom_properties = $customProperties;

        return $this;
    }

    //
    // Configuration
    //

    /**
     * Define the internal storage path, override this method to define.
     */
    public function getStoragePath(): string
    {
        return $this->getStorageDirectory().$this->getPartitionDirectory();
    }

    /**
     * Define the public address for the storage path.
     */
    public function getPublicPath(): string
    {
        return $this->getStorageDisk()->url($this->getStorageDirectory());
    }

    /**
     * Define the internal working path, override this method to define.
     */
    public function getTempPath(): string
    {
        $path = temp_path().'/attachments/';

        if (!File::isDirectory($path)) {
            File::makeDirectory($path, 0777, true, true);
        }

        return $path;
    }

    /**
     * Define the internal storage folder, override this method to define.
     */
    public function getStorageDirectory(): string
    {
        $mediaFolder = config('igniter-system.assets.attachment.folder', 'media/attachments/');

        return $this->isPublic() ? $mediaFolder.'public/' : $mediaFolder.'protected/';
    }

    /**
     * Generates a partition for the file.
     */
    public function getPartitionDirectory(): string
    {
        return implode('/', array_slice(str_split($this->name, 3), 0, 3)).'/';
    }

    protected function getStorageDisk(): FilesystemAdapter
    {
        return Storage::disk($this->getDiskName());
    }

    protected function getMediaAdder(): MediaAdder
    {
        return app(MediaAdder::class)->on($this);
    }
}
