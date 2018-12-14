<?php namespace System\Models;

use Igniter\Flame\ActivityLog\Traits\LogsActivity;
use Igniter\Flame\Database\Builder;
use Main\Classes\ThemeManager;
use Model;
use System\Classes\ExtensionManager;
use System\Classes\UpdateManager;

/**
 * Extensions Model Class
 * @package System
 */
class Extensions_model extends Model
{
    use LogsActivity;

    //only the `updated` & `deleted` event will get logged automatically
    protected static $recordEvents = ['updated', 'deleted'];

    /**
     * @var string The database table name
     */
    protected $table = 'extensions';

    /**
     * @var string The database table primary key
     */
    protected $primaryKey = 'extension_id';

    protected $fillable = ['type', 'name', 'title', 'version'];

    public $casts = [
        'data' => 'serialize',
    ];

    /**
     * @var array The database records
     */
    protected $extensions = [];

    protected $meta;

    /**
     * @var \System\Classes\BaseExtension
     */
    protected $class;

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('type', function (Builder $builder) {
            $builder->where('type', 'module');
        });
    }

    public static function onboardingIsComplete()
    {
        $activeTheme = ThemeManager::instance()->getActiveTheme();
        if (!$activeTheme)
            return FALSE;

        $requiredExtensions = (array)$activeTheme->requires;
        foreach ($requiredExtensions as $name => $constraint) {
            $extension = ExtensionManager::instance()->findExtension($name);
            if (!$extension OR $extension->disabled)
                return FALSE;
        }

        return TRUE;
    }

    //
    // Accessors & Mutators
    //

    protected static function updateInstalledExtensions($code, $enabled = TRUE)
    {
        ExtensionManager::instance()->updateInstalledExtensions($code, $enabled);
        $installedExtensions = setting('installed_extensions', []);
        $installedExtensions[$code] = $enabled;
        setting()->set('installed_extensions', $installedExtensions)->save();
    }

    public function getMetaAttribute()
    {
        return $this->meta;
    }

    public function getClassAttribute()
    {
        return $this->class;
    }

    public function getStatusAttribute($value)
    {
        return $value AND $this->class AND !$this->class->disabled;
    }

    public function getVersionAttribute($value)
    {
        if (strlen($value))
            return $value;

        return array_get($this->meta, 'version');
    }

    //
    // Scopes
    //

    public function scopeIsEnabled($query)
    {
        $query->where('status', 1);
    }

    //
    // Events
    //

    public function afterFetch()
    {
        $this->applyExtensionClass();
    }

    //
    // Helpers
    //

    public function getMessageForEvent($eventName)
    {
        if ($eventName == 'updated' AND $this->status == 1)
            $eventName = strtolower(lang('system::lang.extensions.text_installed'));

        if ($eventName == 'updated' AND $this->status != 1)
            $eventName = strtolower(lang('system::lang.extensions.text_uninstalled'));

        $replace['event'] = $eventName;

        return parse_values($replace, lang('system::lang.extensions.activity_event_log'));
    }

    /**
     * Sets the extension class as a property of this class
     * @return boolean
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
        $this->meta = $extensionClass->extensionMeta();

        return TRUE;
    }

    /**
     * Save all extension registered permissions to database
     */
    public static function syncAll()
    {
        $extensions = self::get();

        $installedExtensions = [];

        $extensionManager = ExtensionManager::instance();
        foreach ($extensionManager->namespaces() as $namespace => $path) {

            $code = $extensionManager->getIdentifier($namespace);

            if (!($extensionClass = $extensionManager->findExtension($code))) continue;

            $extensionMeta = (object)$extensionClass->extensionMeta();
            $installedExtensions[] = $code;

            // Only add extensions with no existing record in extensions table
            if ($extension = $extensions->where('name', $code)->first()) continue;

            $extensionModel = self::make();
            $extensionModel->type = 'module';
            $extensionModel->name = $code;
            $extensionModel->title = $extensionMeta->name;
            $extensionModel->version = $extensionMeta->version;
            $extensionModel->disableLogging();
            $extensionModel->save();

            $extensionManager->updateInstalledExtensions($code, FALSE);
        }

        // Disable extensions not found in file system
        // This allows admin to remove an enabled extension from admin UI after deleting files
        self::whereNotIn('name', $installedExtensions)->update(['status' => FALSE]);
    }

    /**
     * Install a new or existing extension by code
     *
     * @param string $code
     *
     * @param null $version
     * @return bool|null
     */
    public static function install($code, $version = null)
    {
        $extensionModel = self::firstOrNew(['type' => 'module', 'name' => $code]);
        if (!$extensionModel->applyExtensionClass())
            return FALSE;

        $manager = ExtensionManager::instance();

        // Register and boot the extension to make
        // its services available before migrating
        if ($extension = $manager->findExtension($extensionModel->name)) {
            $extension->disabled = FALSE;
            $manager->registerExtension($extensionModel->name, $extension);
            $manager->bootExtension($extension);
        }

        // set extension migration to the latest version
        UpdateManager::instance()->migrateExtension($extensionModel->name);

        if ($extensionModel AND $extensionModel->meta) {
            $extensionModel->status = TRUE;
            $extensionModel->fill([
                'title' => $extensionModel->meta['name'],
                'version' => $version ?? $extensionModel->version,
            ])->save();
        }

        self::updateInstalledExtensions($code, TRUE);

        return TRUE;
    }

    /**
     * Uninstall a new or existing extension by code
     *
     * @param string $code
     *
     * @return bool|null
     */
    public static function uninstall($code = '')
    {
        $query = FALSE;

        $extensionModel = self::where('name', $code)->first();
        if ($extensionModel) {
            $extensionModel->status = FALSE;
            $query = $extensionModel->save();
        }

        self::updateInstalledExtensions($code, FALSE);

        return $query;
    }

    /**
     * Delete a single extension by code
     *
     * @param string $code
     * @param bool $deleteData whether to purge extension data
     * @param bool $keepFiles
     *
     * @return bool
     * @throws \Exception
     */
    public static function deleteExtension($code = '', $deleteData = TRUE, $keepFiles = FALSE)
    {
        if ($extensionModel = self::where('name', $code)->first())
            $extensionModel->delete();

        if ($deleteData)
            UpdateManager::instance()->purgeExtension($code);

        $extensionManager = ExtensionManager::instance();

        // delete extensions from file system
        if (!$keepFiles)
            $extensionManager->removeExtension($code);

        // disable extension
        $extensionManager->updateInstalledExtensions($code, null);

        return TRUE;
    }
}
