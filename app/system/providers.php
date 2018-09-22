<?php

return [

    // Laravel providers
    Illuminate\Broadcasting\BroadcastServiceProvider::class,
    Illuminate\Bus\BusServiceProvider::class,
    Illuminate\Cache\CacheServiceProvider::class,
    Illuminate\Cookie\CookieServiceProvider::class,
    Illuminate\Encryption\EncryptionServiceProvider::class,
    Illuminate\Foundation\Providers\FoundationServiceProvider::class,
    Illuminate\Hashing\HashServiceProvider::class,
    Illuminate\Pagination\PaginationServiceProvider::class,
    Illuminate\Pipeline\PipelineServiceProvider::class,
    Illuminate\Queue\QueueServiceProvider::class,
    Illuminate\Redis\RedisServiceProvider::class,
    Illuminate\Session\SessionServiceProvider::class,
    Illuminate\Validation\ValidationServiceProvider::class,
    Illuminate\View\ViewServiceProvider::class,

    // TastyIgniter flame providers
    Igniter\Flame\Foundation\Providers\ConsoleSupportServiceProvider::class,
    Igniter\Flame\Database\DatabaseServiceProvider::class,
    Igniter\Flame\Filesystem\FilesystemServiceProvider::class,
    Igniter\Flame\Flash\FlashServiceProvider::class,
    Igniter\Flame\Html\HtmlServiceProvider::class,
    Igniter\Flame\Mail\MailServiceProvider::class,
    Igniter\Flame\Notifications\NotificationServiceProvider::class,
//    Igniter\Flame\Html\UrlServiceProvider::class, // force https -- url policy
    Igniter\Flame\Scaffold\ScaffoldServiceProvider::class,
    Igniter\Flame\Setting\SettingServiceProvider::class,
];
