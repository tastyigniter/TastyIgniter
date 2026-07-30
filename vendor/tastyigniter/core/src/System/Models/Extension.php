<?php

declare(strict_types=1);

namespace Igniter\System\Models;

use Igniter\Flame\Database\Builder;
use Igniter\Flame\Database\Model;
use Igniter\Flame\Mail\Markdown;
use Igniter\Flame\Support\Facades\File;
use Igniter\System\Classes\BaseExtension;
use Igniter\System\Classes\ExtensionManager;
use Igniter\System\Classes\PackageManifest;
use InvalidArgumentException;
use Override;

/**
 * Extension Model Class
 *
 * @property int $extension_id
 * @property string|null $name
 * @property string|null $version
 * @property-read mixed $description
 * @property-read array $icon
 * @property-read mixed $meta
 * @property-read mixed $readme
 * @property-read bool $required
 * @property-read bool $status
 * @property-read mixed $title
 * @method static Builder<static>|Extension applyFilters(array $options = [])
 * @method static Builder<static>|Extension applySorts(array $sorts = [])
 * @method static Builder<static>|Extension listFrontEnd(array $options = [])
 * @method static Builder<static>|Extension newModelQuery()
 * @method static Builder<static>|Extension newQuery()
 * @method static Builder<static>|Extension query()
 * @mixin \Illuminate\Database\Eloquent\Model
 */
class Extension extends Model
{
    public const ICON_MIMETYPES = [
        'png' => 'image/png',
        'svg' => 'image/svg+xml',
    ];

    /**
     * @var string The database table name
     */
    protected $table = 'extensions';

    /**
     * @var string The database table primary key
     */
    protected $primaryKey = 'extension_id';

    protected $fillable = ['name', 'version'];

    /**
     * @var BaseExtension
     */
    public $class;

    //
    // Accessors & Mutators
    //

    public function getMetaAttribute()
    {
        return $this->class ? $this->class->extensionMeta() : [];
    }

    public function getVersionAttribute($value = null)
    {
        return $value ?? '0.1.0';
    }

    public function getTitleAttribute()
    {
        return array_get($this->meta, 'name', 'Undefined extension title');
    }

    public function getStatusAttribute(): bool
    {
        return $this->class && !$this->class->disabled;
    }

    public function getRequiredAttribute(): bool
    {
        return resolve(ExtensionManager::class)->isRequired($this->name);
    }

    public function getIconAttribute(): array
    {
        $icon = array_get($this->meta, 'icon', []);
        if (is_string($icon)) {
            $icon = ['class' => 'fa '.$icon];
        }

        if (!empty($image = array_get($icon, 'image', '')) && File::exists($file = resolve(ExtensionManager::class)->path($this->name, $image))) {
            $extension = pathinfo($file, PATHINFO_EXTENSION);
            if (!array_key_exists($extension, self::ICON_MIMETYPES)) {
                throw new InvalidArgumentException('Invalid extension icon file type in: '.$this->name.'. Only SVG and PNG images are supported');
            }

            $mimeType = self::ICON_MIMETYPES[$extension];
            $data = base64_encode(File::get($file));
            $icon['backgroundImage'] = [$mimeType, $data];
            $icon['class'] = 'fa';
        }

        return generate_extension_icon($icon);
    }

    public function getDescriptionAttribute()
    {
        return array_get($this->meta, 'description', 'Undefined extension description');
    }

    public function getReadmeAttribute($value)
    {
        $readmePath = resolve(ExtensionManager::class)->path($this->name, 'readme.md');
        if (!$readmePath = File::existsInsensitive($readmePath)) {
            return $value;
        }

        return Markdown::parseFile($readmePath)->toHtml();
    }

    //
    // Events
    //

    #[Override]
    protected function afterFetch()
    {
        $this->applyExtensionClass();
    }

    //
    // Helpers
    //

    /**
     * Sets the extension class as a property of this class
     */
    public function applyExtensionClass(): bool
    {
        $code = $this->name;

        if (!$code || !$extensionClass = resolve(ExtensionManager::class)->findExtension($code)) {
            return false;
        }

        $this->class = $extensionClass;

        return true;
    }

    public function getExtensionObject()
    {
        return $this->class;
    }

    /**
     * Sync all extensions available in the filesystem into database
     */
    public static function syncAll(): void
    {
        $availableExtensions = [];
        $manifest = resolve(PackageManifest::class);
        $extensionManager = resolve(ExtensionManager::class);
        $extensions = self::all();

        foreach ($extensionManager->namespaces() as $namespace => $path) {
            $code = $extensionManager->getIdentifier($namespace);

            if (!$extensionManager->findExtension($code)) {
                continue;
            }

            $availableExtensions[] = $code;

            $model = $extensions->firstWhere('name', $code) ?? new static(['name' => $code]);

            $model->version = $manifest->getVersion($model->name) ?? $model->version;
            $model->save();
        }

        self::query()->whereNotIn('name', $availableExtensions)->delete();
    }
}
