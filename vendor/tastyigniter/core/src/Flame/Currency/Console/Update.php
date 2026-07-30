<?php

declare(strict_types=1);

namespace Igniter\Flame\Currency\Console;

use Igniter\Flame\Currency\Facades\Currency;
use Illuminate\Console\Command;

class Update extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'currency:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update exchange rates from an online source';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        Currency::updateRates(true);
    }
}
