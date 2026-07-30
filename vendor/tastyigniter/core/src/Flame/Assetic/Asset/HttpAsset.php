<?php

declare(strict_types=1);

namespace Igniter\Flame\Assetic\Asset;

use Igniter\Flame\Assetic\Filter\FilterInterface;
use Igniter\Flame\Assetic\Util\VarUtils;
use Igniter\Flame\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use InvalidArgumentException;
use Override;
use RuntimeException;

/**
 * Represents an asset loaded via an HTTP request.
 *
 * @author Kris Wallsmith <kris.wallsmith@gmail.com>
 */
class HttpAsset extends BaseAsset
{
    private readonly string $sourceUrl;

    /**
     * Constructor.
     *
     * @param string $sourceUrl The source URL
     * @param array $filters An array of filters
     *
     * @throws InvalidArgumentException If the first argument is not an URL
     */
    public function __construct(string $sourceUrl, array $filters = [], private readonly bool $ignoreErrors = false, array $vars = [])
    {
        if (str_starts_with($sourceUrl, '//')) {
            $sourceUrl = 'http:'.$sourceUrl;
        } elseif (!str_contains($sourceUrl, '://')) {
            throw new InvalidArgumentException(sprintf('"%s" is not a valid URL.', $sourceUrl));
        }

        $this->sourceUrl = $sourceUrl;

        [$scheme, $url] = explode('://', $sourceUrl, 2);
        [$host, $path] = explode('/', $url, 2);

        parent::__construct($filters, $scheme.'://'.$host, $path, $vars);
    }

    #[Override]
    public function load(?FilterInterface $additionalFilter = null): void
    {
        $content = @File::get(
            VarUtils::resolve($this->sourceUrl, $this->getVars(), $this->getValues()),
        );

        if ($content === false && !$this->ignoreErrors) {
            throw new RuntimeException(sprintf('Unable to load asset from URL "%s"', $this->sourceUrl));
        }

        $this->doLoad($content, $additionalFilter);
    }

    #[Override]
    public function getLastModified(): ?int
    {
        $response = Http::withHeaders(['Accept' => '*/*'])->head($this->sourceUrl);
        if ($response->successful() && ($lastModified = $response->header('Last-Modified'))) {
            return strtotime($lastModified);
        }

        return null;
    }
}
