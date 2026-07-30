<?php

declare(strict_types=1);

namespace Igniter\Flame\Pagic\Concerns;

use Igniter\Flame\Pagic\Model;
use Igniter\Flame\Pagic\Source\SourceInterface;
use Igniter\Flame\Pagic\Source\SourceResolverInterface;
use Igniter\Main\Classes\Theme;
use Illuminate\Support\Collection;

trait ManagesSource
{
    /** The source resolver instance. */
    protected static ?SourceResolverInterface $resolver;

    protected ?string $source = null;

    /** The directory name associated with the model, eg: _pages. */
    protected ?string $dirName;

    /**
     * The maximum allowed path nesting level. The default value is 2,
     * meaning that files can only exist in the root directory, or in a
     * subdirectory. Set to null if any level is allowed.
     */
    protected int $maxNesting = 2;

    public static function on(string $source): static
    {
        return (new static)->setSource($source);
    }

    /**
     * Loads the object from a file.
     * This method is used in the admin. It doesn't use any caching.
     */
    public static function load(string $source, string $fileName): mixed
    {
        return static::on($source)->find($fileName);
    }

    /**
     * Loads the object from a cache.
     * This method is used by the main in the runtime. If the cache is not found, it is created.
     */
    public static function loadCached(string $source, string $fileName): mixed
    {
        return static::on($source)
            ->remember(config('igniter-pagic.parsedTemplateCacheTTL'))
            ->find($fileName);
    }

    /**
     * Returns the list of objects in the specified theme.
     * This method is used internally by the system.
     */
    public static function listInTheme(string|Theme|null $source = null, bool $skipCache = false): Collection
    {
        if ($source instanceof Theme) {
            $source = $source->getName();
        }

        $instance = static::on($source ?? static::$resolver->getDefaultSourceName());

        if (!static::getSourceResolver()->hasSource($instance->getSourceName())) {
            return $instance->newCollection();
        }

        if (!$skipCache) {
            $instance->remember(config('igniter-pagic.parsedTemplateCacheTTL'));
        }

        return $instance->get();
    }

    public static function getDropdownOptions(string|Theme|null $source = null, bool $skipCache = false): array
    {
        if ($source instanceof Theme) {
            $source = $source->getDirName();
        }

        return collect(static::listInTheme($source, $skipCache))
            ->mapWithKeys(function(Model $model): array {
                $fileName = $model->getKey();
                $description = (string)($model->description ?: $model->title);
                $description = str_limit(!empty($description) ? lang($description) : $fileName, 40);
                $description .= ' ['.$fileName.']';

                if ($model->isHidden) {
                    $description .= ' - Hidden';
                }

                return [$fileName => $description];
            })
            ->sort()->all();
    }

    public static function resolveSource(?string $source = null): SourceInterface
    {
        return static::$resolver->source($source);
    }

    /**
     * Get the source resolver instance.
     */
    public static function getSourceResolver(): SourceResolverInterface
    {
        return static::$resolver;
    }

    /**
     * Set the source resolver instance.
     */
    public static function setSourceResolver(SourceResolverInterface $resolver): void
    {
        static::$resolver = $resolver;
    }

    /**
     * Unset the source resolver for models.
     */
    public static function unsetSourceResolver(): void
    {
        static::$resolver = null;
    }

    public function getSource(): SourceInterface
    {
        return static::resolveSource($this->source);
    }

    public function setSource(string $source): static
    {
        $this->source = $source;

        return $this;
    }

    /**
     * Get the current source name for the model.
     */
    public function getSourceName(): string
    {
        return $this->source;
    }

    /**
     * Returns the file name without the extension.
     */
    public function getBaseFileNameAttribute(): string
    {
        return str_before($this->fileName, '.'.static::DEFAULT_EXTENSION);
    }

    /**
     * File name should always contain an extension.
     */
    public function setFileNameAttribute(?string $value): void
    {
        $fileName = trim((string)$value);

        if (strlen($fileName) && !strlen(pathinfo((string)$value, PATHINFO_EXTENSION))) {
            $fileName .= '.'.static::DEFAULT_EXTENSION;
        }

        $this->attributes['fileName'] = $fileName;
    }

    /**
     * Returns the directory name corresponding to the object type.
     * For pages the directory name is "_pages", for layouts - "_layouts", etc.
     */
    public function getTypeDirName(): ?string
    {
        return static::DIR_NAME;
    }

    /**
     * Returns the default file extensions supported by this model.
     */
    public function getDefaultExtension(): string
    {
        return static::DEFAULT_EXTENSION;
    }

    /**
     * Returns the maximum directory nesting allowed by this template.
     */
    public function getMaxNesting(): int
    {
        return $this->maxNesting;
    }

    /**
     * Returns the base file name and extension. Applies a default extension, if none found.
     */
    public function getFileNameParts(?string $fileName = null): array
    {
        if ($fileName === null) {
            $fileName = $this->fileName;
        }

        $fileName = str_before($fileName, '.'.static::DEFAULT_EXTENSION);

        return [str_replace('.', '/', $fileName), static::DEFAULT_EXTENSION];
    }

    //
    //
    //

    /**
     * Returns the local file path to the template.
     */
    public function getFilePath(?string $fileName = null): ?string
    {
        if ($fileName === null) {
            $fileName = $this->fileName;
        }

        if ($fileName && !str_ends_with((string)$fileName, '.'.static::DEFAULT_EXTENSION)) {
            $fileName .= '.'.static::DEFAULT_EXTENSION;
        }

        return $this->getSource()->path($this->getTypeDirName().'/'.$fileName);
    }

    /**
     * Returns the file name.
     */
    public function getFileName(): ?string
    {
        return $this->fileName;
    }

    /**
     * Returns the file name without the extension.
     */
    public function getBaseFileName(): ?string
    {
        return $this->baseFileName;
    }

    /**
     * Returns the file content.
     */
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * Gets the markup section of a template
     * @return string The template source code
     */
    public function getMarkup(): ?string
    {
        return $this->markup;
    }

    /**
     * Gets the code section of a template
     * @return string The template source code
     */
    public function getCode(): ?string
    {
        return $this->code;
    }

    /**
     * Returns the key used by the Template cache.
     */
    public function getTemplateCacheKey(): ?string
    {
        return $this->getFilePath();
    }
}
