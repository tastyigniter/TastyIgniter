<?php

declare(strict_types=1);

namespace Igniter\System\Health\Checks;

use Igniter\Flame\Support\Facades\Igniter;
use Igniter\System\Health\Check;
use Igniter\System\Health\Result;
use Illuminate\Support\Facades\DB;
use Override;
use Throwable;

class ApplicationCheck extends Check
{
    public function label(): string
    {
        return lang('igniter::system.system.checks.application');
    }

    #[Override]
    public function icon(): string
    {
        return 'fa fa-tag';
    }

    #[Override]
    public function sortOrder(): int
    {
        return 10;
    }

    public function run(): Result
    {
        $context = $this->context();
        $meta = $this->meta($context);
        $issues = $this->issues($context, $meta);

        if ($issues === []) {
            return Result::ok($context['version'])->meta($meta);
        }

        return $this->resultFromIssues($issues, $meta, $context['version']);
    }

    /**
     * @return array{
     *     version: string,
     *     debugEnabled: bool,
     *     queue: string,
     *     databaseDriver: string,
     *     sessionDriver: string,
     *     cacheDriver: string,
     *     mailDriver: string,
     *     appTimezone: string,
     *     appDatetime: string,
     * }
     */
    protected function context(): array
    {
        $databaseConnection = (string) config('database.default');
        $appTimezone = date_default_timezone_get();

        return [
            'version' => Igniter::version(),
            'debugEnabled' => (bool) config('app.debug'),
            'queue' => (string) config('queue.default'),
            'databaseDriver' => (string) config('database.connections.'.$databaseConnection.'.driver'),
            'sessionDriver' => (string) config('session.driver'),
            'cacheDriver' => (string) config('cache.default'),
            'mailDriver' => (string) config('mail.default'),
            'appTimezone' => $appTimezone,
            'appDatetime' => now()->timezone($appTimezone)->format('Y-m-d H:i:s T'),
        ];
    }

    /**
     * @param  array{
     *     version: string,
     *     debugEnabled: bool,
     *     queue: string,
     *     databaseDriver: string,
     *     sessionDriver: string,
     *     cacheDriver: string,
     *     mailDriver: string,
     *     appTimezone: string,
     *     appDatetime: string,
     * }  $context
     * @return array<string, array{value: string, status: string}|string>
     */
    protected function meta(array $context): array
    {
        return [
            lang('igniter::system.system.checks.version') => $context['version'],
            lang('igniter::system.system.checks.database') => Result::metaValue(
                lang('igniter::system.system.checks.database_ok'),
            ),
            lang('igniter::system.system.checks.database_driver') => $context['databaseDriver'],
            lang('igniter::system.system.checks.debug_mode') => Result::metaValue(
                $context['debugEnabled']
                    ? lang('igniter::system.system.checks.enabled')
                    : lang('igniter::system.system.checks.disabled'),
                $this->debugModeStatus($context['debugEnabled']),
            ),
            lang('igniter::system.system.checks.queue_driver') => Result::metaValue(
                $context['queue'],
                $context['queue'] === 'sync' ? Result::STATUS_WARNING : null,
            ),
            lang('igniter::system.system.checks.session_driver') => $context['sessionDriver'],
            lang('igniter::system.system.checks.cache_driver') => $context['cacheDriver'],
            lang('igniter::system.system.checks.mail_driver') => $context['mailDriver'],
            lang('igniter::system.system.checks.app_timezone') => $context['appTimezone'],
            lang('igniter::system.system.checks.app_datetime') => $context['appDatetime'],
        ];
    }

    /**
     * @param  array{
     *     version: string,
     *     debugEnabled: bool,
     *     queue: string,
     *     databaseDriver: string,
     *     sessionDriver: string,
     *     cacheDriver: string,
     *     mailDriver: string,
     *     appTimezone: string,
     *     appDatetime: string,
     * }  $context
     * @param  array<string, array{value: string, status: string}|string>  $meta
     * @return array<int, array{status: string, summary: string, action: string, actionUrl?: string, actionUrlLabel?: string}>
     */
    protected function issues(array $context, array &$meta): array
    {
        return array_values(array_filter([
            $this->databaseIssue($meta),
            $this->debugModeIssue($context['debugEnabled']),
            $this->queueDriverIssue($context['queue']),
        ]));
    }

    protected function debugModeStatus(bool $debugEnabled): ?string
    {
        if (!$debugEnabled) {
            return null;
        }

        return app()->environment('production')
            ? Result::STATUS_FAILED
            : Result::STATUS_WARNING;
    }

    /**
     * @param  array<string, array{value: string, status: string}|string>  $meta
     * @return array{status: string, summary: string, action: string}|null
     */
    protected function databaseIssue(array &$meta): ?array
    {
        try {
            DB::connection()->getPdo();

            return null;
        } catch (Throwable) {
            $meta[lang('igniter::system.system.checks.database')] = Result::metaValue(
                lang('igniter::system.system.checks.database_failed'),
                Result::STATUS_FAILED,
            );

            return [
                'status' => Result::STATUS_FAILED,
                'summary' => lang('igniter::system.system.checks.database_failed'),
                'action' => lang('igniter::system.system.checks.database_action'),
            ];
        }
    }

    /**
     * @return array{status: string, summary: string, action: string}|null
     */
    protected function debugModeIssue(bool $debugEnabled): ?array
    {
        if (!$debugEnabled) {
            return null;
        }

        if (app()->environment('production')) {
            return [
                'status' => Result::STATUS_FAILED,
                'summary' => lang('igniter::system.system.checks.debug_mode_enabled'),
                'action' => lang('igniter::system.system.checks.debug_mode_action'),
            ];
        }

        return [
            'status' => Result::STATUS_WARNING,
            'summary' => lang('igniter::system.system.checks.debug_mode_on'),
            'action' => lang('igniter::system.system.checks.debug_mode_action'),
        ];
    }

    /**
     * @return array{status: string, summary: string, action: string, actionUrl: string, actionUrlLabel: string}|null
     */
    protected function queueDriverIssue(string $queue): ?array
    {
        if ($queue !== 'sync') {
            return null;
        }

        return [
            'status' => Result::STATUS_WARNING,
            'summary' => lang('igniter::system.system.checks.queue_driver_sync'),
            'action' => lang('igniter::system.system.checks.queue_driver_action'),
            'actionUrl' => 'https://tastyigniter.com/docs/installation#setting-up-the-queue-daemon',
            'actionUrlLabel' => lang('igniter::system.system.checks.view_docs'),
        ];
    }
}
