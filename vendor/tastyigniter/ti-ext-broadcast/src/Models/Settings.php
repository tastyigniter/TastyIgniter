<?php

declare(strict_types=1);

namespace Igniter\Broadcast\Models;

use Igniter\Flame\Database\Model;
use Igniter\Flame\Support\Facades\Igniter;
use Igniter\System\Actions\SettingsModel;
use Igniter\System\Classes\ExtensionManager;

/**
 * @method static mixed get(string $key, mixed $default = null)
 * @method static bool set(string|array $key, mixed $value = null)
 * @mixin SettingsModel
 */
class Settings extends Model
{
    public array $implement = [SettingsModel::class];

    // A unique code
    public string $settingsCode = 'igniter_broadcast_settings';

    // Reference to field configuration
    public string $settingsFieldsConfig = 'settings';

    public static function isConfigured(): bool
    {
        return Igniter::hasDatabase()
            && (self::isPusherConfigured()
                || self::isReverbConfigured()
                || self::isAblyConfigured());
    }

    public static function isPusherConfigured(): bool
    {
        return self::get('provider') === 'pusher'
            && strlen((string)self::get('app_id'))
            && strlen((string)self::get('key'))
            && strlen((string)self::get('secret'));
    }

    public static function isReverbConfigured(): bool
    {
        return self::get('provider') === 'reverb'
            && strlen((string)self::get('reverb_app_id'))
            && strlen((string)self::get('reverb_key'))
            && strlen((string)self::get('reverb_secret'));
    }

    public static function isAblyConfigured(): bool
    {
        return self::get('provider') === 'ably'
            && strlen((string)self::get('ably_key'));
    }

    public static function findRegisteredBroadcasts()
    {
        $results = [];
        $broadcastBundle = resolve(ExtensionManager::class)->getRegistrationMethodValues('registerEventBroadcasts');

        foreach ($broadcastBundle as $broadcasts) {
            foreach ($broadcasts as $event => $broadcast) {
                $results[$event] = $broadcast;
            }
        }

        return $results;
    }

    public static function findEventBroadcasts()
    {
        $results = [];
        foreach (self::findRegisteredBroadcasts() as $eventCode => $broadcastClass) {
            $results[$eventCode] = $broadcastClass;
        }

        return $results;
    }

    public static function useWebsockets(): bool
    {
        return false;
    }
}
