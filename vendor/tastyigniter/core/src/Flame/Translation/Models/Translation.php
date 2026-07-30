<?php

declare(strict_types=1);

namespace Igniter\Flame\Translation\Models;

use Igniter\Flame\Database\Builder;
use Igniter\Flame\Database\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Override;

/**
 * @property int $translation_id
 * @property string $locale
 * @property string $namespace
 * @property string $group
 * @property string $item
 * @property string $text
 * @property bool $unstable
 * @property bool $locked
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read string $code
 * @method static Builder<static>|Translation applyFilters(array $options = [])
 * @method static Builder<static>|Translation applySorts(array $sorts = [])
 * @method static Builder<static>|Translation listFrontEnd(array $options = [])
 * @method static Builder<static>|Translation newModelQuery()
 * @method static Builder<static>|Translation newQuery()
 * @method static Builder<static>|Translation query()
 * @mixin \Illuminate\Database\Eloquent\Model
 */
class Translation extends Model
{
    protected static $cacheKey = 'igniter.translation';

    public $timestamps = true;

    /**
     * @var string Table name in the database.
     */
    protected $table = 'language_translations';

    /**
     * @var string The database table primary key
     */
    protected $primaryKey = 'translation_id';

    /**
     * List of variables that can be mass assigned
     */
    protected $fillable = ['locale', 'namespace', 'group', 'item', 'text', 'unstable'];

    protected $casts = [
        'unstable' => 'boolean',
        'locked' => 'boolean',
    ];

    #[Override]
    protected static function boot(): void
    {
        parent::boot();

        static::saved(function(Translation $model) {
            $model->flushCache();
        });

        static::deleted(function(Translation $model) {
            $model->flushCache();
        });
    }

    public static function getCacheKey(string $locale, $group, $namespace): string
    {
        return static::$cacheKey.sprintf('.%s.%s.%s', $locale, $namespace, $group);
    }

    /**
     *  Returns the full translation code for an entry: namespace.group.item
     */
    public function getCodeAttribute(): string
    {
        return $this->namespace === '*' ? sprintf('%s.%s', $this->group, $this->item) : sprintf('%s::%s.%s', $this->namespace, $this->group, $this->item);
    }

    /**
     *  Flag this entry as Reviewed
     */
    public function flagAsReviewed(): static
    {
        $this->unstable = false;

        return $this;
    }

    /**
     *  Flag this entry as pending review.
     */
    public function flagAsUnstable(): void
    {
        $this->unstable = true;

        $this->save();
    }

    /**
     *  Set the translation to the locked state
     */
    public function lockState(): static
    {
        $this->locked = true;

        return $this;
    }

    /**
     *  Check if the translation is locked
     */
    public function isLocked(): bool
    {
        return (bool)$this->locked;
    }

    protected function flushCache()
    {
        Cache::forget(static::getCacheKey($this->locale, $this->group, $this->namespace));
    }

    public static function getFresh($locale, $group, $namespace = null)
    {
        return static::query()
            ->where('locale', $locale)
            ->where('group', $group)
            ->where('namespace', $namespace)
            ->get();
    }

    public static function getCached(string $locale, $group, $namespace = null)
    {
        $cacheKey = static::getCacheKey($locale, $group, $namespace);

        return Cache::rememberForever($cacheKey, function() use ($locale, $group, $namespace) {
            $result = static::getFresh($locale, $group, $namespace)->reduce(
                function($lines, Translation $model): array {
                    array_set($lines, $model->item, $model->text);

                    return $lines;
                },
            );

            return $result ?: [];
        },
        );
    }
}
