<?php

declare(strict_types=1);

namespace Igniter\Flame\Database\Attach;

use Closure;
use Igniter\Flame\Database\Attach\Events\MediaTagCleared as MediaTagClearedEvent;
use Igniter\Flame\Database\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Collection as BaseCollection;
use RuntimeException;

trait HasMedia
{
    protected array $unAttachedMediaItems = [];

    public static function bootHasMedia(): void
    {
        static::deleting(function(Model $model) {
            $model->handleHasMediaDeletion();
        });
    }

    /**
     * Set the polymorphic relation.
     */
    public function media()
    {
        return $this->morphMany(Media::class, 'attachment')->sorted();
    }

    /**
     * Query scope to detect the presence of one or more attached media for a given tag.
     * @param string|string[] $tags
     */
    public function scopeWhereHasMedia(Builder $query, string|array $tags): void
    {
        if (!is_array($tags)) {
            $tags = [$tags];
        }

        $query->whereHas('media', function(Builder $q) use ($tags) {
            $q->whereIn('tag', $tags);
        });
    }

    public function newMediaInstance(): Media
    {
        $newMedia = new Media;
        $newMedia->setRelation('attachment', $this);

        return $newMedia;
    }

    public function getAttribute($key): mixed
    {
        if (!array_key_exists($key, $mediable = $this->mediable()) || $this->hasGetMutator($key)) {
            return parent::getAttribute($key);
        }

        $mediableConfig = array_get($mediable, $key, []);
        if (array_get($mediableConfig, 'multiple', false)) {
            return $this->getMedia($key);
        }

        return $this->getFirstMedia($key);
    }

    public function setAttribute($key, $value)
    {
        return (!array_key_exists($key, $this->mediable()) || $this->hasSetMutator($key))
            ? parent::setAttribute($key, $value)
            : null;
    }

    public function getDefaultTagName(): int|string|null
    {
        return ($mediable = $this->mediable()) ? key($mediable) : 'default';
    }

    //
    // Media handling
    //

    public function getThumbOrBlank(array $options = [], ?string $tag = null)
    {
        return $this->getThumb($options, $tag) ?? Manipulator::encodedBlankImageUrl();
    }

    /**
     * Get the thumbnail of the first media item of a default tag.
     */
    public function getThumb(array $options = [], ?string $tag = null): ?string
    {
        return $this->getFirstMedia($tag)?->getThumb($options);
    }

    /**
     * Get a collection of media attachments by its tag.
     */
    public function getMedia(?string $tag = null, callable|array $filters = []): BaseCollection
    {
        $collection = $this->loadMedia($tag ?? $this->getDefaultTagName());

        if (is_array($filters)) {
            $filters = $this->buildMediaPropertiesFilter($filters);
        }

        return $collection->filter($filters);
    }

    /**
     * Get the first media item of a media tag.
     */
    public function getFirstMedia(?string $tag = null, array $filters = []): ?Media
    {
        return $this->getMedia($tag, $filters)->first();
    }

    public function findMedia(int|string $mediaId): Media
    {
        if (!$media = $this->media->find($mediaId)) {
            throw new RuntimeException(sprintf(
                "Media with id '%s' cannot be deleted because it does not exist or does not belong to model %s with id %s",
                $mediaId, $this::class, $this->getKey(),
            ));
        }

        return $media;
    }

    /**
     * Lazy eager load attached media relationships.
     */
    public function loadMedia(?string $tag = null): BaseCollection
    {
        $collection = $this->exists ? $this->media : collect($this->unAttachedMediaItems)->pluck('media');

        return collect($collection)
            ->filter(fn(Media $mediaItem): bool => $tag === '*' || $mediaItem->tag === $tag)
            ->sortBy('priority')->values();
    }

    /**
     * Determine if the specified tag contains media.
     */
    public function hasMedia(?string $tag = null): bool
    {
        return count($this->getMedia($tag)) > 0;
    }

    /**
     * Detach a media item from the model.
     */
    public function deleteMedia(int|string|Media $mediaId): void
    {
        if ($mediaId instanceof Media) {
            $mediaId = $mediaId->getKey();
        }

        $media = $this->findMedia($mediaId);

        $media->delete();
    }

    /**
     * Remove all media with the given tag.
     */
    public function clearMediaTag(?string $tag = null): void
    {
        $this->getMedia($tag)->each->delete();

        MediaTagClearedEvent::dispatch($this, $tag);

        if ($this->mediaWasLoaded()) {
            unset($this->media);
        }
    }

    public function prepareUnattachedMedia(Media $media, MediaAdder $mediaAdder): void
    {
        $this->unAttachedMediaItems[] = ['media' => $media, 'mediaAdder' => $mediaAdder];
    }

    public function processUnattachedMedia(callable $callable): void
    {
        foreach ($this->unAttachedMediaItems as $item) {
            $callable($item['media'], $item['mediaAdder']);
        }

        $this->unAttachedMediaItems = [];
    }

    public function mediable(): array
    {
        $result = [];
        $mediable = $this->mediable ?? [];
        foreach ($mediable as $attribute => $config) {
            $index = is_numeric($attribute) ? $config : $attribute;
            $result[$index] = is_numeric($attribute) ? [] : $config;
        }

        return $result;
    }

    protected function mediaWasLoaded(): bool
    {
        return $this->relationLoaded('media');
    }

    /**
     * Delete media relationships when the model is deleted. Ignore on soft deletes.
     * @return void
     */
    protected function handleHasMediaDeletion()
    {
        // only cascade soft deletes when configured
        if ($this->forceDeleting || !static::hasGlobalScope(SoftDeletingScope::class)) {
            $this->media()->get()->each->delete();
        }
    }

    /**
     * Convert the given array to a filter closure.
     */
    protected function buildMediaPropertiesFilter(array $filters): Closure
    {
        return function(Media $media) use ($filters): bool {
            foreach ($filters as $property => $value) {
                if (!$media->hasCustomProperty($property)) {
                    return false;
                }

                if ($media->getCustomProperty($property) !== $value) {
                    return false;
                }
            }

            return true;
        };
    }
}
