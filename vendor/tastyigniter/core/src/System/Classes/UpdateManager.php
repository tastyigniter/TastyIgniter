<?php

declare(strict_types=1);

namespace Igniter\System\Classes;

use Closure;
use Facades\Igniter\System\Helpers\SystemHelper;
use Igniter\Flame\Composer\Manager as ComposerManager;
use Igniter\Flame\Database\Migrations\DatabaseMigrationRepository;
use Igniter\Flame\Database\Migrations\Migrator;
use Igniter\Flame\Exception\ApplicationException;
use Igniter\Flame\Support\Facades\Igniter;
use Igniter\Main\Classes\ThemeManager;
use Igniter\Main\Models\Theme;
use Igniter\System\Database\Seeds\DatabaseSeeder;
use Igniter\System\Models\Extension;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\Console\Output\OutputInterface;
use UnexpectedValueException;

/**
 * TastyIgniter Updates Manager Class
 */
class UpdateManager
{
    protected array $logs = [];

    protected ?OutputInterface $logsOutput = null;

    protected array $installedItems = [];

    protected ThemeManager $themeManager;

    protected HubManager $hubManager;

    protected ExtensionManager $extensionManager;

    protected ComposerManager $composerManager;

    protected Migrator $migrator;

    protected DatabaseMigrationRepository $repository;

    protected bool $disableCoreUpdates = false;

    public function __construct()
    {
        $this->disableCoreUpdates = config('igniter-system.disableCoreUpdates', false);
        $this->bindContainerObjects();
    }

    public function bindContainerObjects(): void
    {
        $this->hubManager = resolve(HubManager::class);
        $this->themeManager = resolve(ThemeManager::class);
        $this->extensionManager = resolve(ExtensionManager::class);
        $this->composerManager = resolve(ComposerManager::class);

        $this->migrator = resolve(Migrator::class);
        $this->repository = resolve(DatabaseMigrationRepository::class);
    }

    /**
     * Set the output implementation that should be used by the console.
     */
    public function setLogsOutput(OutputInterface $output): static
    {
        $this->logsOutput = $output;
        $this->migrator->setOutput($output);

        return $this;
    }

    public function log(string $message): static
    {
        if (!is_null($this->logsOutput)) {
            $this->logsOutput->writeln($message);
        }

        $this->logs[] = $message;

        return $this;
    }

    public function resetLogs(): static
    {
        $this->logs = [];

        return $this;
    }

    public function getLogs(): array
    {
        return $this->logs;
    }

    //
    //
    //

    public function down(?string $database = null): static
    {
        $this->migrator->usingConnection($database, function() {
            if (!$this->migrator->repositoryExists()) {
                return $this->log('<error>Migration table not found.</error>');
            }

            // Rollback extensions
            foreach (array_keys(Igniter::migrationPath()) as $code) {
                $this->purgeExtension($code);
            }

            if (!is_null($this->logsOutput)) {
                $this->migrator->setOutput($this->logsOutput);
            }

            foreach (array_reverse(Igniter::coreMigrationPath(), true) as $group => $path) {
                $this->log(sprintf('<info>Rolling back %s</info>', $group));

                $this->migrator->resetAll([$group => $path]);

                $this->log(sprintf('<info>Rolled back %s</info>', $group));
            }
        });

        return $this;
    }

    public function migrate(?string $database = null): static
    {
        $this->migrator->usingConnection($database, function() {
            if (!is_null($this->logsOutput)) {
                $this->migrator->setOutput($this->logsOutput);
            }

            $this->migrator->runGroup(Igniter::coreMigrationPath());

            Model::unguarded(function() {
                resolve(DatabaseSeeder::class)->__invoke();
            });

            $this->migrator->runGroup(Igniter::migrationPath());
        });

        return $this;
    }

    public function migrateExtension(string $name): static
    {
        if (!array_has(Igniter::migrationPath(), $name)) {
            return $this->log('<error>Unable to find migrations for:</error> '.$name);
        }

        $this->log(sprintf('<info>Migrating extension %s</info>', $name));

        if (!is_null($this->logsOutput)) {
            $this->migrator->setOutput($this->logsOutput);
        }

        $this->migrator->runGroup(array_only(Igniter::migrationPath(), $name));

        return $this;
    }

    public function purgeExtension(string $name): static
    {
        if (!array_has(Igniter::migrationPath(), $name)) {
            return $this->log('<error>Unable to find migrations for:</error> '.$name);
        }

        $this->log(sprintf('<info>Purging extension %s</info>', $name));

        if (!is_null($this->logsOutput)) {
            $this->migrator->setOutput($this->logsOutput);
        }

        $this->migrator->resetAll(array_only(Igniter::migrationPath(), $name));

        return $this;
    }

    public function rollbackExtension(string $name, array $options = []): static
    {
        if (!array_has(Igniter::migrationPath(), $name)) {
            return $this->log('<error>Unable to find migrations for:</error> '.$name);
        }

        $this->log(sprintf('<info>Rolling back extension %s</info>', $name));

        if (!is_null($this->logsOutput)) {
            $this->migrator->setOutput($this->logsOutput);
        }

        $this->migrator->rollbackAll(array_only(Igniter::migrationPath(), $name), $options);

        return $this;
    }

    //
    //
    //

    public function isLastCheckDue(): bool
    {
        $response = $this->requestUpdateList();

        return !isset($response['last_check']) || strtotime('-7 day') < strtotime((string)$response['last_check']);
    }

    public function getCarteInfo(): ?array
    {
        return params('carte_info');
    }

    public function hasValidCarte(): bool
    {
        return !empty(config('igniter-system.carteKey') ?: params('carte_key', '')) && !empty(params('carte_info'));
    }

    public function hasLicenceWarning(?array $carteInfo = null): bool
    {
        $alertCode = array_get(array_get($carteInfo ?? $this->getCarteInfo() ?? [], 'licence'), 'alert.code');

        return filled($alertCode) && $alertCode !== 'installation_bound';
    }

    public function syncCarteLicence(): void
    {
        $key = config('igniter-system.carteKey') ?: params('carte_key', '');
        $info = $this->getCarteInfo();

        if (blank($key) || blank($info)) {
            return;
        }

        $result = $this->hubManager->getSiteDetail();

        $this->setCarte($key, $this->mergeCarteInfoFromResponse($info, $result));
    }

    public function applyCarte(string $key): array
    {
        $this->setCarte($key);

        $result = $this->hubManager->getSiteDetail();
        $info = $this->mergeCarteInfoFromResponse([], $result);

        $this->setCarte($key, $info);

        return $info;
    }

    protected function mergeCarteInfoFromResponse(array $info, array $result): array
    {
        if (isset($result['data']) && is_array($result['data'])) {
            $info = array_merge($info, $result['data']);
        }

        $info['licence'] = array_get($result, 'meta.licence');

        return $info;
    }

    public function setCarte(string $key, ?array $info = null): void
    {
        SystemHelper::replaceInEnv('IGNITER_CARTE_KEY=', 'IGNITER_CARTE_KEY='.$key);
        setting()->setPref([
            'carte_key' => $key,
            'carte_info' => $info,
        ]);
    }

    public function clearCarte(): void
    {
        SystemHelper::replaceInEnv('IGNITER_CARTE_KEY=', 'IGNITER_CARTE_KEY=');
        setting()->setPref([
            'carte_key' => null,
            'carte_info' => null,
        ]);
    }

    public function requestUpdateList(bool $force = false): array
    {
        $installedItems = $this->composerManager->listInstalledPackages()->keyBy('name');

        $result = $this->fetchOutdatedItems($force);

        [$ignoredItems, $items] = collect(array_get($result, 'items', []))
            ->filter(fn($package): bool => $installedItems->has($package['name']) && $package['latest-status'] !== 'up-to-date')
            ->map(function(array $package) use ($installedItems): PackageInfo {
                $installedPackageInfo = $installedItems->get($package['name']);
                $packageManifest = $package['name'] === PackageInfo::CORE
                    ? PackageInfo::CORE_MANIFEST
                    : array_get($installedPackageInfo, 'extra.tastyigniter-package',
                        array_get($installedPackageInfo, 'extra.tastyigniter-extension',
                            array_get($installedPackageInfo, 'extra.tastyigniter-theme', [])));
                $installedPackageInfo['package'] = $package['name'];
                $installedPackageInfo['version'] = $package['latest'];
                $installedPackageInfo['installedVersion'] = $package['version'];
                $installedPackageInfo = array_merge($installedPackageInfo, $packageManifest);

                return PackageInfo::fromArray($installedPackageInfo);
            })
            ->filter(fn(PackageInfo $packageInfo): bool => !$packageInfo->isCore() || !$this->disableCoreUpdates)
            ->sortBy(fn(PackageInfo $packageInfo) => starts_with($packageInfo->package, 'tastyigniter/') ? 0 : 1)
            ->partition(fn(PackageInfo $packageInfo): bool => $this->isMarkedAsIgnored($packageInfo->code));

        $result['count'] = $items->count();
        $result['items'] = $items->values();
        $result['ignoredItems'] = $ignoredItems->values();

        return $result;
    }

    public function getInstalledItems(?string $type = null): array
    {
        if ($this->installedItems) {
            return ($type && isset($this->installedItems[$type]))
                ? $this->installedItems[$type] : $this->installedItems;
        }

        $installedItems = [];

        $extensionVersions = Extension::pluck('version', 'name');
        foreach ($extensionVersions as $code => $version) {
            $installedItems['extensions'][] = [
                'name' => $code,
                'ver' => $version,
                'type' => 'extension',
            ];
        }

        $themeVersions = Theme::pluck('version', 'code');
        foreach ($themeVersions as $code => $version) {
            $installedItems['themes'][] = [
                'name' => $code,
                'ver' => $version,
                'type' => 'theme',
            ];
        }

        $this->installedItems = array_collapse($installedItems);

        if (!is_null($type)) {
            return $installedItems[$type] ?? [];
        }

        return $this->installedItems;
    }

    public function requestItemDetail(array $params): array
    {
        return $this->hubManager->getItemDetail($params);
    }

    public function markedAsIgnored(string $code, bool $remove = false): void
    {
        $ignoredUpdates = $this->getIgnoredUpdates();

        array_set($ignoredUpdates, $code, !$remove);

        setting()->set('ignored_updates', array_filter($ignoredUpdates));
    }

    public function getIgnoredUpdates(): array
    {
        return array_dot(setting()->get('ignored_updates') ?? []);
    }

    public function isMarkedAsIgnored(string $code): bool
    {
        return array_get($this->getIgnoredUpdates(), $code, false);
    }

    protected function fetchOutdatedItems(bool $force = false): array
    {
        $cacheKey = 'hub_updates';
        if ($force || !$response = Cache::get($cacheKey)) {
            $this->composerManager->assertSchema();
            if ($this->hasValidCarte()) {
                $this->configureComposerAuth(array_get($this->getCarteInfo(), 'email', ''));
            }

            $composerLog = [];
            $this->composerManager->outdated(function($type, $line) use (&$outdatedItems, &$composerLog) {
                if ($type === 'out') {
                    $outdatedItems = json_decode($line, true);
                } else {
                    $composerLog[] = $line;
                }
            });

            logger()->info(implode(PHP_EOL, $composerLog));

            $response['items'] = array_get($outdatedItems, 'installed', []);
            $response['last_checked_at'] = Carbon::now()->toDateTimeString();

            Cache::put($cacheKey, $response, now()->addHours(config('igniter-system.composerOutdatedCacheTTL', 6)));
        }

        return $response;
    }

    //
    //
    //

    public function preInstall(): void
    {
        if (!SystemHelper::assertIniSet()) {
            $this->log(lang('igniter::system.updates.progress_preinstall_ok'));

            return;
        }

        $hasErrors = false;
        $errorMessage = "Please fix the following in your php.ini file before proceeding:\n\n";
        if (SystemHelper::assertIniMaxExecutionTime(120)) {
            $errorMessage .= "max_execution_time should be at least 120.\n";
            $hasErrors = true;
        }

        if (SystemHelper::assertIniMemoryLimit(1024 * 1024 * 256)) {
            $errorMessage .= "memory_limit should be at least 256M.\n";
            $hasErrors = true;
        }

        $errorMessage .= "\n".'<a href="https://tastyigniter.com/support/articles/php-ini" target="_blank">Learn how</a>';

        throw_if($hasErrors, new ApplicationException($errorMessage));
    }

    public function install(array $packages, Closure|OutputInterface|null $output = null): array
    {
        $packages = collect($packages);
        $packageNames = $packages->map(fn(PackageInfo $packageInfo) => $packageInfo->package)->all();

        $this->composerManager->assertSchema();
        if ($this->hasValidCarte()) {
            $this->configureComposerAuth(array_get($this->getCarteInfo(), 'email'));
        }

        $this->composerManager->install($packageNames, $output);

        return collect($this->composerManager->listInstalledPackages(fresh: true))
            ->filter(fn(array $package): bool => in_array($package['name'], $packageNames))
            ->map(function(array $package) use ($packages) {
                $packageInfo = $packages->firstWhere(fn(PackageInfo $packageInfo) => $packageInfo->package === $package['name']);
                if ($packageInfo->version !== $package['version']) {
                    return null;
                }

                $this->log(sprintf(lang('igniter::system.updates.progress_install_version'),
                    $packageInfo->name, $packageInfo->installedVersion, $package['version'],
                ));

                return $packageInfo;
            })
            ->filter()
            ->all();
    }

    public function completeInstall(array $packages): void
    {
        collect($packages)->each(function(PackageInfo $packageInfo) {
            match ($packageInfo->type) {
                'core' => $this->migrate(),
                'extension' => $this->extensionManager->installExtension($packageInfo->code, $packageInfo->version),
                'theme' => $this->themeManager->installTheme($packageInfo->code, $packageInfo->version),
                default => throw new UnexpectedValueException(sprintf('Unknown package type: %s', $packageInfo->type)),
            };
        });

        if (!empty($packages)) {
            rescue(function() use ($packages) {
                $this->hubManager->applyInstalledItems(collect($packages)
                    ->map(fn(PackageInfo $packageInfo) => [
                        'name' => $packageInfo->package,
                        'type' => $packageInfo->type,
                        'ver' => $packageInfo->version,
                    ])
                    ->all());
            });
        }
    }

    protected function configureComposerAuth(?string $carteUsername = null): void
    {
        $this->composerManager->addMarketplaceAuth(
            $carteUsername,
            config('igniter-system.carteKey') ?: params('carte_key', ''),
        );
    }
}
