<?php

declare(strict_types=1);

namespace Igniter\Flame\Assetic\Asset;

use Igniter\Flame\Assetic\Filter\FilterCollection;
use Igniter\Flame\Assetic\Filter\FilterInterface;
use InvalidArgumentException;
use Override;
use RuntimeException;

/**
 * A base abstract asset.
 *
 * The methods load() and getLastModified() are left undefined, although a
 * reusable doLoad() method is available to child classes.
 *
 * @author Kris Wallsmith <kris.wallsmith@gmail.com>
 */
abstract class BaseAsset implements AssetInterface
{
    private FilterCollection $filters;

    private ?string $sourceDir = null;

    private string $targetPath = '';

    private string $content = '';

    private bool $loaded = false;

    private array $values = [];

    public function __construct(
        array $filters,
        private readonly ?string $sourceRoot = null,
        private readonly ?string $sourcePath = null,
        private readonly array $vars = [],
    ) {
        $this->filters = new FilterCollection($filters);
        if ($sourcePath && $sourceRoot) {
            $this->sourceDir = dirname(sprintf('%s/%s', $sourceRoot, $sourcePath));
        }
    }

    public function __clone()
    {
        $this->filters = clone $this->filters;
    }

    #[Override]
    public function ensureFilter(FilterInterface $filter): void
    {
        $this->filters->ensure($filter);
    }

    #[Override]
    public function getFilters(): array
    {
        return $this->filters->all();
    }

    #[Override]
    public function clearFilters(): void
    {
        $this->filters->clear();
    }

    /**
     * Encapsulates asset loading logic.
     *
     * @param string $content The asset content
     * @param ?FilterInterface $additionalFilter An additional filter
     */
    protected function doLoad(string $content, ?FilterInterface $additionalFilter = null)
    {
        $filter = clone $this->filters;
        if (!is_null($additionalFilter)) {
            $filter->ensure($additionalFilter);
        }

        $asset = clone $this;
        $asset->setContent($content);

        $filter->filterLoad($asset);
        $this->content = $asset->getContent();

        $this->loaded = true;
    }

    #[Override]
    public function dump(?FilterInterface $additionalFilter = null): string
    {
        if (!$this->loaded) {
            $this->load();
        }

        $filter = clone $this->filters;
        if (!is_null($additionalFilter)) {
            $filter->ensure($additionalFilter);
        }

        $asset = clone $this;
        $filter->filterDump($asset);

        return $asset->getContent();
    }

    #[Override]
    public function getContent(): string
    {
        return $this->content;
    }

    #[Override]
    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    #[Override]
    public function getSourceRoot(): ?string
    {
        return $this->sourceRoot;
    }

    #[Override]
    public function getSourcePath(): ?string
    {
        return $this->sourcePath;
    }

    #[Override]
    public function getSourceDirectory(): ?string
    {
        return $this->sourceDir;
    }

    #[Override]
    public function getTargetPath(): ?string
    {
        return $this->targetPath;
    }

    #[Override]
    public function setTargetPath(string $targetPath): void
    {
        foreach ($this->vars as $var) {
            if (!str_contains($targetPath, (string)$var)) {
                throw new RuntimeException(sprintf('The asset target path "%s" must contain the variable "{%s}".', $targetPath, $var));
            }
        }

        $this->targetPath = $targetPath;
    }

    #[Override]
    public function getVars(): array
    {
        return $this->vars;
    }

    #[Override]
    public function setValues(array $values): void
    {
        foreach (array_keys($values) as $var) {
            if (!in_array($var, $this->vars, true)) {
                throw new InvalidArgumentException(sprintf('The asset with source path "%s" has no variable named "%s".', $this->sourcePath, $var));
            }
        }

        $this->values = $values;
        $this->loaded = false;
    }

    #[Override]
    public function getValues(): array
    {
        return $this->values;
    }
}
