<?php

declare(strict_types=1);

namespace Igniter\Flame\Database\Traits;

use Exception;
use Igniter\Flame\Database\Model;
use Igniter\Flame\Database\PermalinkMaker;
use Illuminate\Database\Eloquent\Builder;
use LogicException;

/**
 * HasPermalink model trait
 * Usage:
 **
 * In the model class definition:
 *   use \Igniter\Flame\Database\Traits\HasPermalink;
 * You can change the slug field used by declaring:
 *   protected $permalink = ['permalink_slug' => ['source' => 'name']];
 */
trait HasPermalink
{
    /**
     * Boot the sortable trait for this model.
     * @throws Exception
     */
    public static function bootHasPermalink(): void
    {
        if (!property_exists(static::class, 'permalinkable')) {
            throw new LogicException(sprintf(
                'You must define a $permalinkable property in %s to use the HasPermalink trait.', static::class,
            ));
        }

        static::saving(function(self|Model $model) {
            $model->generatePermalinkOnSave();
        });
    }

    /**
     * Handle adding permalink slug on model update.
     */
    protected function generatePermalinkOnSave()
    {
        $this->getPermalinkMaker()->slug($this);
    }

    /**
     * Primary slug column of this model.
     * @return string
     */
    public function getSlugKeyName()
    {
        if (property_exists($this, 'slugKeyName')) {
            return $this->slugKeyName;
        }

        $config = $this->permalinkable();
        $name = reset($config);
        $key = key($config);

        return $key === 0 ? $name : $key;
    }

    /**
     * Primary slug value of this model.
     * @return string
     */
    public function getSlugKey()
    {
        return $this->getAttribute($this->getSlugKeyName());
    }

    /**
     * Query scope for finding a model by its primary slug.
     *
     * @param string $slug
     *
     * @return Builder
     */
    public function scopeWhereSlug($query, $slug)
    {
        return $query->where($this->getSlugKeyName(), $slug);
    }

    /**
     * Query scope for finding "similar" slugs, used to determine uniqueness.
     *
     * @param Builder $query
     * @param string $attribute
     *
     * @return Builder
     */
    public function scopeFindSimilarSlugs($query, $attribute, array $config, string $slug)
    {
        $separator = $config['separator'];

        return $query->where($attribute, $slug)
            ->orWhere($attribute, 'LIKE', $slug.$separator.'%');
    }

    public function findSlug($slug, $columns = ['*'])
    {
        return $this->whereSlug($slug)->first($columns);
    }

    public function permalinkable(): array
    {
        $result = [];
        $permalinkable = $this->permalinkable ?? [];
        foreach ($permalinkable as $attribute => $config) {
            $index = is_numeric($attribute) ? $config : $attribute;
            $result[$index] = is_numeric($attribute) ? [] : $config;
        }

        return $result;
    }

    /**
     * @return PermalinkMaker
     */
    protected function getPermalinkMaker()
    {
        return resolve(PermalinkMaker::class);
    }
}
