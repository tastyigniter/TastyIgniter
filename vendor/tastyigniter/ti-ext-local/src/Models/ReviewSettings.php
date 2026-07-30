<?php

declare(strict_types=1);

namespace Igniter\Local\Models;

use Igniter\Flame\Database\Model;
use Igniter\System\Actions\SettingsModel;

class ReviewSettings extends Model
{
    public array $implement = [SettingsModel::class];

    // A unique code
    public string $settingsCode = 'igniter_review_settings';

    // Reference to field configuration
    public string $settingsFieldsConfig = 'reviewsettings';

    public static array $defaultHints = [
        ['value' => 'Poor'],
        ['value' => 'Average'],
        ['value' => 'Good'],
        ['value' => 'Very Good'],
        ['value' => 'Excellent'],
    ];

    public static function allowReviews(): bool
    {
        // @phpstan-ignore arguments.count
        return (bool)self::get('allow_reviews', true);
    }

    public static function autoApproveReviews()
    {
        // @phpstan-ignore arguments.count
        return self::get('approve_reviews', false);
    }

    public static function getHints()
    {
        // @phpstan-ignore arguments.count
        return collect(self::get('hints', self::$defaultHints))->pluck('value')->all();
    }
}
