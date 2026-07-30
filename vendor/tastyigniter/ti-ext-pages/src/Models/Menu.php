<?php

declare(strict_types=1);

namespace Igniter\Pages\Models;

use Igniter\Flame\Database\Model;
use Igniter\Flame\Database\Relations\BelongsTo;
use Igniter\Flame\Database\Relations\HasMany;
use Igniter\Flame\Database\Traits\Purgeable;
use Igniter\Main\Models\Theme;
use Igniter\Pages\Classes\MenuManager;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

/**
 * Menu Model
 *
 * @property int $id
 * @property string $theme_code
 * @property string $name
 * @property string $code
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read mixed $theme_name
 * @property-read Collection<int, MenuItem> $items
 * @property-read null|Theme $theme
 * @method static HasMany<static>|MenuItem items()
 * @method static BelongsTo<static>|Menu theme()
 * @mixin Model
 */
class Menu extends Model
{
    use Purgeable;

    public $table = 'igniter_pages_menus';

    protected $fillable = [];

    public $timestamps = true;

    /**
     * @var array Relations
     */
    public $relation = [
        'hasMany' => [
            'items' => [MenuItem::class],
        ],
        'belongsTo' => [
            'theme' => [Theme::class, 'foreignKey' => 'theme_code', 'otherKey' => 'code'],
        ],
    ];

    protected $purgeable = ['items'];

    public static function syncAll(): void
    {
        $dbMenus = self::query()->select('id', 'theme_code', 'code')->get();

        $manager = resolve(MenuManager::class);
        foreach ($manager->getMenusConfig() as $config) {
            if ($dbMenus->where('code', $config['code'])->where('theme_code', $config['themeCode'])->count()) {
                continue;
            }

            $menu = new self;
            $menu->code = $config['code'];
            $menu->name = $config['name'];
            $menu->theme_code = $config['themeCode'];
            $menu->save();

            $menu->createMenuItemsFromConfig(array_get($config, 'items', []));
        }
    }

    public function getThemeCodeOptions()
    {
        return Theme::all()->pluck('name', 'code')->toArray();
    }

    public function addMenuItems($items): int
    {
        $id = $this->getKey();
        $idsToKeep = [];
        foreach ($items as $item) {
            $item['menu_id'] = $id;
            $menuItem = $this->items()->firstOrNew([
                'id' => array_get($item, 'id'),
            ])->fill(array_except($item, ['id']));

            $menuItem->saveOrFail();
            $idsToKeep[] = $menuItem->getKey();
        }

        $this->items()->whereNotIn('id', $idsToKeep)->delete();

        return count($idsToKeep);
    }

    public function createMenuItemsFromConfig($items): void
    {
        $iterator = function($items, $parentId = null) use (&$iterator): void {
            foreach ($items as $item) {
                if ($item['type'] == 'static-page' && !is_numeric($item['reference'])) {
                    $item['reference'] = ($page = Page::query()->whereSlug($item['reference'])->first())
                        ? $page->getKey() : $item['reference'];
                }

                $item['config'] = array_except($item, [
                    'code', 'title', 'description', 'type', 'url', 'reference', 'items',
                ]);

                $item['parent_id'] = $parentId;
                $menuItem = $this->items()->create($item);

                $iterator(array_get($item, 'items', []), $menuItem->id);
            }
        };

        $iterator($items);
    }

    public function getThemeNameAttribute($value)
    {
        return $this->theme?->name;
    }
}
