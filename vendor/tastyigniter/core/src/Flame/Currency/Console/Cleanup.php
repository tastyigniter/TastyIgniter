<?php

declare(strict_types=1);

namespace Igniter\Flame\Currency\Console;

use Igniter\Flame\Currency\Facades\Currency;
use Illuminate\Console\Command;

class Cleanup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'currency:cleanup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cleanup currency cache';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        // Clear cache
        Currency::clearCache();
        $this->comment('Currency cache cleaned.');

        // Force the system to rebuild cache
        Currency::getCurrencies();
        $this->comment('Currency cache rebuilt.');
    }
}
