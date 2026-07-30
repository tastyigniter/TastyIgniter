<?php

declare(strict_types=1);

namespace Igniter\System\Health\Checks;

use Igniter\System\Health\Check;
use Igniter\System\Health\Result;
use Igniter\System\Helpers\CacheUsage;
use Override;

class CacheUsageCheck extends Check
{
    public function label(): string
    {
        return lang('igniter::system.system.checks.cache_usage');
    }

    #[Override]
    public function icon(): string
    {
        return 'fa fa-database';
    }

    #[Override]
    public function sortOrder(): int
    {
        return 110;
    }

    public function run(): Result
    {
        $usage = CacheUsage::sizes();
        $meta = $this->meta($usage);

        if ($this->isHighUsage($usage)) {
            return $this->highUsageResult($usage, $meta);
        }

        return Result::ok(lang('igniter::system.system.checks.cache_usage_ok', [
            'size' => $usage['formattedTotalCacheSize'],
        ]))->meta($meta);
    }

    /**
     * @param  array{
     *     cacheSizes: mixed,
     *     totalCacheSize: int|float,
     *     formattedTotalCacheSize: string,
     * }  $usage
     * @return array<string, mixed>
     */
    protected function meta(array $usage): array
    {
        return [
            'cacheSizes' => $usage['cacheSizes'],
            'totalCacheSize' => $usage['totalCacheSize'],
            'formattedTotalCacheSize' => $usage['formattedTotalCacheSize'],
        ];
    }

    /**
     * @param  array{totalCacheSize: int|float}  $usage
     */
    protected function isHighUsage(array $usage): bool
    {
        return $usage['totalCacheSize'] >= CacheUsage::WARN_BYTES;
    }

    /**
     * @param  array{formattedTotalCacheSize: string}  $usage
     * @param  array<string, mixed>  $meta
     */
    protected function highUsageResult(array $usage, array $meta): Result
    {
        return Result::warning(lang('igniter::system.system.checks.cache_usage_high', [
            'size' => $usage['formattedTotalCacheSize'],
        ]))
            ->meta($meta)
            ->actionMessage(lang('igniter::system.system.checks.cache_usage_action'));
    }
}
