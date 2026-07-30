<?php

declare(strict_types=1);

namespace Igniter\Automation\Tests\Console;

use Igniter\Automation\Models\AutomationLog;

it('deletes old records from the automation log', function(): void {
    $this->travelTo(now()->subMonths(6));
    AutomationLog::create();
    AutomationLog::create();
    AutomationLog::create();
    AutomationLog::create();
    AutomationLog::create();
    $this->travelBack();

    $this->artisan('automation:cleanup')
        ->expectsOutput('Cleaning old automation log...')
        ->expectsOutput('Deleted 5 record(s) from the automation log.')
        ->expectsOutput('All done!')
        ->assertExitCode(0);
});

it('handles no records to delete', function(): void {
    $this->artisan('automation:cleanup')
        ->expectsOutput('Cleaning old automation log...')
        ->expectsOutput('Deleted 0 record(s) from the automation log.')
        ->expectsOutput('All done!')
        ->assertExitCode(0);
});
