<?php

declare(strict_types=1);

namespace Igniter\System\Health;

abstract class Check
{
    public static function new(): static
    {
        return app(static::class);
    }

    abstract public function run(): Result;

    abstract public function label(): string;

    public function name(): string
    {
        return class_basename(static::class);
    }

    public function icon(): string
    {
        return 'fa fa-circle-info';
    }

    public function sortOrder(): int
    {
        return 999;
    }

    /**
     * @param  array<int, array{status: string, summary: string, action: string, actionUrl?: string, actionUrlLabel?: string}>  $issues
     */
    protected function resultFromIssues(array $issues, array $meta, string $okSummary): Result
    {
        if ($issues === []) {
            return Result::ok($okSummary)->meta($meta);
        }

        $worst = collect($issues)->sortByDesc(fn(array $issue): int => match ($issue['status']) {
            Result::STATUS_FAILED => 2,
            Result::STATUS_WARNING => 1,
            default => 0,
        })->first();

        $result = match ($worst['status']) {
            Result::STATUS_FAILED => Result::fail($worst['summary']),
            default => Result::warning($worst['summary']),
        };

        return $result->meta($meta)->issues($issues);
    }
}
