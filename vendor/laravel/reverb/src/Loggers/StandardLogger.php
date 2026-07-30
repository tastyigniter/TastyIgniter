<?php

namespace Laravel\Reverb\Loggers;

use Illuminate\Support\Facades\Log;
use Laravel\Reverb\Contracts\Logger;

class StandardLogger implements Logger
{
    /**
     * Log an informational message
     */
    public function info(string $title, ?string $message = null): void
    {
        $output = $title;

        if ($message) {
            $output .= ': '.$message;
        }

        Log::info($output);
    }

    /**
     * Log an error message.
     */
    public function error(string $string): void
    {
        Log::error($string);
    }

    /**
     * Log a message sent to the server.
     */
    public function message(string $message): void
    {
        $message = json_decode($message, true);

        if (isset($message['data']['channel_data'])) {
            $message['data']['channel_data'] = json_decode($message['data']['channel_data'], true);
        }

        $message = json_encode($message, JSON_PRETTY_PRINT);

        Log::info($message);
    }

    /**
     * Append a new line to the log.
     */
    public function line(int $lines = 1): void
    {
        //
    }
}
