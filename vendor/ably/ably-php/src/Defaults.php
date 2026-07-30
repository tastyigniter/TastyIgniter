<?php
namespace Ably;

class Defaults {
    const API_VERSION = '2';
    const LIB_VERSION = '1.1.12';

    static $restHost = "rest.ably.io";
    static $realtimeHost = "realtime.ably.io";
    static $port = 80;
    static $tlsPort = 443;

    static $internetCheckUrl = "https://internet-up.ably-realtime.com/is-the-internet-up.txt";
    static $internetCheckOk = "yes\n";

    static $fallbackHosts = [
        'a.ably-realtime.com',
        'b.ably-realtime.com',
        'c.ably-realtime.com',
        'd.ably-realtime.com',
        'e.ably-realtime.com',
    ];

    static function getEnvironmentFallbackHosts($environment) {
        return [
            $environment."-a-fallback.ably-realtime.com",
            $environment."-b-fallback.ably-realtime.com",
            $environment."-c-fallback.ably-realtime.com",
            $environment."-d-fallback.ably-realtime.com",
            $environment."-e-fallback.ably-realtime.com"
        ];
    }
}
