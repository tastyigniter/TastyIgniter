<?php

declare(strict_types=1);

namespace Igniter\System\Health\Checks;

use Igniter\System\Health\Check;
use Igniter\System\Health\Result;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Override;

class BackgroundTasksCheck extends Check
{
    public const string SCHEDULE_HEARTBEAT_KEY = 'system.schedule_heartbeat';

    public const string QUEUE_HEARTBEAT_KEY = 'system.queue_heartbeat';

    public const int SCHEDULE_HEARTBEAT_STALE_MINUTES = 2;

    public const int QUEUE_HEARTBEAT_STALE_MINUTES = 5;

    public function label(): string
    {
        return lang('igniter::system.system.checks.background_tasks');
    }

    #[Override]
    public function icon(): string
    {
        return 'fa fa-clock';
    }

    #[Override]
    public function sortOrder(): int
    {
        return 60;
    }

    public function run(): Result
    {
        $context = $this->context();
        $meta = $this->meta($context);
        $issues = $this->issues($context);
        $okSummary = lang('igniter::system.system.checks.background_tasks_ok');

        if ($issues === []) {
            return Result::ok($okSummary)->meta($meta);
        }

        return $this->resultFromIssues($issues, $meta, $okSummary);
    }

    /**
     * @return array{
     *     scheduleHeartbeat: mixed,
     *     queueDriver: string,
     *     queueHeartbeat: mixed,
     *     failedJobs: int,
     *     scheduleAgeMinutes: ?float,
     *     queueAgeMinutes: ?float,
     * }
     */
    protected function context(): array
    {
        $scheduleHeartbeat = Cache::get(self::SCHEDULE_HEARTBEAT_KEY);
        $queueHeartbeat = Cache::get(self::QUEUE_HEARTBEAT_KEY);

        return [
            'scheduleHeartbeat' => $scheduleHeartbeat,
            'queueDriver' => (string) config('queue.default'),
            'queueHeartbeat' => $queueHeartbeat,
            'failedJobs' => Schema::hasTable('failed_jobs')
                ? (int) DB::table('failed_jobs')->count()
                : 0,
            'scheduleAgeMinutes' => blank($scheduleHeartbeat)
                ? null
                : Carbon::parse($scheduleHeartbeat)->diffInMinutes(now()),
            'queueAgeMinutes' => blank($queueHeartbeat)
                ? null
                : Carbon::parse($queueHeartbeat)->diffInMinutes(now()),
        ];
    }

    /**
     * @param  array{
     *     scheduleHeartbeat: mixed,
     *     queueDriver: string,
     *     queueHeartbeat: mixed,
     *     failedJobs: int,
     *     scheduleAgeMinutes: ?int,
     *     queueAgeMinutes: ?int,
     * }  $context
     * @return array<string, array{value: string, status: string}|string>
     */
    protected function meta(array $context): array
    {
        return [
            lang('igniter::system.system.checks.schedule_last_run') => Result::metaValue(
                blank($context['scheduleHeartbeat'])
                    ? lang('igniter::system.system.checks.never')
                    : Carbon::parse($context['scheduleHeartbeat'])->toDateTimeString(),
                $this->scheduleStatus($context),
            ),
            lang('igniter::system.system.checks.queue_driver') => $context['queueDriver'],
            lang('igniter::system.system.checks.queue_last_run') => Result::metaValue(
                $context['queueDriver'] === 'sync'
                    ? lang('igniter::system.system.checks.not_applicable')
                    : (blank($context['queueHeartbeat'])
                        ? lang('igniter::system.system.checks.never')
                        : Carbon::parse($context['queueHeartbeat'])->toDateTimeString()),
                $this->queueStatus($context),
            ),
            lang('igniter::system.system.checks.failed_jobs') => Result::metaValue(
                $context['queueDriver'] === 'sync'
                    ? lang('igniter::system.system.checks.not_applicable')
                    : (string) $context['failedJobs'],
                ($context['queueDriver'] !== 'sync' && $context['failedJobs'] > 0)
                    ? Result::STATUS_WARNING
                    : null,
            ),
        ];
    }

    /**
     * @param  array{
     *     scheduleHeartbeat: mixed,
     *     queueDriver: string,
     *     queueHeartbeat: mixed,
     *     failedJobs: int,
     *     scheduleAgeMinutes: ?int,
     *     queueAgeMinutes: ?int,
     * }  $context
     * @return array<int, array{status: string, summary: string, action: string, actionUrl?: string, actionUrlLabel?: string}>
     */
    protected function issues(array $context): array
    {
        return array_values(array_filter([
            $this->scheduleIssue($context),
            $this->queueIssue($context),
        ]));
    }

    /**
     * @param  array{
     *     scheduleHeartbeat: mixed,
     *     queueDriver: string,
     *     queueHeartbeat: mixed,
     *     failedJobs: int,
     *     scheduleAgeMinutes: ?int,
     *     queueAgeMinutes: ?int,
     * }  $context
     */
    protected function scheduleStatus(array $context): ?string
    {
        if (blank($context['scheduleHeartbeat'])) {
            return Result::STATUS_FAILED;
        }

        if (($context['scheduleAgeMinutes'] ?? 0) > self::SCHEDULE_HEARTBEAT_STALE_MINUTES) {
            return Result::STATUS_FAILED;
        }

        return null;
    }

    /**
     * @param  array{
     *     scheduleHeartbeat: mixed,
     *     queueDriver: string,
     *     queueHeartbeat: mixed,
     *     failedJobs: int,
     *     scheduleAgeMinutes: ?int,
     *     queueAgeMinutes: ?int,
     * }  $context
     */
    protected function queueStatus(array $context): ?string
    {
        if ($context['queueDriver'] === 'sync') {
            return null;
        }

        if (blank($context['queueHeartbeat'])) {
            return Result::STATUS_WARNING;
        }

        if (($context['queueAgeMinutes'] ?? 0) > self::QUEUE_HEARTBEAT_STALE_MINUTES) {
            return Result::STATUS_WARNING;
        }

        return null;
    }

    /**
     * @param  array{
     *     scheduleHeartbeat: mixed,
     *     queueDriver: string,
     *     queueHeartbeat: mixed,
     *     failedJobs: int,
     *     scheduleAgeMinutes: ?int,
     *     queueAgeMinutes: ?int,
     * }  $context
     * @return array{status: string, summary: string, action: string, actionUrl: string, actionUrlLabel: string}|null
     */
    protected function scheduleIssue(array $context): ?array
    {
        if (blank($context['scheduleHeartbeat'])) {
            return $this->scheduleIssuePayload(lang('igniter::system.system.checks.schedule_failed'));
        }

        if (($context['scheduleAgeMinutes'] ?? 0) > self::SCHEDULE_HEARTBEAT_STALE_MINUTES) {
            return $this->scheduleIssuePayload(lang('igniter::system.system.checks.schedule_stale', [
                'minutes' => $context['scheduleAgeMinutes'],
            ]));
        }

        return null;
    }

    /**
     * @param  array{
     *     scheduleHeartbeat: mixed,
     *     queueDriver: string,
     *     queueHeartbeat: mixed,
     *     failedJobs: int,
     *     scheduleAgeMinutes: ?int,
     *     queueAgeMinutes: ?int,
     * }  $context
     * @return array{status: string, summary: string, action: string, actionUrl?: string, actionUrlLabel?: string}|null
     */
    protected function queueIssue(array $context): ?array
    {
        if ($context['queueDriver'] === 'sync') {
            return null;
        }

        if (blank($context['queueHeartbeat'])) {
            return $this->queueIssuePayload(lang('igniter::system.system.checks.queue_worker_not_detected'));
        }

        if (($context['queueAgeMinutes'] ?? 0) > self::QUEUE_HEARTBEAT_STALE_MINUTES) {
            return $this->queueIssuePayload(lang('igniter::system.system.checks.queue_worker_stale', [
                'minutes' => $context['queueAgeMinutes'],
            ]));
        }

        if ($context['failedJobs'] > 0) {
            return [
                'status' => Result::STATUS_WARNING,
                'summary' => lang('igniter::system.system.checks.queue_worker_failed_jobs', [
                    'count' => $context['failedJobs'],
                ]),
                'action' => lang('igniter::system.system.checks.queue_worker_failed_action'),
            ];
        }

        return null;
    }

    /**
     * @return array{status: string, summary: string, action: string, actionUrl: string, actionUrlLabel: string}
     */
    protected function scheduleIssuePayload(string $summary): array
    {
        return [
            'status' => Result::STATUS_FAILED,
            'summary' => $summary,
            'action' => lang('igniter::system.system.checks.schedule_action'),
            'actionUrl' => 'https://tastyigniter.com/docs/installation#setting-up-the-task-scheduler',
            'actionUrlLabel' => lang('igniter::system.system.checks.view_docs'),
        ];
    }

    /**
     * @return array{status: string, summary: string, action: string, actionUrl: string, actionUrlLabel: string}
     */
    protected function queueIssuePayload(string $summary): array
    {
        return [
            'status' => Result::STATUS_WARNING,
            'summary' => $summary,
            'action' => lang('igniter::system.system.checks.queue_worker_action'),
            'actionUrl' => 'https://tastyigniter.com/docs/installation#setting-up-the-queue-daemon',
            'actionUrlLabel' => lang('igniter::system.system.checks.view_docs'),
        ];
    }
}
