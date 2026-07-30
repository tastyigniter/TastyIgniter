<?php

declare(strict_types=1);

namespace Igniter\System\Models;

use Igniter\Flame\Database\Builder;
use Igniter\Flame\Database\Factories\HasFactory;
use Igniter\Flame\Database\Model;
use Igniter\Flame\Database\Traits\HasPermalink;
use Igniter\System\Models\Concerns\Switchable;
use Illuminate\Support\Carbon;

/**
 * Page Class
 *
 * @internal
 * @property int $page_id
 * @property int $language_id
 * @property string $title
 * @property string $content
 * @property string|null $meta_description
 * @property string|null $meta_keywords
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property int $status
 * @property string|null $permalink_slug
 * @property string|null $layout
 * @property array<array-key, mixed>|null $metadata
 * @property int|null $priority
 * @method static Builder<static>|Page applyFilters(array $options = [])
 * @method static Builder<static>|Page applySorts(array $sorts = [])
 * @method static Builder<static>|Page applySwitchable(bool $switch = true)
 * @method static Builder<static>|Page findSimilarSlugs($attribute, array $config, string $slug)
 * @method static Builder<static>|Page isEnabled()
 * @method static Builder<static>|Page listFrontEnd(array $options = [])
 * @method static Builder<static>|Page newModelQuery()
 * @method static Builder<static>|Page newQuery()
 * @method static Builder<static>|Page query()
 * @method static Builder<static>|Page whereIsDisabled()
 * @method static Builder<static>|Page whereIsEnabled()
 * @method static Builder<static>|Page whereSlug(string $slug)
 * @mixin \Illuminate\Database\Eloquent\Model
 */
class Page extends Model
{
    use HasFactory;
    use HasPermalink;
    use Switchable;

    /**
     * @var string The database table name
     */
    protected $table = 'pages';

    /**
     * @var string The database table primary key
     */
    protected $primaryKey = 'page_id';

    public $timestamps = true;

    protected $guarded = [];

    protected $casts = [
        'language_id' => 'integer',
        'metadata' => 'json',
    ];

    public $relation = [
        'belongsTo' => [
            'language' => Language::class,
        ],
    ];

    protected $permalinkable = [
        'permalink_slug' => [
            'source' => 'title',
        ],
    ];

    public static function getDropdownOptions()
    {
        return static::whereIsEnabled()->dropdown('title', 'permalink_slug');
    }
}
