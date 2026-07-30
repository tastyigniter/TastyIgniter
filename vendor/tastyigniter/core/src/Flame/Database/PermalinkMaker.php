<?php

declare(strict_types=1);

namespace Igniter\Flame\Database;

use Closure;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use InvalidArgumentException;
use UnexpectedValueException;

class PermalinkMaker
{
    /** @var Model */
    protected $model;

    public function slug(Model $model, $force = false)
    {
        $this->setModel($model);

        $attributes = [];
        foreach ($this->model->permalinkable() as $attribute => $config) {
            $config = $this->getConfiguration($config);

            $slug = $this->buildSlug($attribute, $config, $force);
            $this->model->setAttribute($attribute, $slug);
            $attributes[] = $attribute;
        }

        return $this->model->isDirty($attributes);
    }

    /**
     * Get the permalink configuration for the current model,
     * including default values that where not specified.
     *
     * @param array $overrides
     */
    public function getConfiguration($overrides = []): array
    {
        static $defaultConfig = null;

        if ($defaultConfig === null) {
            $defaultConfig = [
                'source' => null,
                // The controller name used when building the permalink
                // each permalink are unique to controllers
                'controller' => 'pages',
                'maximumLength' => 250,
                'separator' => '-',
                'generateUnique' => true,
                'generateOnCreate' => true,
                'generateOnUpdate' => false,
                'reserved' => [],
                'uniqueSuffix' => null,
                'includeTrashed' => false,
            ];
        }

        return array_merge($defaultConfig, $overrides);
    }

    /**
     * Build the slug for the given attribute of the current model.
     *
     * @param string $attribute
     * @param bool $force
     *
     * @return null|string
     */
    public function buildSlug($attribute, array $config, $force = null)
    {
        $slug = $this->model->getAttribute($attribute);

        if ($force || $this->needsSlugging($attribute, $config)) {
            $source = $this->getSlugSource($config['source']);

            if ($source || is_numeric($source)) {
                $slug = $this->generateSlug($source, $config, $attribute);
                $slug = $this->validateSlug($slug, $config, $attribute);
                $slug = $this->makeSlugUnique($slug, $config, $attribute);
            }
        }

        return $slug;
    }

    /**
     * Determines whether the model needs slugging.
     *
     * @param string $attribute
     *
     * @return bool
     */
    protected function needsSlugging($attribute, array $config)
    {
        if ($config['generateOnUpdate'] === true
            || empty($this->model->getAttributeValue($attribute))
        ) {
            return true;
        }

        if ($this->model->isDirty($attribute)) {
            return false;
        }

        return $config['generateOnCreate'] === true && !$this->model->exists;
    }

    /**
     * Get the string that should be used as base for the slug.
     *
     * @return mixed|string
     */
    protected function getSlugSource($from)
    {
        if (is_null($from)) {
            return $this->model->__toString();
        }

        if (is_callable($from)) {
            return call_user_func($from, $this);
        }

        $sourceStrings = array_map(function($fieldName) {
            $value = data_get($this->model, $fieldName);

            return (is_bool($value)) ? (int)$value : $value;
        }, (array)$from);

        return implode(' ', $sourceStrings);
    }

    /**
     * Generate a slug from the given source string.
     *
     * @param string $source
     * @param string $attribute
     *
     * @return string
     */
    protected function generateSlug($source, array $config, $attribute)
    {
        $separator = $config['separator'];
        $maxLength = $config['maximumLength'];

        $slug = str_slug($source, $separator);

        if (is_string($slug) && $maxLength) {
            $slug = mb_substr($slug, 0, $maxLength);
        }

        return $slug;
    }

    /**
     * Checks if the slug should be unique, and makes it so if needed.
     *
     * @param string $attribute
     *
     * @return string
     * @throws UnexpectedValueException
     */
    protected function makeSlugUnique(string $slug, array $config, $attribute)
    {
        if (!$config['generateUnique']) {
            return $slug;
        }

        $separator = $config['separator'];

        // find all models where the slug is like the current one
        $list = $this->getExistingSlugs($slug, $attribute, $config);

        // if ...
        // 	a) the list is empty, or
        // 	b) our slug isn't in the list
        // ... we are okay
        if ($list->count() === 0 || $list->contains($slug) === false) {
            return $slug;
        }

        // if our slug is in the list, but
        // 	a) it's for our model, or
        //  b) it looks like a suffixed version of our slug
        // ... we are also okay (use the current slug)
        if ($list->has($this->model->getKey())) {
            $currentSlug = $list->get($this->model->getKey());
            if ($currentSlug === $slug || str_starts_with((string)$currentSlug, $slug)) {
                return $currentSlug;
            }
        }

        return $slug.$separator.$list->count();
    }

    /**
     * Get all existing slugs that are similar to the given slug.
     *
     * @param string $slug
     * @param string $attribute
     *
     * @return Collection
     */
    protected function getExistingSlugs($slug, $attribute, array $config)
    {
        $includeTrashed = $config['includeTrashed'];

        $query = $this->model->newQuery()->findSimilarSlugs($attribute, $config, $slug);

        // Use the model scope to find similar slugs
        if (method_exists($this->model, 'scopeWithUniqueSlugConstraints')) {
            $this->model->withUniqueSlugConstraints($query, $attribute, $config, $slug);
        }

        // Include trashed models if required
        if ($includeTrashed && in_array(SoftDeletes::class, class_uses_recursive($this->model))) {
            $query->withTrashed();
        }

        // Get the list of all matching slugs
        return $query->pluck($attribute, $this->model->getKeyName());
    }

    /**
     * Checks that the given slug is not a reserved word.
     */
    protected function validateSlug(string $slug, array $config, string $attribute): string
    {
        $separator = $config['separator'];
        $reserved = $config['reserved'];

        // check for reserved names
        if ($reserved instanceof Closure) {
            $reserved = $reserved($this->model);
        }

        if (is_array($reserved)) {
            if (in_array($slug, $reserved)) {
                $method = $config['uniqueSuffix'];
                if ($method === null) {
                    $suffix = $this->generateSuffix($slug, $separator, collect($reserved));
                } elseif (is_callable($method)) {
                    $suffix = $method($slug, $separator, collect($reserved));
                } else {
                    throw new InvalidArgumentException('Sluggable "uniqueSuffix" for '.$this->model::class.':'.$attribute.' is not null, or a closure.');
                }

                return $slug.$separator.$suffix;
            }

            return $slug;
        }

        throw new InvalidArgumentException('Sluggable "reserved" for '.$this->model::class.':'.$attribute.' is not null, an array, or a closure that returns null/array.');
    }

    /**
     * Generate a unique suffix for the given slug (and list of existing, "similar" slugs.
     *
     * @return int
     */
    protected function generateSuffix(string $slug, string $separator, Collection $list): int|string
    {
        $len = strlen($slug.$separator);

        // If the slug already exists, but belongs to
        // our model, return the current suffix.
        if ($list->search($slug) === $this->model->getKey()) {
            $suffix = explode($separator, $slug);

            return end($suffix);
        }

        $list->transform(fn($value, $key): int => (int)substr((string)$value, $len));

        // find the highest value and return one greater.
        return $list->max() + 1;
    }

    public function setModel(Model $model): static
    {
        $this->model = $model;

        return $this;
    }
}
