<?php

declare(strict_types=1);

namespace Igniter\Flame\Assetic\Asset\Iterator;

use Override;
use RecursiveFilterIterator;

/**
 * Asset collection filter iterator.
 *
 * The filter iterator is responsible for de-duplication of leaf assets based
 * on both strict equality and source URL.
 *
 * @author Kris Wallsmith <kris.wallsmith@gmail.com>
 * @method AssetCollectionIterator getInnerIterator()
 */
class AssetCollectionFilterIterator extends RecursiveFilterIterator
{
    /**
     * Constructor.
     *
     * @param AssetCollectionIterator $iterator The inner iterator
     * @param array $visited An array of visited asset objects
     * @param array $sources An array of visited source strings
     */
    public function __construct(AssetCollectionIterator $iterator, private array $visited = [], private array $sources = [])
    {
        parent::__construct($iterator);
    }

    /**
     * Determines whether the current asset is a duplicate.
     *
     * De-duplication is performed based on either strict equality or by
     * matching sources.
     *
     * @return bool Returns true if we have not seen this asset yet
     */
    #[Override]
    public function accept(): bool
    {
        $asset = $this->getInnerIterator()->current(true);
        $duplicate = false;

        // check strict equality
        if (in_array($asset, $this->visited, true)) {
            $duplicate = true;
        } else {
            $this->visited[] = $asset;
        }

        // check source
        $sourceRoot = $asset->getSourceRoot();
        $sourcePath = $asset->getSourcePath();
        if ($sourceRoot && $sourcePath) {
            $source = $sourceRoot.'/'.$sourcePath;
            if (in_array($source, $this->sources)) {
                $duplicate = true;
            } else {
                $this->sources[] = $source;
            }
        }

        return !$duplicate;
    }

    /**
     * Passes visited objects and source URLs to the child iterator.
     */
    #[Override]
    public function getChildren(): ?RecursiveFilterIterator
    {
        return new self($this->getInnerIterator()->getChildren(), $this->visited, $this->sources);
    }
}
