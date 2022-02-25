<?php

namespace System\Models;

use Igniter\Flame\Database\Model;
use Igniter\Flame\Exception\ApplicationException;
use Igniter\Flame\Mail\Markdown;
use Igniter\Flame\Support\Facades\File;
use Main\Classes\ThemeManager;
use System\Classes\ExtensionManager;

/**
 * Extension Model Class
 */
class Extension extends Model
{
    const ICON_MIMETYPES = [
        'svg' => 'image/svg+xml',
        'png' => 'image/png',
        'jpeg' => 'image/jpeg',
        'jpg' => 'image/jpeg',
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
     * @var array The database records
     */
    protected $extensions = [];

    /**
     * @var \System\Classes\BaseExtension
     */
    protected $class;

    public static function onboardingIsComplete()
    {
        $activeTheme = ThemeManager::instance()->getActiveTheme();
        if (!$activeTheme)
            return FALSE;

        $requiredExtensions = (array)$activeTheme->requires;
        foreach ($requiredExtensions as $name => $constraint) {
            $extension = ExtensionManager::instance()->findExtension($name);
            if (!$extension || $extension->disabled)
                return FALSE;
        }

        return TRUE;
    }

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

    public function getClassAttribute()
    {
        return $this->class;
    }

    public function getStatusAttribute()
    {
        return $this->class && !$this->class->disabled;
    }

    public function getIconAttribute()
    {
        $icon = array_get($this->meta, 'icon', []);
        if (is_string($icon))
            $icon = ['class' => 'fa '.$icon];

        if (strlen($image = array_get($icon, 'image'))) {
            $file = extension_path(str_replace('.', '/', $this->name).'/'.$image);
            if (file_exists($file)) {
                $extension = pathinfo($file, PATHINFO_EXTENSION);
                if (!array_key_exists($extension, self::ICON_MIMETYPES))
                    throw new ApplicationException('Invalid extension icon type');

                $mimeType = self::ICON_MIMETYPES[$extension];
                $data = base64_encode(file_get_contents($file));
                $icon['backgroundImage'] = [$mimeType, $data];
                $icon['class'] = 'fa';
            }
        }

        return generate_extension_icon($icon);
    }

    public function getDescriptionAttribute()
    {
        return array_get($this->meta, 'description', 'Undefined extension description');
    }

    public function getReadmeAttribute($value)
    {
        $readmePath = ExtensionManager::instance()->path($this->name).'readme.md';
        if (!$readmePath = File::existsInsensitive($readmePath))
            return $value;

        return Markdown::parseFile($readmePath)->toHtml();
    }

    //
    // Events
    //

    protected function afterFetch()
    {
        $this->applyExtensionClass();
    }

    //
    // Helpers
    //

    /**
     * Sets the extension class as a property of this class
     * @return bool
     */
    public function applyExtensionClass()
    {
        $code = $this->name;

        if (!$code)
            return FALSE;

        if (!$extensionClass = ExtensionManager::instance()->findExtension($code)) {
            return FALSE;
        }

        $this->class = $extensionClass;

        return TRUE;
    }

    /**
     * Sync all extensions available in the filesystem into database
     */
    public static function syncAll()
    {
        $extensionManager = ExtensionManager::instance();
        foreach ($extensionManager->namespaces() as $namespace => $path) {
            $code = $extensionManager->getIdentifier($namespace);

            if (!($extension = $extensionManager->findExtension($code))) continue;

            $model = self::firstOrNew(['name' => $code]);

            $enableExtension = ($model->exists && !$extension->disabled);

            $model->save();

            $extensionManager->updateInstalledExtensions($code, $enableExtension);
        }
    }
}
