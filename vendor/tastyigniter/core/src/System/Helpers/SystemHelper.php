<?php

declare(strict_types=1);

namespace Igniter\System\Helpers;

use Igniter\Flame\Composer\Manager;
use Igniter\Flame\Exception\ApplicationException;
use Igniter\Flame\Exception\SystemException;
use Igniter\Flame\Support\Facades\File;
use Igniter\Flame\Support\Facades\Igniter;
use Illuminate\Support\Facades\Validator;

class SystemHelper
{
    public const string PLATFORM_HEADER = 'X-Igniter-Platform';

    /**
     * Returns the PHP version, without the distribution info.
     */
    public function phpVersion(): string
    {
        return PHP_MAJOR_VERSION.'.'.PHP_MINOR_VERSION.'.'.PHP_RELEASE_VERSION;
    }

    /**
     * Returns a PHP extension version, without the distribution info.
     */
    public function extensionVersion(string $name): string
    {
        $version = phpversion($name);

        return $this->normalizeVersion($version);
    }

    /**
     * Removes distribution info from a version
     */
    public function normalizeVersion(string $version): string
    {
        return preg_replace('/^([^\s~+-]+).*$/', '$1', $version);
    }

    public function validateVersion(string $version): bool
    {
        $semverRegex = '/^v?(?<major>\d+)(?:\.(?<minor>\d+)(?:\.(?<patch>\d+))?)?(?:-(?<pre_release>[0-9A-Za-z-.]+))?(?:\+(?<build>[0-9A-Za-z-.]+)?)?$/';

        return (bool)preg_match($semverRegex, $version, $matches, PREG_UNMATCHED_AS_NULL);
    }

    /**
     * Tests whether ini_set() works.
     */
    public function assertIniSet(): bool
    {
        $oldValue = ini_get('memory_limit');
        $oldBytes = $this->phpIniValueInBytes('memory_limit');

        // When the old value is not equal to '-1', add 1MB to the limit set at the moment
        $testBytes = $oldBytes === -1 ? 1024 * 1024 * 442 : $oldBytes + 1024 * 1024;

        $testValue = sprintf('%sM', ceil($testBytes / (1024 * 1024)));
        set_error_handler(function() {}); // @phpstan-ignore-line
        $result = ini_set('memory_limit', $testValue);
        $newValue = ini_get('memory_limit');
        ini_set('memory_limit', $oldValue);
        restore_error_handler();

        // ini_set can return false or an empty string depending on your php version / FastCGI.
        // If ini_set has been disabled in php.ini, the value will be null because of our muted error handler
        return !in_array($result, [false, '', $newValue], true);
    }

    public function assertIniMaxExecutionTime(int $int): bool
    {
        $timeLimit = (int)trim(ini_get('max_execution_time'));

        return $timeLimit !== 0 && $timeLimit < 120;
    }

    public function assertIniMemoryLimit(int $int): bool
    {
        $memoryLimit = $this->phpIniValueInBytes('memory_limit');

        return $memoryLimit !== -1 && $memoryLimit < 1024 * 1024 * 256;
    }

    /**
     * Retrieves a bool PHP config setting and normalizes it to an actual bool.
     */
    public function phpIniValueAsBool(string $var): bool
    {
        $value = trim(ini_get($var));

        return $value === '1' || strtolower($value) === 'on';
    }

    /**
     * Retrieves a disk size PHP config setting and normalizes it into bytes.
     */
    public function phpIniValueInBytes(string $var): float|int
    {
        $value = trim(ini_get($var));

        return $this->phpSizeInBytes($value);
    }

    /**
     * Normalizes a PHP file size into bytes.
     */
    public function phpSizeInBytes(string $value): float|int
    {
        $unit = strtolower(substr($value, -1, 1));
        $value = (int)$value;

        return match ($unit) {
            'g' => $value * 1024 * 1024 * 1024,
            'm' => $value * 1024 * 1024,
            'k' => $value * 1024,
            default => $value,
        };
    }

    public function replaceInEnv(string $search, string $replace): void
    {
        $file = base_path().'/.env';

        File::put(
            $file,
            preg_replace('/^'.$search.'(.*)$/m', $replace, File::get($file)),
        );

        putenv($replace);
    }

    public function extensionConfigFromFile(string $path): array
    {
        throw_if(
            File::exists($manifestFile = $path.'/extension.json'),
            new SystemException('extension.json files are no longer supported, please convert to composer.json: '.$manifestFile),
        );

        throw_unless(File::exists($path.'/composer.json'), new SystemException(
            sprintf('Required extension configuration file not found: %s/composer.json', $path),
        ));

        return resolve(Manager::class)->getExtensionManifest($path);
    }

    public function extensionValidateConfig(array $config): array
    {
        Validator::make($config, [
            'code' => [
                'required',
                'regex:/^[A-Za-z]+(\.?)+[A-Za-z]+$/',
                'max:64',
            ],
            'name' => ['required', 'string'],
            'author' => ['string'],
            'description' => ['required', 'string', 'max:255'],
            'icon' => ['sometimes'],
            'icon.class' => ['sometimes', 'string', 'max:30'],
            'icon.color' => ['sometimes', 'string', 'max:30'],
            'icon.image' => ['sometimes', 'string', 'max:30'],
            'icon.backgroundColor' => ['sometimes', 'string', 'max:30'],
            'homepage' => ['sometimes', 'url', 'max:255'],
            'require' => ['sometimes', 'array'],
        ])->validate();

        return $config;
    }

    /**
     * Read configuration from Config/Meta file
     */
    public function themeConfigFromFile(string $path): array
    {
        if (File::exists($path.'/theme.json')) {
            $config = File::json($path.'/theme.json');
        } elseif (File::exists($path.'/composer.json')) {
            $config = resolve(Manager::class)->getThemeManifest($path);
        } else {
            throw new SystemException('Theme does not have a registration file in: '.$path);
        }

        if (!array_key_exists('code', $config)) {
            $config['code'] = basename($path);
        }

        return $config;
    }

    public function themeValidateConfig(array $config): array
    {
        Validator::make($config, [
            'code' => [
                'required',
                'regex:/^[A-Za-z-]+(\.?)+[A-Za-z-]+$/',
                'max:64',
            ],
            'name' => ['required', 'string'],
            'author' => ['string'],
            'description' => ['required', 'string', 'max:255'],
        ])->validate();

        return $config;
    }

    public function runningOnWindows(): bool
    {
        return PHP_OS_FAMILY === 'Windows';
    }

    public function runningOnMac(): bool
    {
        return PHP_OS_FAMILY === 'Darwin';
    }

    public function runningOnLinux(): bool
    {
        return PHP_OS_FAMILY === 'Linux';
    }

    public function resolveUrl(): string
    {
        $url = config('app.url');

        if (blank($url)) {
            throw new ApplicationException(
                lang('igniter::system.updates.error_missing_app_url'),
            );
        }

        return rtrim((string) $url, '/');
    }

    public function platformHeaderValue(?string $installationUrl = null): string
    {
        return sprintf(
            'php:%s;version:%s;url:%s',
            PHP_VERSION,
            Igniter::version(),
            $installationUrl ?? $this->resolveUrl(),
        );
    }

    /**
     * @return string[]
     */
    public function composerHeaderLines(?string $installationUrl = null): array
    {
        return [self::PLATFORM_HEADER.': '.$this->platformHeaderValue($installationUrl)];
    }
}
