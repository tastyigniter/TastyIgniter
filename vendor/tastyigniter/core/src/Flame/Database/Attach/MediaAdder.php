<?php

declare(strict_types=1);

namespace Igniter\Flame\Database\Attach;

use Igniter\Flame\Database\Attach\Events\MediaAdded as MediaAddedEvent;
use Igniter\Flame\Database\Model;
use Igniter\Flame\Filesystem\Filesystem;
use Igniter\Flame\Support\Facades\File;
use Igniter\Flame\Support\MediaUploadValidator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\File as SymfonyFile;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @property null|Model|HasMedia $performedOn
 */
class MediaAdder
{
    protected ?Media $media = null;

    protected ?Model $performedOn = null;

    protected ?string $tag = 'default';

    protected ?string $diskName = null;

    protected ?Collection $properties = null;

    protected array $customProperties = [];

    protected array $manipulations = [];

    protected ?string $pathToFile = null;

    public function __construct(protected Filesystem $files) {}

    public function on(Media $media): self
    {
        $this->media = $media;

        return $this;
    }

    public function performedOn(Model $model): self
    {
        $this->performedOn = $model;

        return $this;
    }

    public function useDisk(?string $disk): self
    {
        $this->diskName = $disk;

        return $this;
    }

    public function useMediaTag(?string $tag = null): self
    {
        $this->tag = $tag;

        return $this;
    }

    public function fromFile(UploadedFile|SymfonyFile $file): Media
    {
        $media = $this->media;

        $this->setFile($media, $file);

        $media->name = $media->getUniqueName();
        $media->disk = $this->diskName ?? $media->getDiskName();
        $media->tag = $this->tag ?? $this->performedOn->getDefaultTagName();
        $media->custom_properties = $this->customProperties;

        $this->attachMedia($media);

        return $media;
    }

    protected function setFile(Media $media, UploadedFile|SymfonyFile $file): ?string
    {
        if ($file instanceof UploadedFile) {
            $media->file_name = $file->getClientOriginalName();
            $media->mime_type = $file->getMimeType();
            $media->size = $file->getSize();
            $this->pathToFile = $file->getPath().DIRECTORY_SEPARATOR.$file->getFilename();
        } else {
            $media->file_name = $file->getFilename();
            $media->mime_type = $file->getMimeType();
            $media->size = $file->getSize();
            $this->pathToFile = $file->getRealPath();
        }

        return $this->pathToFile;
    }

    protected function attachMedia(Media $media)
    {
        if ($this->performedOn->exists) {
            return $this->processMediaItem($media, $this);
        }

        $this->performedOn->prepareUnattachedMedia($media, $this);

        $class = $this->performedOn::class;
        $class::created(function(Model $model) {
            $model->processUnattachedMedia(function(Media $media, MediaAdder $mediaAdder) {
                $this->processMediaItem($media, $mediaAdder);
            });
        });

        return null;
    }

    protected function processMediaItem(Media $media, self $mediaAdder)
    {
        $mediaAdder->performedOn->media()->save($media);

        $sourcePath = $mediaAdder->pathToFile;
        $destinationFileName = $media->getDiskPath();
        $validator = resolve(MediaUploadValidator::class);
        $contents = File::get($sourcePath) ?: '';
        $contents = $validator->validateAndSanitize($media->file_name, $contents);

        Storage::disk($media->getDiskName())->put($destinationFileName, $contents);

        MediaAddedEvent::dispatch($media);
    }
}
