<?php

declare(strict_types=1);

namespace Igniter\Flame\Assetic\Filter;

use Igniter\Flame\Assetic\Asset\AssetInterface;
use Igniter\Flame\Assetic\Factory\AssetFactory;
use Igniter\Flame\Assetic\Util\CssUtils;
use Override;
use ScssPhp\ScssPhp\Compiler;
use ScssPhp\ScssPhp\Formatter\Compressed;
use ScssPhp\ScssPhp\Formatter\Crunched;
use ScssPhp\ScssPhp\Formatter\Expanded;
use ScssPhp\ScssPhp\Formatter\Nested;

/**
 * Loads SCSS files using the PHP implementation of scss, scssphp.
 *
 * Scss files are mostly compatible, but there are slight differences.
 *
 * @link http://leafo.net/scssphp/
 *
 * @author Bart van den Burg <bart@samson-it.nl>
 */
class ScssphpFilter implements DependencyExtractorInterface
{
    private array $importPaths = [];

    private array $customFunctions = [];

    private ?string $formatter = null;

    private array $variables = [];

    public function setFormatter(string $formatter): void
    {
        $legacyFormatters = [
            'scss_formatter' => Expanded::class,
            'scss_formatter_nested' => Nested::class,
            'scss_formatter_compressed' => Compressed::class,
            'scss_formatter_crunched' => Crunched::class,
        ];

        if (isset($legacyFormatters[$formatter])) {
            @trigger_error(sprintf('The scssphp formatter `%s` is deprecated. Use `%s` instead.', $formatter, $legacyFormatters[$formatter]), E_USER_DEPRECATED);

            $formatter = $legacyFormatters[$formatter];
        }

        $this->formatter = $formatter;
    }

    public function setVariables(array $variables): void
    {
        $this->variables = $variables;
    }

    public function addVariable($variable, $value = null): void
    {
        $this->variables[$variable] = $value;
    }

    public function setImportPaths(array $paths): void
    {
        $this->importPaths = $paths;
    }

    public function addImportPath($path): void
    {
        $this->importPaths[] = $path;
    }

    public function registerFunction($name, $callable): void
    {
        $this->customFunctions[$name] = $callable;
    }

    #[Override]
    public function filterLoad(AssetInterface $asset): void
    {
        $sc = new Compiler;

        if ($dir = $asset->getSourceDirectory()) {
            $sc->addImportPath($dir);
        }

        foreach ($this->importPaths as $path) {
            $sc->addImportPath($path);
        }

        foreach ($this->customFunctions as $name => $callable) {
            $sc->registerFunction($name, $callable);
        }

        if ($this->formatter) {
            $sc->setOutputStyle($this->formatter);
        }

        if (!empty($this->variables)) {
            $sc->replaceVariables($this->variables);
        }

        $asset->setContent($sc->compileString($asset->getContent())->getCss());
    }

    #[Override]
    public function filterDump(AssetInterface $asset) {}

    #[Override]
    public function getChildren(AssetFactory $factory, $content, $loadPath = null): array
    {
        $sc = new Compiler;
        if ($loadPath !== null) {
            $sc->addImportPath($loadPath);
        }

        foreach ($this->importPaths as $path) {
            $sc->addImportPath($path);
        }

        $children = [];
        foreach (CssUtils::extractImports($content) as $match) {
            $file = $sc->findImport($match);
            if ($file) {
                $children[] = $child = $factory->createAsset($file, [], ['root' => $loadPath]);
                $child->load();
                $children = array_merge($children, $this->getChildren($factory, $child->getContent(), $loadPath));
            }
        }

        return $children;
    }
}
