<?php

declare(strict_types=1);

namespace Igniter\System\Health;

use Igniter\System\Health\Concerns\InteractsWithHttpProbes;
use Illuminate\Foundation\Application;
use Throwable;

class WebServerSecurityProbes
{
    use InteractsWithHttpProbes;

    /**
     * @return array<string, array{status: 'secured'|'vulnerable'|'unverified', summary: string}>
     */
    public function run(): array
    {
        return [
            'media_php' => $this->probeMediaPhp(),
            'storage_php' => $this->probeStoragePhp(),
            'env_exposure' => $this->probeEnvExposure(),
            'sensitive_files' => $this->probeSensitiveFiles(),
            'directory_listing' => $this->probeDirectoryListing(),
            'https' => $this->probeHttps(),
        ];
    }

    /**
     * @return array{status: 'secured'|'vulnerable'|'unverified', summary: string}
     */
    protected function probeMediaPhp(): array
    {
        return resolve(PhpExecutionProbe::class)->run('media', 'storage/media');
    }

    /**
     * @return array{status: 'secured'|'vulnerable'|'unverified', summary: string}
     */
    protected function probeStoragePhp(): array
    {
        return resolve(PhpExecutionProbe::class)->run('', 'storage');
    }

    /**
     * @return array{status: 'secured'|'vulnerable'|'unverified', summary: string}
     */
    protected function probeEnvExposure(): array
    {
        $baseUrl = $this->baseUrl();

        if ($baseUrl === null) {
            return $this->unverified(lang('igniter::system.system.checks.web_server_security_probe_url_missing'));
        }

        foreach (['/.env', '/../.env'] as $path) {
            $result = $this->probePathExposure(
                $baseUrl.$path,
                ['APP_KEY=', 'APP_ENV=', 'DB_PASSWORD='],
                lang('igniter::system.system.checks.web_server_security_env_exposed'),
                lang('igniter::system.system.checks.web_server_security_env_secured'),
            );

            if ($result['status'] !== 'secured') {
                return $result;
            }
        }

        return $this->secured(lang('igniter::system.system.checks.web_server_security_env_secured'));
    }

    /**
     * @return array{status: 'secured'|'vulnerable'|'unverified', summary: string}
     */
    protected function probeSensitiveFiles(): array
    {
        $baseUrl = $this->baseUrl();

        if ($baseUrl === null) {
            return $this->unverified(lang('igniter::system.system.checks.web_server_security_probe_url_missing'));
        }

        $targets = [
            '/composer.json' => ['"require"', '"name"'],
            '/artisan' => [Application::class, 'Artisan application'],
            '/.git/HEAD' => ['ref: refs/'],
        ];

        foreach ($targets as $path => $markers) {
            $result = $this->probePathExposure(
                $baseUrl.$path,
                $markers,
                lang('igniter::system.system.checks.web_server_security_sensitive_exposed', [
                    'path' => ltrim($path, '/'),
                ]),
                null,
            );

            if ($result['status'] === 'vulnerable') {
                return $this->vulnerable(lang('igniter::system.system.checks.web_server_security_sensitive_exposed', [
                    'path' => ltrim($path, '/'),
                ]));
            }

            if ($result['status'] === 'unverified') {
                return $result;
            }
        }

        return $this->secured(lang('igniter::system.system.checks.web_server_security_sensitive_secured'));
    }

    /**
     * @return array{status: 'secured'|'vulnerable'|'unverified', summary: string}
     */
    protected function probeDirectoryListing(): array
    {
        $baseUrl = $this->baseUrl();

        if ($baseUrl === null) {
            return $this->unverified(lang('igniter::system.system.checks.web_server_security_probe_url_missing'));
        }

        try {
            $response = $this->httpClient()->get($baseUrl.'/storage/media/');
            $body = $response->body();

            if ($this->bodyContainsAny(strtolower((string) $body), [
                'index of /',
                'index of ',
                'directory listing for',
                '<title>index of',
            ])) {
                return $this->vulnerable(lang('igniter::system.system.checks.web_server_security_directory_listing_enabled'));
            }

            return $this->secured(lang('igniter::system.system.checks.web_server_security_directory_listing_disabled'));
        } catch (Throwable) {
            return $this->unverified(lang('igniter::system.system.checks.web_server_security_probe_request_failed'));
        }
    }

    /**
     * @return array{status: 'secured'|'vulnerable'|'unverified', summary: string}
     */
    protected function probeHttps(): array
    {
        $baseUrl = $this->baseUrl();

        if ($baseUrl === null) {
            return $this->unverified(lang('igniter::system.system.checks.web_server_security_probe_url_missing'));
        }

        if (str_starts_with($baseUrl, 'https://')) {
            return $this->secured(lang('igniter::system.system.checks.web_server_security_https_enabled'));
        }

        if (app()->environment('production')) {
            return $this->vulnerable(lang('igniter::system.system.checks.web_server_security_https_disabled_production'));
        }

        return $this->unverified(lang('igniter::system.system.checks.web_server_security_https_disabled'));
    }

    /**
     * @param  string[]  $markers
     * @return array{status: 'secured'|'vulnerable'|'unverified', summary: string}
     */
    protected function probePathExposure(
        string $url,
        array $markers,
        string $exposedSummary,
        ?string $securedSummary,
    ): array {
        try {
            $response = $this->httpClient()->get($url);
            $body = $response->body();

            if ($this->responseBlocksAccess($response->status())) {
                return $this->secured($securedSummary ?? lang('igniter::system.system.checks.web_server_security_path_blocked', [
                    'code' => $response->status(),
                ]));
            }

            if ($this->bodyContainsAny($body, $markers)) {
                return $this->vulnerable($exposedSummary);
            }

            if ($response->successful()) {
                return $this->vulnerable($exposedSummary);
            }

            return $this->secured($securedSummary ?? lang('igniter::system.system.checks.web_server_security_path_blocked', [
                'code' => $response->status(),
            ]));
        } catch (Throwable) {
            return $this->unverified(lang('igniter::system.system.checks.web_server_security_probe_request_failed'));
        }
    }
}
