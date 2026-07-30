<?php

namespace Laravel\Reverb\Servers\Reverb\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\InteractsWithTime;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'reverb:restart')]
class RestartServer extends Command
{
    use InteractsWithTime;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reverb:restart';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Restart the Reverb server';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        Cache::forever('laravel:reverb:restart', $this->currentTime());

        $this->components->info('Broadcasting Reverb restart signal.');
    }
}
