<?php

declare(strict_types=1);

namespace Igniter\Flame\Assetic\Filter;

use Igniter\Flame\Assetic\Asset\AssetInterface;
use Igniter\Flame\Support\Facades\File;
use Override;

/**
 * Fixes relative CSS urls.
 *
 * @author Kris Wallsmith <kris.wallsmith@gmail.com>
 */
class CssRewriteFilter extends BaseCssFilter
{
    #[Override]
    public function filterLoad(AssetInterface $asset) {}

    #[Override]
    public function filterDump(AssetInterface $asset): void
    {
        $sourceBase = $asset->getSourceRoot();
        $sourcePath = $asset->getSourcePath();
        $targetPath = $asset->getTargetPath();

        if ($sourcePath === null || $targetPath === null || $sourcePath === $targetPath) {
            return;
        }

        // learn how to get from the target back to the source
        if (str_contains((string)$sourceBase, '://')) {
            [$scheme, $url] = explode('://', $sourceBase.'/'.$sourcePath, 2);
            [$host, $path] = explode('/', $url, 2);

            $host = $scheme.'://'.$host.'/';
            $path = !str_contains($path, '/') ? '' : File::dirname($path);
            $path .= '/';
        } else {
            // assume source and target are on the same host
            $host = '';

            // pop entries off the target until it fits in the source
            if (File::dirname($sourcePath) == '.') {
                $path = str_repeat('../', substr_count($targetPath, '/'));
            } elseif ('.' == $targetDir = File::dirname($targetPath)) {
                $path = File::dirname($sourcePath).'/';
            } else {
                $path = '';
                while (!str_starts_with($sourcePath, $targetDir)) {
                    if (false !== $pos = strrpos($targetDir, '/')) {
                        $targetDir = substr($targetDir, 0, $pos);
                        $path .= '../';
                    } else {
                        $targetDir = '';
                        $path .= '../';
                        break;
                    }
                }

                $path .= ltrim(substr(File::dirname($sourcePath).'/', strlen($targetDir)), '/');
            }
        }

        $content = $this->filterReferences($asset->getContent(), function(array $matches) use ($host, $path) {
            if (str_contains((string)$matches['url'], '://') ||
                str_starts_with((string)$matches['url'], '//') ||
                str_starts_with((string)$matches['url'], 'data:')
            ) {
                // absolute or protocol-relative or data uri
                return $matches[0];
            }

            if (isset($matches['url'][0]) && $matches['url'][0] == '/') {
                // root relative
                return str_replace($matches['url'], $host.$matches['url'], $matches[0]);
            }

            // document relative
            $url = $matches['url'];
            while (str_starts_with((string)$url, '../') && substr_count($path, '/') >= 2) {
                $path = substr($path, 0, strrpos(rtrim($path, '/'), '/') + 1);
                $url = substr((string)$url, 3);
            }

            $parts = [];
            foreach (explode('/', $host.$path.$url) as $part) {
                if ($part === '..' && count($parts) && end($parts) !== '..') {
                    array_pop($parts);
                } else {
                    $parts[] = $part;
                }
            }

            return str_replace($matches['url'], implode('/', $parts), $matches[0]);
        });

        $asset->setContent($content);
    }
}
