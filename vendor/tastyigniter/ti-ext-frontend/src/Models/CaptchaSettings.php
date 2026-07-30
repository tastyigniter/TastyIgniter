<?php

declare(strict_types=1);

namespace Igniter\Frontend\Models;

use Igniter\Flame\Database\Model;
use Igniter\System\Actions\SettingsModel;

/**
 * @mixin SettingsModel
 */
class CaptchaSettings extends Model
{
    public array $implement = [SettingsModel::class];

    // A unique code
    public string $settingsCode = 'igniter_frontend_captchasettings';

    // Reference to field configuration
    public string $settingsFieldsConfig = 'captchasettings';

    public static function getApiSecretKey(): string
    {
        return self::get('api_secret_key', ''); // @phpstan-ignore-line arguments.count
    }

    public static function getVersion(): string
    {
        return self::get('version', ''); // @phpstan-ignore-line arguments.count
    }

    public static function getLang(): string
    {
        return self::get('lang', 'en'); // @phpstan-ignore-line arguments.count
    }
}
