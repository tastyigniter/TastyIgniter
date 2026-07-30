<?php

declare(strict_types=1);

namespace Igniter\System\Database\Seeds;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Fill newly created permalink_slug column with values from permalinks table
 * Truncate the permalinks table
 */
class UpdateRecordsSeeder extends Seeder
{
    /**
     * Run the demo schema seeds.
     */
    public function run(): void
    {
        $this->updateDiskColumnOnMediaAttachments();

        $this->updateStatusForColumnOnStatusesTable();
    }

    protected function updateDiskColumnOnMediaAttachments()
    {
        DB::table('media_attachments')
            ->where('disk', 'media')
            ->update(['disk' => 'public']);
    }

    protected function updateStatusForColumnOnStatusesTable()
    {
        if (!DB::table('statuses')->where('status_for', 'reserve')->exists()) {
            return;
        }

        DB::table('statuses')
            ->where('status_for', 'reserve')
            ->update(['status_for' => 'reservation']);
    }
}
