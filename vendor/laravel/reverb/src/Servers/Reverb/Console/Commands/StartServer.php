<?php

namespace Laravel\Reverb\Servers\Reverb\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Laravel\Pulse\Pulse;
use Laravel\Reverb\Application;
use Laravel\Reverb\Contracts\ApplicationProvider;
use Laravel\Reverb\Contracts\Logger;
use Laravel\Reverb\Jobs\PingInactiveConnections;
use Laravel\Reverb\Jobs\PruneStaleConnections;
use Laravel\Reverb\Loggers\CliLogger;
use Laravel\Reverb\Protocols\Pusher\Contracts\ChannelManager;
use Laravel\Reverb\ServerProviderManager;
use Laravel\Reverb\Servers\Reverb\Contracts\PubSubProvider;
use Laravel\Reverb\Servers\Reverb\Factory as ServerFactory;
use Laravel\Reverb\Servers\Reverb\Http\Server;
use Laravel\Telescope\Contracts\EntriesRepository;
use Laravel\Telescope\Telescope;
use React\EventLoop\Loop;
use React\EventLoop\LoopInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\SignalableCommandInterface;

#[AsCommand(name: 'reverb:start')]
class StartServer extends Command implements SignalableCommandInterface
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reverb:start
                {--host= : The IP address the server should bind to}
                {--port= : The port the server should listen on}
                {--path= : The path the server should prefix to all routes}
                {--hostname= : The hostname the server is accessible from}
                {--debug : Indicates whether debug messages should be displayed in the terminal}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Start the Reverb server';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        if ($this->option('debug')) {
            $this->laravel->instance(Logger::class, new CliLogger($this->output));
        }

        $config = $this->laravel['config']['reverb.servers.reverb'];

        $loop = Loop::get();

        $server = ServerFactory::make(
            $host = $this->option('host') ?: $config['host'],
            $port = $this->option('port') ?: $config['port'],
            $path = $this->option('path') ?: $config['path'] ?? '',
            $hostname = $this->option('hostname') ?: $config['hostname'],
            $config['max_request_size'] ?? 10_000,
            $config['options'] ?? [],
            loop: $loop
        );

        $this->ensureHorizontalScalability($loop);
        $this->ensureStaleConnectionsAreCleaned($loop);
        $this->ensureRestartCommandIsRespected($server, $loop, $host, $port);
        $this->ensurePulseEventsAreCollected($loop, $config['pulse_ingest_interval']);
        $this->ensureTelescopeEntriesAreCollected($loop, $config['telescope_ingest_interval'] ?? 15);

        $this->components->info('Starting '.($server->isSecure() ? 'secure ' : '')."server on {$host}:{$port}{$path}".(($hostname && $hostname !== $host) ? " ({$hostname})" : ''));

        $server->start();
    }

    /**
     * Ensure that horizontal scalability via broadcasting is enabled if configured.
     */
    protected function ensureHorizontalScalability(LoopInterface $loop): void
    {
        if ($this->laravel->make(ServerProviderManager::class)->driver('reverb')->subscribesToEvents()) {
            $this->laravel->make(PubSubProvider::class)->connect($loop);
        }
    }

    /**
     * Use the event loop to schedule periodic cleanup of connections.
     */
    protected function ensureStaleConnectionsAreCleaned(LoopInterface $loop): void
    {
        $loop->addPeriodicTimer(60, function () {
            PruneStaleConnections::dispatch();
            PingInactiveConnections::dispatch();
        });
    }

    /**
     * Check to see whether the restart signal has been sent.
     */
    protected function ensureRestartCommandIsRespected(Server $server, LoopInterface $loop, string $host, string $port): void
    {
        $lastRestart = Cache::get('laravel:reverb:restart');

        $loop->addPeriodicTimer(5, function () use ($server, $host, $port, $lastRestart) {
            if ($lastRestart === Cache::get('laravel:reverb:restart')) {
                return;
            }

            $this->gracefullyDisconnect();

            $server->stop();

            $this->components->info("Stopping server on {$host}:{$port}");
        });
    }

    /**
     * Gracefully disconnect all connections.
     */
    protected function gracefullyDisconnect(): void
    {
        $this->laravel->make(ApplicationProvider::class)
            ->all()
            ->each(function (Application $application) {
                collect(
                    $this->laravel->make(ChannelManager::class)
                        ->for($application)
                        ->connections()
                )->each->disconnect();
            });
    }

    /**
     * Schedule Pulse to ingest events if enabled.
     */
    protected function ensurePulseEventsAreCollected(LoopInterface $loop, int $interval): void
    {
        if (! $this->laravel->bound(Pulse::class)) {
            return;
        }

        $loop->addPeriodicTimer($interval, function () {
            $this->laravel->make(Pulse::class)->ingest();
        });
    }

    /**
     * Schedule Telescope to store entries if enabled.
     */
    protected function ensureTelescopeEntriesAreCollected(LoopInterface $loop, int $interval): void
    {
        if (! $this->laravel->bound(EntriesRepository::class)) {
            return;
        }

        $loop->addPeriodicTimer($interval, function () {
            Telescope::store($this->laravel->make(EntriesRepository::class));
        });
    }

    /**
     * Get the list of signals handled by the command.
     */
    public function getSubscribedSignals(): array
    {
        if (! windows_os()) {
            return [SIGINT, SIGTERM, SIGTSTP];
        }

        $this->handleSignalWindows();

        return [];
    }

    /**
     * Handle the signals sent to the server.
     */
    public function handleSignal(int $signal = 0, int|false $previousExitCode = 0): int|false
    {
        $this->components->info('Gracefully terminating connections.');

        $this->gracefullyDisconnect();

        return $previousExitCode;
    }

    /**
     * Handle the signals sent to the server on Windows.
     */
    public function handleSignalWindows(): void
    {
        if (function_exists('sapi_windows_set_ctrl_handler')) {
            sapi_windows_set_ctrl_handler(fn () => exit($this->handleSignal()));
        }
    }
}
