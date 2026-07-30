<?php

declare(strict_types=1);

namespace Igniter\Flame\Assetic\Asset;

use Igniter\Flame\Assetic\Filter\FilterInterface;
use Igniter\Flame\Assetic\Util\VarUtils;
use Igniter\Flame\Support\Facades\File;
use InvalidArgumentException;
use Override;
use RuntimeException;

/**
 * Represents an asset loaded from a file.
 *
 * @author Kris Wallsmith <kris.wallsmith@gmail.com>
 */
class FileAsset extends BaseAsset
{
    private $source;

    /**
     * Constructor.
     *
     * @param string $source An absolute path
     * @param array $filters An array of filters
     * @param null|string $sourceRoot The source asset root directory
     * @param null|string $sourcePath The source asset path
     */
    public function __construct($source, array $filters = [], ?string $sourceRoot = null, ?string $sourcePath = null, array $vars = [])
    {
        if ($sourceRoot === null) {
            $sourceRoot = File::dirname($source);
            if ($sourcePath === null) {
                $sourcePath = File::name($source);
            }
        } elseif ($sourcePath === null) {
            if (!str_starts_with($source, $sourceRoot)) {
                throw new InvalidArgumentException(sprintf('The source "%s" is not in the root directory "%s"', $source, $sourceRoot));
            }

            $sourcePath = substr($source, strlen($sourceRoot) + 1);
        }

        $this->source = $source;

        parent::__construct($filters, $sourceRoot, $sourcePath, $vars);
    }

    #[Override]
    public function load(?FilterInterface $additionalFilter = null): void
    {
        $source = VarUtils::resolve($this->source, $this->getVars(), $this->getValues());

        if (!File::isFile($source)) {
            throw new RuntimeException(sprintf('The source file "%s" does not exist.', $source));
        }

        $this->doLoad(File::get($source), $additionalFilter);
    }

    #[Override]
    public function getLastModified(): ?int
    {
        $source = VarUtils::resolve($this->source, $this->getVars(), $this->getValues());

        if (!File::isFile($source)) {
            throw new RuntimeException(sprintf('The source file "%s" does not exist.', $source));
        }

        return File::lastModified($source);
    }
}
