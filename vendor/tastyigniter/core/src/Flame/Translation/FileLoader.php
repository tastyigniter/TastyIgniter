<?php

declare(strict_types=1);

namespace Igniter\Flame\Translation;

use Igniter\Flame\Translation\Contracts\Driver;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Translation\FileLoader as FileLoaderBase;
use Override;

class FileLoader extends FileLoaderBase
{
    /**
     * Translation driver instance.
     *
     * @var array<int, string>
     */
    protected $drivers = [];

    #[Override]
    public function load($locale, $group, $namespace = null)
    {
        $lines = parent::load($locale, $group, $namespace);

        if (is_null($namespace) || $namespace == '*') {
            return $lines;
        }

        $driverLines = $this->loadFromDrivers($locale, $group, $namespace);

        return array_replace_recursive($lines, $driverLines);
    }

    /**
     * @return array
     */
    public function loadFromDrivers($locale, $group, $namespace = null)
    {
        return collect($this->drivers)
            ->map(fn($className) => app($className))
            ->mapWithKeys(fn(Driver $driver) => $driver->load($locale, $group, $namespace))
            ->toArray();
    }

    public function addDriver(string $driver): void
    {
        $this->drivers[] = $driver;
    }

    /**
     * Load a local namespaced translation group for overrides.
     *
     * @param string $locale
     * @param string $group
     * @param string $namespace
     *
     * @return array
     * @throws FileNotFoundException
     */
    #[Override]
    protected function loadNamespaceOverrides(array $lines, $locale, $group, $namespace)
    {
        return collect($this->paths)
            ->reduce(function($output, $path) use ($lines, $locale, $group, $namespace): array {
                if (!$this->files->exists($path)) {
                    return $lines;
                }

                $slashNamespace = str_replace('.', '/', $namespace);
                $hyphenNamespace = str_replace('.', '-', $namespace);

                foreach ([
                    sprintf('%s/vendor/%s/%s/%s.php', $path, $slashNamespace, $locale, $group),
                    sprintf('%s/vendor/%s/%s/%s.php', $path, $hyphenNamespace, $locale, $group),
                    sprintf('%s/%s/%s/%s.php', $path, $locale, $slashNamespace, $group),
                    sprintf('%s/%s/%s/%s.php', $path, $locale, $hyphenNamespace, $group),
                    sprintf('%s/bundles/%s/%s/%s.php', $path, $locale, $slashNamespace, $group),
                    sprintf('%s/bundles/%s/%s/%s.php', $path, $locale, $hyphenNamespace, $group),
                ] as $file) {
                    if ($this->files->exists($file)) {
                        return array_replace_recursive($lines, $this->files->getRequire($file));
                    }
                }

                return $lines;
            }, []);
    }
}
