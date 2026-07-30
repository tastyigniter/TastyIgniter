<?php

declare(strict_types=1);

namespace Igniter\System\Models;

use Igniter\Flame\Database\Builder;
use Igniter\Flame\Database\Factories\HasFactory;
use Igniter\Flame\Database\Relations\HasMany;
use Igniter\Flame\Database\Traits\Purgeable;
use Igniter\System\Classes\LanguageManager;
use Igniter\System\Models\Concerns\Defaultable;
use Igniter\System\Models\Concerns\Switchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Lang;

/**
 * Language Model Class
 *
 * @property int $language_id
 * @property string $code
 * @property string $name
 * @property string|null $image
 * @property string $idiom
 * @property bool $status
 * @property int $can_delete
 * @property int|null $original_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property array<array-key, mixed>|null $version
 * @property bool $is_default
 * @property Collection<int, Translation> $translations
 * @method HasMany translations()
 * @method static Builder<static>|Language applyDefaultable(bool $default = true)
 * @method static Builder<static>|Language applyFilters(array $options = [])
 * @method static Builder<static>|Language applySorts(array $sorts = [])
 * @method static Builder<static>|Language applySwitchable(bool $switch = true)
 * @method static Builder<static>|Language isEnabled()
 * @method static Builder<static>|Language listFrontEnd(array $options = [])
 * @method static Builder<static>|Language newModelQuery()
 * @method static Builder<static>|Language newQuery()
 * @method static Builder<static>|Language query()
 * @method static Language first()
 * @method static Builder<static>|Language whereIsDisabled()
 * @method static Builder<static>|Language whereIsEnabled()
 * @method static Builder<static>|Language whereNotDefault()
 * @mixin Model
 */
class Language extends \Igniter\Flame\Translation\Models\Language
{
    use Defaultable;
    use HasFactory;
    use Purgeable;
    use Switchable;

    protected $purgeable = ['translations'];

    protected $casts = [
        'original_id' => 'integer',
        'version' => 'array',
        'status' => 'boolean',
    ];

    public $relation = [
        'hasMany' => [
            'translations' => [Translation::class, 'foreignKey' => 'locale', 'otherKey' => 'code', 'delete' => true],
        ],
    ];

    public $timestamps = true;

    protected $attributes = [
        'can_delete' => 0,
    ];

    /** Object cache of self, by code. */
    public static array $localesCache = [];

    /** A cache of supported locales. */
    public static ?array $supportedLocalesCache = null;

    /** Active language cache. */
    public static ?self $activeLanguage = null;

    public static function applySupportedLanguages(): void
    {
        setting()->setPref('supported_languages', self::getDropdownOptions()->keys()->toArray());
    }

    public static function getDropdownOptions()
    {
        return self::whereIsEnabled()->dropdown('name', 'code');
    }

    //
    // Helpers
    //

    public static function findByCode(?string $code = null): ?static
    {
        if (!$code) {
            return null;
        }

        return self::$localesCache[$code] ?? (self::$localesCache[$code] = self::whereCode($code)->first());
    }

    public function defaultableKeyName(): string
    {
        return 'code';
    }

    public static function getActiveLocale(): ?self
    {
        if (self::$activeLanguage instanceof Language) {
            return self::$activeLanguage;
        }

        /** @var static $activeLanguage */
        $activeLanguage = self::applySwitchable()
            ->where('code', app()->getLocale())
            ->first();

        return self::$activeLanguage = $activeLanguage;
    }

    public static function listSupported(): array
    {
        if (self::$supportedLocalesCache) {
            return self::$supportedLocalesCache;
        }

        return self::$supportedLocalesCache = self::whereIsEnabled()->pluck('name', 'code')->all();
    }

    public static function supportsLocale(): bool
    {
        return count(self::listSupported()) > 1;
    }

    public static function clearInternalCache(): void
    {
        self::$localesCache = [];
        self::$supportedLocalesCache = null;
        self::$activeLanguage = null;
    }

    //
    // Translations
    //

    public function getGroupOptions(?string $locale = null)
    {
        return collect(resolve(LanguageManager::class)->listLocalePackages($locale))
            ->mapWithKeys(fn($localePackage) => [$localePackage->code => $localePackage->name]);
    }

    public function getLines(string $locale, string $group, ?string $namespace = null): array
    {
        $lines = app('translation.loader')->load($locale, $group, $namespace);

        ksort($lines);

        return array_dot($lines);
    }

    public function getTranslations(string $group, ?string $namespace = null): array
    {
        return $this->getLines($this->code, $group, $namespace);
    }

    public function addTranslations(array $translations): bool
    {
        foreach ($translations as $key => $translation) {
            preg_match('/^(.+)::(.+?)\.(.+)+$/', (string)$key, $matches);

            if (!$matches || count($matches) !== 4) {
                continue;
            }

            [, $namespace, $group, $item] = $matches;

            $this->updateTranslation($group, $namespace, $item, (string)$translation['translation']);
        }

        return true;
    }

    public function updateTranslations(string $group, ?string $namespace = null, array $lines = []): array
    {
        return collect($lines)->map(function(string $text, string $key) use ($group, $namespace): string {
            $this->updateTranslation($group, $namespace, $key, $text);

            return $text;
        })->filter()->toArray();
    }

    public function updateTranslation(string $group, string $namespace, string $key, string $text)
    {
        $oldText = Lang::get(sprintf('%s::%s.%s', $namespace, $group, $key), [], $this->code);

        if (strcmp($text, $oldText) === 0) {
            return false;
        }

        /** @var Translation $translation */
        $translation = $this->translations()->firstOrNew([
            'group' => $group,
            'namespace' => $namespace,
            'item' => $key,
        ]);

        return $translation->updateAndLock($text);
    }

    public function updateVersions(string $code, string $fileName, string $hash)
    {
        $versions = $this->version ?? [];
        $versions[$code][$fileName] = $hash;
        $this->version = $versions;

        return $this->saveQuietly();
    }
}
