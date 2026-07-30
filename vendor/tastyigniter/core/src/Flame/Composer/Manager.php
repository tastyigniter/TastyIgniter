<?php

declare(strict_types=1);

namespace Igniter\Flame\Composer;

use Closure;
use Composer\Autoload\ClassLoader;
use Composer\Config\JsonConfigSource;
use Composer\Json\JsonFile;
use Facades\Igniter\System\Helpers\SystemHelper;
use Igniter\Flame\Support\Facades\File;
use Igniter\System\Classes\PackageInfo;
use Illuminate\Support\Collection;
use RuntimeException;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;
use Throwable;

use function Illuminate\Support\php_binary;

/**
 * Manager Class
 */
class Manager
{
    protected const string REPOSITORY_HOST = 'composer.tastyigniter.com';

    /** The primary composer instance. */
    protected ?ClassLoader $loader = null;

    protected ?Collection $installedPackages = null;

    public function __construct(
        protected string $workingPath,
        protected string $storagePath,
    ) {}

    public function getPackageVersion(string $name): ?string
    {
        return array_get($this->loadInstalledPackages()->get($name, []), 'version');
    }

    public function getPackageName(string $name): ?string
    {
        return array_get($this->loadInstalledPackages()->get($name, []), 'name');
    }

    public function listInstalledPackages(bool $fresh = false): Collection
    {
        return $this->loadInstalledPackages($fresh);
    }

    public function getExtensionManifest(string $path): array
    {
        return $this->formatPackageManifest($path);
    }

    public function getThemeManifest(string $path): array
    {
        return $this->formatPackageManifest($path, 'theme');
    }

    public function getLoader(): ?ClassLoader
    {
        if (is_null($this->loader) && File::isFile($path = $this->workingPath.'/vendor/autoload.php')) {
            $this->loader = require $path;
        }

        return $this->loader;
    }

    protected function loadInstalledPackages(bool $fresh = false): Collection
    {
        if (!$fresh && !is_null($this->installedPackages)) {
            return $this->installedPackages;
        }

        $path = $this->workingPath.'/vendor/composer/installed.json';
        $installed = File::exists($path) ? json_decode(File::get($path), true) : [];

        // Structure of the installed.json manifest in different in Composer 2.0
        $installedPackages = $installed['packages'] ?? $installed;

        return $this->installedPackages = collect($installedPackages)
            ->filter(fn(array $package): bool => $this->isValidPackage($package))
            ->mapWithKeys(function(array $package): array {
                if ($package['name'] === PackageInfo::CORE) {
                    $package['code'] = PackageInfo::CORE_CODE;
                }

                $package['type'] = $this->getPackageType($package);

                return [$this->getPackageCode($package) => $package];
            });
    }

    protected function formatPackageManifest(string $path, string $type = 'extension'): array
    {
        $composer = File::json($path.'/composer.json') ?? [];
        if (!$manifest = array_get($composer, 'extra.tastyigniter-'.$type, [])) {
            return $manifest;
        }

        $manifest['type'] = 'tastyigniter-'.$type;
        $manifest['package_name'] = array_get($composer, 'name');
        $manifest['namespace'] = key(array_get($composer, 'autoload.psr-4', []));
        $manifest['version'] = $this->getPackageVersion($manifest['code']);
        $manifest['description'] = array_get($composer, 'description');
        $manifest['author'] = array_get($composer, 'authors.0.name');
        $manifest['homepage'] = array_get($manifest, 'homepage', array_get($composer, 'homepage'));

        return array_filter($manifest);
    }

    protected function isValidPackage(array $package): bool
    {
        return in_array(array_get($package, 'type'), ['tastyigniter-package', 'tastyigniter-extension', 'tastyigniter-theme'])
            || array_get($package, 'name') === PackageInfo::CORE;
    }

    protected function getPackageCode(array $package): mixed
    {
        if (array_get($package, 'name') === PackageInfo::CORE) {
            return PackageInfo::CORE_CODE;
        }

        return array_get($package, 'extra.tastyigniter-package.code',
            array_get($package, 'extra.tastyigniter-extension.code',
                array_get($package, 'extra.tastyigniter-theme.code')));
    }

    protected function getPackageType(array $package): ?string
    {
        if (array_get($package, 'name') === PackageInfo::CORE) {
            return PackageInfo::CORE_TYPE;
        }

        $packageType = 'extension';
        if (array_get($package, 'extra.tastyigniter-theme')) {
            $packageType = 'theme';
        }

        return $packageType;
    }

    //
    //
    //

    public function modify(callable $callback): void
    {
        $composerFile = $this->findComposerFile();

        $composer = json_decode(file_get_contents($composerFile), true, 512, JSON_THROW_ON_ERROR);

        file_put_contents(
            $composerFile,
            json_encode(
                call_user_func($callback, $composer),
                JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE,
            ),
        );
    }

    public function outdated(Closure|OutputInterface|null $output = null): bool
    {
        $command = (new Collection([
            ...$this->findComposer(),
            'outdated',
            '--all',
            '--format=json',
        ]))->all();

        return $this->getProcess($command, ['COMPOSER_MEMORY_LIMIT' => '-1'])->run(
            $output instanceof OutputInterface
                ? function($type, string $line) use ($output) {
                    $output->write('    '.$line);
                } : $output,
        ) === 0;
    }

    public function install(array $packages, Closure|OutputInterface|null $output = null): void
    {
        $this->backupComposerFiles();

        try {
            $packages = array_map('strtolower', $packages);
            $command = (new Collection([
                ...$this->findComposer(),
                'require',
                ...$packages,
            ]))->all();

            $this->getProcess($command, ['COMPOSER_MEMORY_LIMIT' => '-1'])->mustRun(
                $output instanceof OutputInterface
                    ? function($type, string $line) use ($output) {
                        $output->write('    '.$line);
                    } : $output,
            );
        } catch (Throwable $throwable) {
            $this->restoreComposerFiles();

            throw $throwable;
        }
    }

    public function uninstall(array $requirements, Closure|OutputInterface|null $output = null): void
    {
        $this->backupComposerFiles();

        try {
            $packages = array_map('strtolower', $requirements);
            $command = (new Collection([
                ...$this->findComposer(),
                'remove',
                ...$packages,
            ]))->all();

            $this->getProcess($command, ['COMPOSER_MEMORY_LIMIT' => '-1'])->mustRun(
                $output instanceof OutputInterface
                    ? function($type, string $line) use ($output) {
                        $output->write('    '.$line);
                    } : $output,
            );
        } catch (Throwable $throwable) {
            $this->restoreComposerFiles();

            throw $throwable;
        }
    }

    public function addMarketplaceAuth(string $carteUsername, string $carteKey, ?string $installationUrl = null): void
    {
        $config = new JsonConfigSource(new JsonFile($this->workingPath.'/auth.json'), true);

        $config->addConfigSetting(
            'custom-headers.'.self::REPOSITORY_HOST,
            array_merge(
                ['TI-Rest-Key: '.$carteKey],
                SystemHelper::composerHeaderLines($installationUrl),
            ),
        );
    }

    protected function backupComposerFiles(): void
    {
        $jsonBackupPath = $this->storagePath.'/backups/composer.json';
        $lockBackupPath = $this->storagePath.'/backups/composer.lock';

        if (!File::isDirectory(dirname($jsonBackupPath))) {
            File::makeDirectory(dirname($jsonBackupPath), null, true);
        }

        File::copy($this->workingPath.'/composer.json', $jsonBackupPath);

        if (File::isFile($lockPath = $this->workingPath.'/composer.lock')) {
            File::copy($lockPath, $lockBackupPath);
        }
    }

    protected function restoreComposerFiles(): void
    {
        $jsonBackupPath = $this->storagePath.'/backups/composer.json';
        $lockBackupPath = $this->storagePath.'/backups/composer.lock';

        File::copy($jsonBackupPath, $this->workingPath.'/composer.json');

        if (File::isFile($lockBackupPath)) {
            File::copy($lockBackupPath, $this->workingPath.'/composer.lock');
        }
    }

    protected function getProcess(array $command, array $env = []): Process
    {
        // Ensure COMPOSER_HOME is set to ensure composer runs correctly in environments
        // where the global composer installation is not available or configured properly.
        if (!isset($env['COMPOSER_HOME']) && !getenv('COMPOSER_HOME')) {
            $env['COMPOSER_HOME'] = $this->storagePath;
        }

        return (new Process($command, $this->workingPath, $env))->setTimeout(null);
    }

    protected function findComposer(): array
    {
        if (File::exists($this->workingPath.'/composer.phar')) {
            return [php_binary(), 'composer.phar'];
        }

        return ['composer'];
    }

    protected function findComposerFile(): string
    {
        $composerFile = $this->workingPath.'/composer.json';

        if (!file_exists($composerFile)) {
            throw new RuntimeException(sprintf('Unable to locate `composer.json` file at [%s].', $this->workingPath));
        }

        return $composerFile;
    }

    //
    // Asserts
    //

    public function assertSchema(): void
    {
        $this->modify(function(array $composer): array {
            $newConfig = $this->assertRepository($composer);
            if ($composer !== $newConfig) {
                $composer = $newConfig;
            }

            return $composer;
        });
    }

    protected function assertRepository(array $config): array
    {
        foreach ($config['repositories'] ?? [] as $repository) {
            if (str_contains((string)$repository['url'], static::REPOSITORY_HOST)) {
                return $config;
            }
        }

        $config['repositories'] ??= [];

        array_unshift($config['repositories'], [
            'type' => 'composer',
            'url' => 'https://'.static::REPOSITORY_HOST,
            'canonical' => false,
        ]);

        return $config;
    }
}
