<?php

declare(strict_types=1);

namespace Igniter\System\Health\Checks;

use Facades\Igniter\System\Helpers\SystemHelper;
use Igniter\System\Health\Check;
use Igniter\System\Health\Result;
use Illuminate\Support\Number;
use Override;
use Symfony\Component\Process\Process;

class PhpCheck extends Check
{
    protected const int MEMORY_MINIMUM_BYTES = 256 * 1024 * 1024;

    protected static ?array $cliData = null;

    public function label(): string
    {
        return lang('igniter::system.system.checks.php');
    }

    #[Override]
    public function icon(): string
    {
        return 'fa fa-code';
    }

    #[Override]
    public function sortOrder(): int
    {
        return 20;
    }

    public function run(): Result
    {
        $context = $this->context();
        $meta = $this->meta($context);
        $issues = $this->issues($context);
        $okSummary = lang('igniter::system.system.checks.php_ok');

        if ($issues === []) {
            return Result::ok($okSummary)->meta($meta);
        }

        return $this->resultFromIssues($issues, $meta, $okSummary);
    }

    /**
     * @return array{
     *     cli: array{version: ?string, ini: array<string, string>},
     *     cliVersion: string,
     *     server: string,
     *     webBytes: int|float,
     *     cliBytes: ?int,
     *     required: string[],
     *     missing: string[],
     *     webLow: bool,
     *     cliLow: bool,
     *     exposePhpEnabled: bool,
     *     displayErrorsEnabled: bool,
     *     allowUrlIncludeEnabled: bool,
     * }
     */
    protected function context(): array
    {
        $cli = $this->cliData();
        $webBytes = SystemHelper::phpIniValueInBytes('memory_limit');
        $cliBytes = $this->cliIniBytes('memory_limit');
        $required = $this->requiredExtensions();
        $missing = array_values(array_filter($required, fn(string $ext): bool => !extension_loaded($ext)));

        return [
            'cli' => $cli,
            'cliVersion' => $cli['version'] ?? lang('igniter::system.system.checks.unavailable'),
            'server' => $_SERVER['SERVER_SOFTWARE'] ?? lang('igniter::system.system.checks.unknown'),
            'webBytes' => $webBytes,
            'cliBytes' => $cliBytes,
            'required' => $required,
            'missing' => $missing,
            'webLow' => $webBytes !== -1 && $webBytes < self::MEMORY_MINIMUM_BYTES,
            'cliLow' => $cliBytes !== null && $cliBytes !== -1 && $cliBytes < self::MEMORY_MINIMUM_BYTES,
            'exposePhpEnabled' => $this->iniIsEnabled('expose_php'),
            'displayErrorsEnabled' => $this->iniIsEnabled('display_errors'),
            'allowUrlIncludeEnabled' => $this->iniIsEnabled('allow_url_include'),
        ];
    }

    /**
     * @param  array{
     *     cli: array{version: ?string, ini: array<string, string>},
     *     cliVersion: string,
     *     server: string,
     *     webBytes: int|float,
     *     cliBytes: ?int,
     *     required: string[],
     *     missing: string[],
     *     webLow: bool,
     *     cliLow: bool,
     *     exposePhpEnabled: bool,
     *     displayErrorsEnabled: bool,
     *     allowUrlIncludeEnabled: bool,
     * }  $context
     * @return array<string, array{value: string, status: string}|string>
     */
    protected function meta(array $context): array
    {
        return [
            lang('igniter::system.system.checks.web_server') => $context['server'],
            lang('igniter::system.system.checks.php_web') => PHP_VERSION,
            lang('igniter::system.system.checks.php_cli') => Result::metaValue(
                $context['cliVersion'],
                blank($context['cli']['version']) ? Result::STATUS_WARNING : null,
            ),
            lang('igniter::system.system.checks.memory_web') => Result::metaValue(
                $this->formatBytes($context['webBytes']),
                $context['webLow'] ? Result::STATUS_WARNING : null,
            ),
            lang('igniter::system.system.checks.memory_cli') => Result::metaValue(
                $context['cliBytes'] === null
                    ? lang('igniter::system.system.checks.unavailable')
                    : $this->formatBytes($context['cliBytes']),
                $context['cliLow'] ? Result::STATUS_WARNING : null,
            ),
            lang('igniter::system.system.checks.expose_php') => Result::metaValue(
                $this->formatIniSetting($context['exposePhpEnabled']),
                $this->exposePhpStatus($context['exposePhpEnabled']),
            ),
            lang('igniter::system.system.checks.display_errors') => Result::metaValue(
                $this->formatIniSetting($context['displayErrorsEnabled']),
                $this->displayErrorsStatus($context['displayErrorsEnabled']),
            ),
            lang('igniter::system.system.checks.allow_url_include') => Result::metaValue(
                $this->formatIniSetting($context['allowUrlIncludeEnabled']),
                $context['allowUrlIncludeEnabled'] ? Result::STATUS_FAILED : null,
            ),
            lang('igniter::system.system.checks.required') => implode(', ', $context['required']),
            lang('igniter::system.system.checks.missing') => Result::metaValue(
                $context['missing'] === []
                    ? lang('igniter::system.system.checks.none')
                    : implode(', ', $context['missing']),
                $context['missing'] !== [] ? Result::STATUS_FAILED : null,
            ),
        ];
    }

    /**
     * @param  array{
     *     cli: array{version: ?string, ini: array<string, string>},
     *     cliVersion: string,
     *     server: string,
     *     webBytes: int|float,
     *     cliBytes: ?int,
     *     required: string[],
     *     missing: string[],
     *     webLow: bool,
     *     cliLow: bool,
     *     exposePhpEnabled: bool,
     *     displayErrorsEnabled: bool,
     *     allowUrlIncludeEnabled: bool,
     * }  $context
     * @return array<int, array{status: string, summary: string, action: string, actionUrl?: string, actionUrlLabel?: string}>
     */
    protected function issues(array $context): array
    {
        return array_values(array_filter([
            $this->extensionsIssue($context['missing']),
            $this->cliIssue($context['cli']),
            $this->memoryIssue($context['webLow'], $context['cliLow']),
            $this->allowUrlIncludeIssue($context['allowUrlIncludeEnabled']),
            $this->exposePhpIssue($context['exposePhpEnabled']),
            $this->displayErrorsIssue($context['displayErrorsEnabled']),
        ]));
    }

    /**
     * @param  string[]  $missing
     * @return array{status: string, summary: string, action: string}|null
     */
    protected function extensionsIssue(array $missing): ?array
    {
        if ($missing === []) {
            return null;
        }

        return [
            'status' => Result::STATUS_FAILED,
            'summary' => lang('igniter::system.system.checks.php_extensions_failed'),
            'action' => lang('igniter::system.system.checks.php_extensions_action', [
                'extensions' => implode(', ', $missing),
            ]),
        ];
    }

    /**
     * @param  array{version: ?string, ini: array<string, string>}  $cli
     * @return array{status: string, summary: string, action: string}|null
     */
    protected function cliIssue(array $cli): ?array
    {
        if (!blank($cli['version'])) {
            return null;
        }

        return [
            'status' => Result::STATUS_WARNING,
            'summary' => lang('igniter::system.system.checks.php_cli_unavailable'),
            'action' => lang('igniter::system.system.checks.php_cli_action'),
        ];
    }

    /**
     * @return array{status: string, summary: string, action: string, actionUrl: string, actionUrlLabel: string}|null
     */
    protected function memoryIssue(bool $webLow, bool $cliLow): ?array
    {
        if (!$webLow && !$cliLow) {
            return null;
        }

        return [
            'status' => Result::STATUS_WARNING,
            'summary' => lang('igniter::system.system.checks.php_memory_low'),
            'action' => lang('igniter::system.system.checks.php_memory_action'),
            'actionUrl' => 'https://tastyigniter.com/support/articles/php-ini',
            'actionUrlLabel' => lang('igniter::system.system.checks.view_docs'),
        ];
    }

    /**
     * @return string[]
     */
    protected function requiredExtensions(): array
    {
        return [
            'bcmath', 'ctype', 'dom', 'fileinfo', 'exif', 'gd', 'intl',
            'json', 'zip', 'mbstring', 'openssl', 'tokenizer', 'xml',
        ];
    }

    /**
     * @return array{version: ?string, ini: array<string, string>}
     */
    protected function cliData(): array
    {
        if (static::$cliData !== null) {
            return static::$cliData;
        }

        static::$cliData = ['version' => null, 'ini' => []];

        $process = Process::fromShellCommandline('php -r "echo PHP_VERSION.\'|\' . ini_get(\'memory_limit\');"');
        $process->setTimeout(5);
        $process->run();

        if (!$process->isSuccessful()) {
            return static::$cliData;
        }

        [$version, $memory] = array_pad(explode('|', trim($process->getOutput()), 2), 2, '');
        static::$cliData = [
            'version' => $version ?: null,
            'ini' => ['memory_limit' => $memory],
        ];

        return static::$cliData;
    }

    protected function cliIniBytes(string $key): ?int
    {
        $value = $this->cliData()['ini'][$key] ?? null;
        if ($value === null || $value === '') {
            return null;
        }

        return (int) SystemHelper::phpSizeInBytes($value);
    }

    protected function formatBytes(float|int $bytes): string
    {
        if ($bytes === -1) {
            return lang('igniter::system.system.checks.unlimited');
        }

        return Number::fileSize((int) $bytes);
    }

    protected function iniIsEnabled(string $key): bool
    {
        $value = strtolower(trim((string) ini_get($key)));

        return in_array($value, ['1', 'on', 'true', 'yes'], true);
    }

    protected function formatIniSetting(bool $enabled): string
    {
        return $enabled
            ? lang('igniter::system.system.checks.enabled')
            : lang('igniter::system.system.checks.disabled');
    }

    protected function exposePhpStatus(bool $enabled): ?string
    {
        if (!$enabled) {
            return null;
        }

        return app()->environment('production')
            ? Result::STATUS_FAILED
            : Result::STATUS_WARNING;
    }

    protected function displayErrorsStatus(bool $enabled): ?string
    {
        if (!$enabled) {
            return null;
        }

        return app()->environment('production')
            ? Result::STATUS_FAILED
            : Result::STATUS_WARNING;
    }

    /**
     * @return array{status: string, summary: string, action: string, actionUrl: string, actionUrlLabel: string}|null
     */
    protected function allowUrlIncludeIssue(bool $enabled): ?array
    {
        if (!$enabled) {
            return null;
        }

        return [
            'status' => Result::STATUS_FAILED,
            'summary' => lang('igniter::system.system.checks.allow_url_include_enabled'),
            'action' => lang('igniter::system.system.checks.allow_url_include_action'),
            'actionUrl' => 'https://tastyigniter.com/support/articles/php-ini',
            'actionUrlLabel' => lang('igniter::system.system.checks.view_docs'),
        ];
    }

    /**
     * @return array{status: string, summary: string, action: string, actionUrl: string, actionUrlLabel: string}|null
     */
    protected function exposePhpIssue(bool $enabled): ?array
    {
        if (!$enabled) {
            return null;
        }

        return [
            'status' => app()->environment('production') ? Result::STATUS_FAILED : Result::STATUS_WARNING,
            'summary' => lang('igniter::system.system.checks.expose_php_enabled'),
            'action' => lang('igniter::system.system.checks.expose_php_action'),
            'actionUrl' => 'https://tastyigniter.com/support/articles/php-ini',
            'actionUrlLabel' => lang('igniter::system.system.checks.view_docs'),
        ];
    }

    /**
     * @return array{status: string, summary: string, action: string, actionUrl: string, actionUrlLabel: string}|null
     */
    protected function displayErrorsIssue(bool $enabled): ?array
    {
        if (!$enabled) {
            return null;
        }

        return [
            'status' => app()->environment('production') ? Result::STATUS_FAILED : Result::STATUS_WARNING,
            'summary' => lang('igniter::system.system.checks.display_errors_enabled'),
            'action' => lang('igniter::system.system.checks.display_errors_action'),
            'actionUrl' => 'https://tastyigniter.com/support/articles/php-ini',
            'actionUrlLabel' => lang('igniter::system.system.checks.view_docs'),
        ];
    }
}
