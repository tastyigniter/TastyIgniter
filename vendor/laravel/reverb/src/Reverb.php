<?php

namespace Laravel\Reverb;

use Illuminate\Foundation\DevCommands;

class Reverb
{
    /**
     * Register the Reverb dev commands.
     */
    public static function registerDevCommands(): void
    {
        if (class_exists(DevCommands::class)) {
            DevCommands::artisan('reverb:start', 'reverb');
        }
    }
}
