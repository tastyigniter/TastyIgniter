<?php namespace System\Models;

use Igniter\Flame\ActivityLog\Traits\LogsActivity;
use Igniter\Flame\Database\Builder;
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

    protected $meta = null;

    protected $class = null;

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('type', function (Builder $builder) {
            $builder->where('type', 'module');
        });
    }

    //
    // Accessors & Mutators
    //

    public function getMetaAttribute()
    {
        return $this->meta;
    }

    public function getClassAttribute()
    {
        return $this->class;
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
            $eventName = strtolower(lang('system::extensions.text_installed'));

        if ($eventName == 'updated' AND $this->status != 1)
            $eventName = strtolower(lang('system::extensions.text_uninstalled'));

        $replace['event'] = $eventName;

        return parse_values($replace, lang('system::extensions.activity_event_log'));
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

        $extensionManager = ExtensionManager::instance();
        foreach ($extensionManager->namespaces() as $namespace => $path) {

            $code = $extensionManager->getIdentifier($namespace);

            if (!($extensionClass = $extensionManager->findExtension($code))) continue;

            $extensionMeta = (object)$extensionClass->extensionMeta();
            $installedExtensions[] = $code;

            // Only add  extensions with no existing record in extensions table
            if ($extension = $extensions->where('name', $code)->first()) continue;

            self::create([
                'type'    => 'module',
                'name'    => $code,
                'title'   => $extensionMeta->name,
                'version' => $extensionMeta->version,
            ]);

            $extensionManager->updateExtension($code, FALSE);
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
     * @return bool|null
     */
    public static function install($code)
    {
        $extensionModel = self::firstOrNew(['type' => 'module', 'name' => $code]);
        if (!$extensionModel->applyExtensionClass())
            return FALSE;

        if ($extensionModel AND $extensionModel->meta) {
            $extensionModel->status = TRUE;
            $extensionModel->fill([
                'title'   => $extensionModel->meta['name'],
                'version' => $extensionModel->meta['version'],
            ])->save();
        }

        // set extension migration to the latest version
        UpdateManager::instance()->migrateExtension($extensionModel->name);

        ExtensionManager::instance()->updateExtension(
            $extensionModel->name, $extensionModel->status
        );

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

        ExtensionManager::instance()->updateExtension(
            $extensionModel->name, $extensionModel->status
        );

        return $query;
    }

    /**
     * Delete a single extension by code
     *
     * @param string $code
     * @param bool $deleteData whether to delete extension data
     *
     * @return bool
     */
    public static function deleteExtension($code = '', $deleteData = TRUE, $keepFiles = FALSE)
    {
        $extensionModel = self::where('name', $code)->first();

        if ($extensionModel AND $deleteData) {
            $extensionModel->delete();
            UpdateManager::instance()->purgeExtension($code);
        }

        $extensionManager = ExtensionManager::instance();

        // delete extensions from file system
        if (!$keepFiles)
            $extensionManager->removeExtension($code);

        // disable extension
        $extensionManager->updateExtension($code, FALSE);

        return TRUE;
    }
}