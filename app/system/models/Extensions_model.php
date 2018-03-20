<?php namespace System\Models;

use Igniter\Flame\ActivityLog\Traits\LogsActivity;
use Igniter\Flame\Database\Builder;
use Model;
use System\Classes\ExtensionManager;

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

    public function afterSave()
    {
        if (array_get($this->original, 'status') == array_get($this->attributes, 'status'))
            return;

        $this->updateInstalledExtensions($this->name, ($this->status == 1));

        $this->syncMailTemplates();

        // set extension migration to the latest version
        ExtensionManager::instance()->updateExtension($this->name);
    }

    public function beforeDelete()
    {
        if ($this->status == 1)
            return FALSE;

        $extensionManager = ExtensionManager::instance();

        // downgrade extension migration
        $extensionManager->updateExtension($this->name, TRUE);

        self::updateInstalledExtensions($this->name, FALSE);

        // delete extensions from file system
        $extensionManager->removeExtension($this->name);
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
            $installedExtensions[] = $extensionMeta->code;

            // Only add  extensions whose meta code matched their directory name
            // or extension has no record in extensions table
            if (
                !isset($extensionMeta->code) OR $code != $extensionMeta->code OR
                $extension = $extensions->where('name', $extensionMeta->code)->first()
            ) continue;

            self::create([
                'type'    => 'module',
                'name'    => $code,
                'title'   => $extensionMeta->name,
                'version' => $extensionMeta->version,
            ]);
        }

        // Disable extensions not found in file system
        // This allows admin to remove an enabled extension from admin UI after deleting files
        self::whereNotIn('name', $installedExtensions)->update(['status' => FALSE]);

        self::updateInstalledExtensions();
    }

    /**
     * Save all extension registered mail templates to database
     */
    public function syncMailTemplates()
    {
        Mail_templates_model::syncAll();
    }

    /**
     * Update installed extensions config value
     *
     * @param string $extension
     * @param bool $install
     *
     * @return bool TRUE on success, FALSE on failure
     */
    public static function updateInstalledExtensions($extension = null, $install = TRUE)
    {
        $installedExtensions = self::select('status', 'name')->lists('status', 'name')->all();

        if (!is_array($installedExtensions))
            $installedExtensions = [];

        if ($extension) {
            $installedExtensions[$extension] = $install;
        }

        setting()->set('installed_extensions', $installedExtensions);
    }

    /**
     * Install a new or existing extension by code
     *
     * @param string $code
     * @param object $extension Extension
     *
     * @return bool|null
     */
    public static function install($code, $extension = null)
    {
        $code = str_replace('/', '.', $code);

        if (!ExtensionManager::instance()->hasExtension($code))
            return FALSE;

        $extensionModel = self::firstOrNew(['type' => 'module', 'name' => $code]);

        if ($extensionModel AND $extensionModel->meta) {
            $extensionModel->status = TRUE;
            $extensionModel->fill([
                'title'   => $extensionModel->meta['name'],
                'version' => $extensionModel->meta['version'],
            ])->save();
        }

        return TRUE;
    }

    /**
     * Uninstall a new or existing extension by code
     *
     * @param string $code
     * @param object $extension Extension
     *
     * @return bool|null
     */
    public static function uninstall($code = '', $extension = null)
    {
        $query = FALSE;

        $extensionModel = self::where('name', $code)->first();
        if ($extensionModel) {
            if (preg_match('/\s/', $code) > 0) {
                $query = $extensionModel->delete();
            }
            else {
                $extensionModel->status = FALSE;
                $query = $extensionModel->save();
            }
        }

        return $query;
    }

    /**
     * Delete a single extension by code
     *
     * @param string $code
     * @param bool $delete_data whether to delete extension data
     *
     * @return bool
     */
    public static function deleteExtension($code = '', $deleteData = TRUE)
    {
        $extensionModel = self::where('name', trim($code, '.'))->first();

        $dataDeleted = FALSE;
        $filesDeleted = TRUE;

        if ($extensionModel AND ($deleteData OR !$extensionModel->data)) {
            $dataDeleted = $extensionModel->delete();
        }

        // This is to make sure files are deleted
        // since the beforeDelete() event only fires on disabled extensions
        if (!$dataDeleted)
            $filesDeleted = ExtensionManager::instance()->removeExtension($code);

        return $filesDeleted;
    }
}