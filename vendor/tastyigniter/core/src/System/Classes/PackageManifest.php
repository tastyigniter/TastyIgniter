<?php

declare(strict_types=1);

namespace Igniter\System\Classes;

use Illuminate\Foundation\PackageManifest as BasePackageManifest;
use Override;

/**
 * PackageManifest class
 */
class PackageManifest extends BasePackageManifest
{
    protected string $metaFile = '/disabled-addons.json';

    protected ?array $coreAddonsCache = null;

    public function packages(): array
    {
        return $this->getManifest();
    }

    public function extensions(): array
    {
        return collect($this->getManifest())->where('type', 'tastyigniter-extension')->values()->all();
    }

    public function themes(): array
    {
        return collect($this->getManifest())->where('type', 'tastyigniter-theme')->values()->all();
    }

    public function getPackagePath(string $path): string
    {
        return str_starts_with($path, '../')
            ? $this->vendorPath.DIRECTORY_SEPARATOR.'composer'.DIRECTORY_SEPARATOR.$path
            : $path;
    }

    public function getVersion(string $code)
    {
        return collect($this->getManifest())->where('code', $code)->value('version');
    }

    public function coreVersion()
    {
        $packages = [];

        if ($this->files->exists($path = $this->vendorPath.'/composer/installed.json')) {
            $installed = json_decode($this->files->get($path), true);
            $packages = $installed['packages'] ?? $installed;
        }

        return collect($packages)
            ->filter(fn($package) => array_get($package, 'name') === 'tastyigniter/core')
            ->value('version');
    }

    #[Override]
    public function build(): void
    {
        $packages = [];

        if ($this->files->exists($path = $this->vendorPath.'/composer/installed.json')) {
            $installed = json_decode($this->files->get($path), true);
            $packages = $installed['packages'] ?? $installed;
        }

        $this->manifest = null; // @phpstan-ignore assign.propertyType

        $this->write(collect($packages)
            ->filter(fn($package): bool => array_has($package, 'extra.tastyigniter-extension') ||
                array_has($package, 'extra.tastyigniter-theme'))
            ->mapWithKeys(fn(array $package) => [
                $package['name'] => [
                    'code' => array_get($package, 'extra.tastyigniter-theme.code')
                        ?: array_get($package, 'extra.tastyigniter-extension.code'),
                    'type' => array_has($package, 'extra.tastyigniter-theme')
                        ? 'tastyigniter-theme'
                        : 'tastyigniter-extension',
                    'installPath' => array_get($package, 'install-path'),
                    'version' => array_get($package, 'version'),
                ],
            ])
            ->filter()
            ->all());
    }

    //
    //
    //

    public function coreAddons(): array
    {
        if (!is_null($this->coreAddonsCache)) {
            return $this->coreAddonsCache;
        }

        $corePath = __DIR__.'/../../../composer.json';
        $installed = json_decode($this->files->get($corePath), true);
        $addons = collect($installed['require'] ?? [])
            ->filter(fn($version, $name): bool => str_starts_with((string)$name, 'tastyigniter/'))
            ->map(fn($version, $name): array => [
                'code' => str_replace([
                    'tastyigniter/ti-ext-',
                    'tastyigniter/ti-theme-',
                ], 'igniter.', $name),
                'version' => $version,
            ])
            ->all();

        return $this->coreAddonsCache = $addons;
    }

    public function disabledAddons(): array
    {
        $path = dirname((string)$this->manifestPath).$this->metaFile;
        if (!is_file($path)) {
            return [];
        }

        return json_decode($this->files->get($path, true), true) ?: [];
    }

    public function writeDisabled(array $codes): void
    {
        $this->files->replace(dirname((string)$this->manifestPath).$this->metaFile, json_encode($codes));
    }
}
