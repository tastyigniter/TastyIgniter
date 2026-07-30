<?php

namespace Laravel\Reverb;

class Certificate
{
    /**
     * Determine if the certificate exists.
     */
    public static function exists(string $url): bool
    {
        return static::resolve($url) !== null;
    }

    /**
     * Resolve the certificate and key for the given URL.
     *
     * @return array<int, string>|null
     */
    public static function resolve(string $url): ?array
    {
        $host = parse_url($url, PHP_URL_HOST) ?: $url;
        $certificate = $host.'.crt';
        $key = $host.'.key';

        foreach (static::paths() as $path) {
            if (file_exists($path.$certificate) && file_exists($path.$key)) {
                return [$path.$certificate, $path.$key];
            }
        }

        return null;
    }

    /**
     * Get the certificate paths.
     *
     * @return array<int, string>
     */
    public static function paths(): array
    {
        return [
            static::herdPath(),
            static::valetPath(),
        ];
    }

    /**
     * Get the Herd certificate path.
     */
    public static function herdPath(): string
    {
        if (PHP_OS_FAMILY === 'Windows') {
            return implode(DIRECTORY_SEPARATOR, [getenv('USERPROFILE') ?: $_SERVER['HOME'] ?? '', '.config', 'herd', 'config', 'valet', 'Certificates', '']);
        }

        return implode(DIRECTORY_SEPARATOR, [$_SERVER['HOME'] ?? '', 'Library', 'Application Support', 'Herd', 'config', 'valet', 'Certificates', '']);
    }

    /**
     * Get the Valet certificate path.
     */
    public static function valetPath(): string
    {
        return implode(DIRECTORY_SEPARATOR, [$_SERVER['HOME'] ?? '', '.config', 'valet', 'Certificates', '']);
    }
}
