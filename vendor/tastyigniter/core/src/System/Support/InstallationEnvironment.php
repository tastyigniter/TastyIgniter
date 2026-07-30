<?php

declare(strict_types=1);

namespace Igniter\System\Support;

use Igniter\Flame\Exception\ApplicationException;

class InstallationEnvironment
{
    public const string HEADER = 'X-TI-Installation-Url';

    public const string REPOSITORY_HOST = 'composer.tastyigniter.com';

    public static function resolveUrl(): string
    {
        $url = config('app.url');

        if (blank($url)) {
            throw new ApplicationException(
                lang('igniter::system.updates.error_missing_app_url'),
            );
        }

        return rtrim((string) $url, '/');
    }

    /**
     * @return string[]
     */
    public static function composerHeaderLines(?string $installationUrl = null): array
    {
        $installationUrl ??= self::resolveUrl();

        return [self::HEADER.': '.$installationUrl];
    }

    public static function resolveAuthorCode(?string $packageName = null): string
    {
        if ($packageName && str_contains($packageName, '/')) {
            return explode('/', strtolower($packageName))[0];
        }

        return 'tastyigniter';
    }
}
