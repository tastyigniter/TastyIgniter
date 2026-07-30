<?php

declare(strict_types=1);

namespace Igniter\System\Models;

use Igniter\Flame\Currency\Contracts\CurrencyInterface;
use Igniter\Flame\Database\Builder;
use Igniter\Flame\Database\Factories\HasFactory;
use Igniter\Flame\Database\Model;
use Igniter\System\Models\Concerns\Defaultable;
use Igniter\System\Models\Concerns\HasCountry;
use Igniter\System\Models\Concerns\Switchable;
use Illuminate\Support\Carbon;
use Override;

/**
 * Currency Model Class
 *
 * @property int $currency_id
 * @property int $country_id
 * @property string $currency_name
 * @property string $currency_code
 * @property string $currency_symbol
 * @property float $currency_rate
 * @property bool|null $symbol_position
 * @property string $thousand_sign
 * @property string $decimal_sign
 * @property int $decimal_position
 * @property string|null $iso_alpha2
 * @property string|null $iso_alpha3
 * @property int|null $iso_numeric
 * @property int|null $currency_status
 * @property Carbon|null $updated_at
 * @property Carbon $created_at
 * @property bool $is_default
 * @method static Builder<static>|Currency applyDefaultable(bool $default = true)
 * @method static Builder<static>|Currency applyFilters(array $options = [])
 * @method static Builder<static>|Currency applySorts(array $sorts = [])
 * @method static Builder<static>|Currency applySwitchable(bool $switch = true)
 * @method static Builder<static>|Currency isEnabled()
 * @method static Builder<static>|Currency listFrontEnd(array $options = [])
 * @method static Builder<static>|Currency newModelQuery()
 * @method static Builder<static>|Currency newQuery()
 * @method static Builder<static>|Currency query()
 * @method static Builder<static>|Currency whereCountry($countryId)
 * @method static Builder<static>|Currency whereIsDisabled()
 * @method static Builder<static>|Currency whereIsEnabled()
 * @method static Builder<static>|Currency whereNotDefault()
 * @mixin \Illuminate\Database\Eloquent\Model
 */
class Currency extends Model implements CurrencyInterface
{
    use Defaultable;
    use HasCountry;
    use HasFactory;
    use Switchable;

    public const SWITCHABLE_COLUMN = 'currency_status';

    /**
     * @var string The database table name
     */
    protected $table = 'currencies';

    /**
     * @var string The database table primary key
     */
    protected $primaryKey = 'currency_id';

    public $timestamps = true;

    protected $guarded = [];

    protected $casts = [
        'country_id' => 'integer',
        'currency_rate' => 'float',
        'symbol_position' => 'boolean',
    ];

    public $relation = [
        'belongsTo' => [
            'country' => Country::class,
        ],
    ];

    protected array $queryModifierFilters = [
        'enabled' => 'applySwitchable',
    ];

    protected $attributes = [
        'currency_rate' => 0,
        'thousand_sign' => ',',
        'decimal_sign' => '.',
        'decimal_position' => 2,
    ];

    protected array $queryModifierSorts = ['currency_name asc', 'currency_name desc', 'currency_code asc', 'currency_code desc'];

    protected array $queryModifierSearchableFields = ['currency_name', 'currency_code'];

    public function defaultableName(): string
    {
        return $this->currency_name;
    }

    public static function getDropdownOptions()
    {
        return static::select(['currency_id', 'currencies.country_id', 'priority'])
            ->selectRaw("CONCAT_WS(' - ', country_name, currency_code, currency_symbol) as name")
            ->leftJoin('countries', 'currencies.country_id', '=', 'countries.country_id')
            ->orderBy('priority')
            ->whereIsEnabled()
            ->dropdown('name', 'currency_id');
    }

    public static function getConverterDropdownOptions(): array
    {
        return [
            'openexchangerates' => 'lang:igniter::system.settings.text_openexchangerates',
            'fixerio' => 'lang:igniter::system.settings.text_fixerio',
        ];
    }

    #[Override]
    public function updateRate($rate): void
    {
        $this->currency_rate = $rate;
        $this->save();
    }

    //
    //
    //

    #[Override]
    public function getId(): ?int
    {
        return $this->currency_id;
    }

    #[Override]
    public function getName(): ?string
    {
        return $this->currency_name;
    }

    #[Override]
    public function getCode(): ?string
    {
        return $this->currency_code;
    }

    #[Override]
    public function getSymbol(): ?string
    {
        return $this->currency_symbol;
    }

    #[Override]
    public function getSymbolPosition(): ?bool
    {
        return $this->symbol_position;
    }

    #[Override]
    public function getFormat(): string
    {
        $format = ($this->thousand_sign ?: '!').'0';

        if ((int)$this->decimal_position > 0) {
            $format .= $this->decimal_sign.str_repeat('0', (int)$this->decimal_position);
        }

        return $this->getSymbolPosition() ? '1'.$format.$this->getSymbol() : $this->getSymbol().'1'.$format;
    }

    #[Override]
    public function getRate(): ?float
    {
        return $this->currency_rate;
    }
}
