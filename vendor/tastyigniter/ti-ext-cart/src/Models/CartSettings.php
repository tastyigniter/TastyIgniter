<?php

declare(strict_types=1);

namespace Igniter\Cart\Models;

use Igniter\Cart\Classes\CartConditionManager;
use Igniter\Flame\Database\Model;
use Igniter\System\Actions\SettingsModel;

/**
 * @method static mixed get(string $key, mixed $default = null)
 * @method static bool set(string|array $key, mixed $value)
 * @mixin SettingsModel
 */
class CartSettings extends Model
{
    public array $implement = [SettingsModel::class];

    // A unique code
    public string $settingsCode = 'igniter_cart_settings';

    // Reference to field configuration
    public string $settingsFieldsConfig = 'cartsettings';

    public function getConditionsAttribute(?array $value)
    {
        $result = [];
        $registeredConditions = resolve(CartConditionManager::class)->listRegisteredConditions();
        foreach ($registeredConditions as $registeredCondition) {
            $name = array_get($registeredCondition, 'name');
            $dbCondition = $value[$name] ?? [];
            $result[$name] = array_merge($registeredCondition, $dbCondition);
        }

        return $result;
    }

    //
    //
    //

    public static function tippingEnabled(): bool
    {
        return (bool)self::get('enable_tipping');
    }

    public static function tippingAmounts()
    {
        $result = [];

        $tipValueType = self::get('tip_value_type', 'F'); // @phpstan-ignore-line arguments.count
        $amounts = (array)self::get('tip_amounts', []); // @phpstan-ignore-line arguments.count

        $amounts = sort_array($amounts, 'priority');

        foreach ($amounts as $index => $amount) {
            $amount['valueType'] = $tipValueType;
            $result[$index] = (object)$amount;
        }

        return $result;
    }
}
