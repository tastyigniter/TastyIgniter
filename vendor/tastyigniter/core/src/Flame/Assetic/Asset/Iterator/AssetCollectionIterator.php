<?php

declare(strict_types=1);

namespace Igniter\Flame\Assetic\Asset\Iterator;

use Igniter\Flame\Assetic\Asset\AssetCollection;
use Igniter\Flame\Assetic\Asset\AssetCollectionInterface;
use Igniter\Flame\Assetic\Asset\AssetInterface;
use Override;
use RecursiveIterator;
use SplObjectStorage;

/**
 * Iterates over an asset collection.
 *
 * The iterator is responsible for cascading filters and target URL patterns
 * from parent to child assets.
 *
 * @author Kris Wallsmith <kris.wallsmith@gmail.com>
 */
class AssetCollectionIterator implements RecursiveIterator
{
    private array $assets;

    private readonly array $filters;

    private readonly array $vars;

    private ?string $output;

    public function __construct(AssetCollectionInterface $coll, private SplObjectStorage $clones)
    {
        $this->assets = $coll->all();
        $this->filters = $coll->getFilters();
        $this->vars = $coll->getVars();
        $this->output = $coll->getTargetPath();

        if (false === $pos = strrpos((string)$this->output, '.')) {
            $this->output .= '_*';
        } else {
            $this->output = substr((string)$this->output, 0, $pos).'_*'.substr((string)$this->output, $pos);
        }
    }

    /**
     * Returns a copy of the current asset with filters and a target URL applied.
     *
     * @param bool $raw Returns the unmodified asset if true
     *
     * @return AssetInterface
     */
    #[Override]
    public function current($raw = false): mixed
    {
        $asset = current($this->assets);

        if (!$asset || $raw) {
            return $asset;
        }

        // clone once
        if (!isset($this->clones[$asset])) {
            $clone = $this->clones[$asset] = clone $asset;

            // generate a target path based on asset name
            $name = sprintf('%s_%d', pathinfo($asset->getSourcePath() ?? '', PATHINFO_FILENAME) ?: 'part', $this->key() + 1);

            $name = $this->removeDuplicateVar($name);

            $clone->setTargetPath(str_replace('*', $name, $this->output));
        } else {
            $clone = $this->clones[$asset];
        }

        // cascade filters
        foreach ($this->filters as $filter) {
            $clone->ensureFilter($filter);
        }

        return $clone;
    }

    #[Override]
    public function key(): mixed
    {
        return key($this->assets);
    }

    #[Override]
    public function next(): void
    {
        next($this->assets);
    }

    #[Override]
    public function rewind(): void
    {
        reset($this->assets);
    }

    #[Override]
    public function valid(): bool
    {
        return current($this->assets) !== false;
    }

    #[Override]
    public function hasChildren(): bool
    {
        return current($this->assets) instanceof AssetCollectionInterface;
    }

    /**
     * @uses current()
     */
    #[Override]
    public function getChildren(): ?AssetCollectionIterator
    {
        return new self(new AssetCollection([$this->current()]), $this->clones);
    }

    private function removeDuplicateVar(string $name): string
    {
        foreach ($this->vars as $var) {
            $var = '{'.$var.'}';
            if (str_contains($name, $var) && str_contains((string)$this->output, $var)) {
                $name = str_replace($var, '', $name);
            }
        }

        return $name;
    }
}
