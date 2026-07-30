<?php

declare(strict_types=1);

namespace Igniter\Frontend\Models;

use Igniter\Flame\Database\Model;
use Igniter\System\Actions\SettingsModel;

/**
 * @method static mixed get(string $key, mixed $default = null)
 * @method static bool set(string|array $key, mixed $value)
 * @mixin SettingsModel
 */
class MailchimpSettings extends Model
{
    public array $implement = [SettingsModel::class];

    public string $settingsCode = 'igniter_frontend_mailchimpsettings';

    public string $settingsFieldsConfig = 'mailchimpsettings';

    public static function isConfigured(): bool
    {
        return self::getApiKey() !== '';
    }

    public static function getApiKey(): string
    {
        return self::get('api_key', ''); // @phpstan-ignore-line arguments.count
    }
}
