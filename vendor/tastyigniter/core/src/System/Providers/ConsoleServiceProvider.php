<?php

declare(strict_types=1);

namespace Igniter\System\Providers;

use Igniter\Flame\Providers\ConsoleServiceProvider as BaseConsoleServiceProvider;
use Igniter\System\Console\Commands\ExtensionInstall;
use Igniter\System\Console\Commands\ExtensionRefresh;
use Igniter\System\Console\Commands\ExtensionRemove;
use Igniter\System\Console\Commands\IgniterDown;
use Igniter\System\Console\Commands\IgniterInstall;
use Igniter\System\Console\Commands\IgniterPackageDiscover;
use Igniter\System\Console\Commands\IgniterPasswd;
use Igniter\System\Console\Commands\IgniterUp;
use Igniter\System\Console\Commands\IgniterUpdate;
use Igniter\System\Console\Commands\IgniterUtil;
use Igniter\System\Console\Commands\LanguageInstall;
use Igniter\System\Console\Commands\ThemeInstall;
use Igniter\System\Console\Commands\ThemePublish;
use Igniter\System\Console\Commands\ThemeRemove;
use Igniter\System\Console\Commands\ThemeVendorPublish;
use Igniter\System\EventSubscribers\ConsoleSubscriber;

class ConsoleServiceProvider extends BaseConsoleServiceProvider
{
    protected $subscribe = [
        ConsoleSubscriber::class,
    ];

    protected $commands = [
        'util' => IgniterUtil::class,
        'up' => IgniterUp::class,
        'down' => IgniterDown::class,
        'package-discover' => IgniterPackageDiscover::class,
        'install' => IgniterInstall::class,
        'update' => IgniterUpdate::class,
        'passwd' => IgniterPasswd::class,
        'extension.install' => ExtensionInstall::class,
        'extension.refresh' => ExtensionRefresh::class,
        'extension.remove' => ExtensionRemove::class,
        'theme.install' => ThemeInstall::class,
        'theme.remove' => ThemeRemove::class,
        'theme.publish' => ThemePublish::class,
        'theme.vendor-publish' => ThemeVendorPublish::class,
        'language.install' => LanguageInstall::class,
    ];
}
