<?php

declare(strict_types=1);

namespace Igniter\System\Health\Checks;

use Igniter\Flame\Support\Facades\File;
use Igniter\System\Health\Check;
use Igniter\System\Health\Result;
use Override;

class DirectoryPermissionsCheck extends Check
{
    /** @var array<string, string> */
    protected array $paths = [
        'storage/app' => 'writable',
        'storage/framework' => 'writable',
        'storage/framework/cache/data' => 'writable',
        'storage/logs' => 'writable',
        'bootstrap/cache' => 'writable',
        'public/storage' => 'symlink',
        'public/vendor' => 'exists',
    ];

    public function label(): string
    {
        return lang('igniter::system.system.checks.directory_permissions');
    }

    #[Override]
    public function icon(): string
    {
        return 'fa fa-folder-open';
    }

    #[Override]
    public function sortOrder(): int
    {
        return 40;
    }

    public function run(): Result
    {
        $scan = $this->scanPaths();

        if ($scan['failed'] !== []) {
            return Result::fail(lang('igniter::system.system.checks.directory_permissions_failed', [
                'count' => count($scan['failed']),
            ]))
                ->meta($scan['meta'])
                ->actionMessage(lang('igniter::system.system.checks.directory_permissions_action'));
        }

        return Result::ok(lang('igniter::system.system.checks.directory_permissions_ok'))
            ->meta($scan['meta']);
    }

    /**
     * @return array{
     *     meta: array<string, array{value: string, status: string}|string>,
     *     failed: string[],
     * }
     */
    protected function scanPaths(): array
    {
        $meta = [];
        $failed = [];

        foreach ($this->paths as $path => $requirement) {
            $ok = $this->pathPasses($path, $requirement);

            $meta[$path] = $ok
                ? lang('igniter::system.system.checks.ok')
                : Result::metaValue(lang('igniter::system.system.checks.failed'), Result::STATUS_FAILED);

            if (!$ok) {
                $failed[] = $path;
            }
        }

        return [
            'meta' => $meta,
            'failed' => $failed,
        ];
    }

    protected function pathPasses(string $path, string $requirement): bool
    {
        $fullPath = base_path($path);

        return match ($requirement) {
            'symlink' => is_link($fullPath) || File::exists($fullPath),
            'writable' => File::isDirectory($fullPath) && is_writable($fullPath),
            'exists' => File::exists($fullPath),
            default => false,
        };
    }
}
