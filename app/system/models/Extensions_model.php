<?php namespace System\Models;

use System\Classes\BaseExtention;
use Igniter\Flame\Database\Builder;
use Model;
use Igniter\Flame\ActivityLog\Traits\LogsActivity;
use Modules;
use System\Classes\ExtensionManager;

/**
 * Extensions Model Class
 *
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

    protected $fillable = ['extension_id', 'type', 'name', 'data', 'serialized', 'status', 'title', 'version'];

    public $casts = [
        'data' => 'serialize'
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

    public function scopeFilter($query, $filter = [])
    {
        if (!isset($filter['filter_type']) OR is_string($filter['filter_type'])) {
            $filter['filter_type'] = ['module', 'payment', 'widget'];
        }

        if (!empty($filter['filter_type']) AND is_array($filter['filter_type'])) {
            $query->whereIn('type', $filter['filter_type']);
        }

        return $query;
    }

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
        if ((isset($this->original['status'])) AND $this->original['status'] == $this->attributes['status'])
            return;

        $this->updateInstalledExtensions($this->name, ($this->status == 1));

        $this->syncPermissions();

        $this->syncTemplates();

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
            $eventName = strtolower(lang('text_installed'));

        if ($eventName == 'updated' AND $this->status != 1)
            $eventName = strtolower(lang('text_uninstalled'));

        $replace['event'] = $eventName;
        return parse_values($replace, lang('system::extensions.activity_event_log'));
    }

    /**
     * Save all extension registered permissions to database
     */
    public static function syncLocal()
    {
        $extensions = self::get();

        foreach (ExtensionManager::instance()->paths() as $code => $path) {
            if (!($extensionClass = ExtensionManager::instance()->findExtension($code))) continue;

            $extensionMeta = (object) $extensionClass->extensionMeta();

            // Only add  extensions whose meta code matched their directory name
            // or extension has no record in extensions table
            if (
                !isset($extensionMeta->code) OR $code != $extensionMeta->code OR
                $extension = $extensions->where('name', $extensionMeta->code)->first()
            ) continue;

            self::create([
                'type' => 'module',
                'name' => $code,
                'title' => $extensionMeta->name,
                'version' => $extensionMeta->version,
            ]);
        }

        self::updateInstalledExtensions();
    }

    /**
     * Save all extension registered permissions to database
     */
    public function syncPermissions()
    {
        Permissions_model::syncAll();
    }

    /**
     * Save all extension registered mail templates to database
     */
    public function syncTemplates()
    {
        Mail_templates_data_model::syncAll();
    }

    /**
     * Sets the extension class as a property of this class
     *
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
     * Return all extensions and build extension array
     *
     * @return array
     */
    public function findAllByPath()
    {
        $result = $db_extensions = [];
        foreach (parent::getList() as $row) {
            if (preg_match('/\s/', $row['name']) > 0 OR !$this->extensionExists($row['name'])) {
                $this->uninstall($row['name']);
                continue;
            }

            $row['title'] = !empty($row['title']) ? $row['title'] : '';
            $row['ext_data'] = ($row['serialized'] == '1' AND !empty($row['data'])) ? unserialize($row['data']) : [];
            unset($row['data']);

            $db_extensions[$row['name']] = $row;
        }

        foreach (ExtensionManager::instance()->paths() as $code => $path) {
            if (!($extensionClass = ExtensionManager::instance()->findExtension($code))) continue;

            $db_extension = isset($db_extensions[$code]) ? $db_extensions[$code] : [];

            $extension = $extensionClass->extensionMeta();
            $result[$code] = array_merge($extension, [
                'code'         => $code,
                'extension_id' => isset($db_extension['extension_id']) ? $db_extension['extension_id'] : 0,
                'ext_data'     => isset($db_extension['ext_data']) ? $db_extension['ext_data'] : '',
                'settings'     => $extensionClass->registerSettings(),
                'installed'    => (!empty($db_extension)) ? TRUE : FALSE,
                'disabled'    	=> $extensionClass->disabled,
                'status'       => (isset($db_extension['status']) AND $db_extension['status'] == '1') ? '1' : '0',
            ]);
        }

        return $result;
    }

    /**
	 * Return all extensions MATCHING filter
	 *
	 * @param array $filter
	 *
	 * @return array
	 */
	public function getExtensions()
	{
        return $this->get();
	}

	/**
	 * Find a single extension by code
	 *
	 * @param string $code
	 * @param array $filter
	 *
	 * @return array
	 */
	public function getExtension($code = '')
	{
        return $this->first(['code' => $code]);
	}

	/**
	 * Find a single extension by code
	 *
	 * @param string $code
	 *
	 * @return array
	 */
	public function getSettings($code = '')
	{
        $extension = $this->getExtension($code);

		return is_array($extension->data) ? $extension->data : [];
	}

	/**
	 * Return all files within an extension folder
	 * @deprecated since 2.2.0 use ExtensionManager::instance()->files_path() instead
	 *
	 * @param string $code
	 * @param array $files
	 *
	 * @return array|null
	 */
	public function getExtensionFiles($code = null, $files = [])
	{
		return ExtensionManager::instance()->files_path($code);
	}

    /**
     * Update existing extension
     *
     * @deprecated method, use updateSettings instead
     *
     * @param string $type
     * @param null $code
     * @param array $data
     * @param bool $log_activity
     *
     * @return bool TRUE on success, FALSE on failure
     */
    public function updateExtension($type = 'module', $code = null, $data = [], $log_activity = TRUE)
    {
        return $this->updateSettings($code, $data, $log_activity);
    }

    /**
     * Update extension settings
     *
     * @param null $code
     * @param array $data
     * @param bool $log_activity
     *
     * @return bool TRUE on success, FALSE on failure
     */
    public function updateSettings($code = null, $data = [], $log_activity = TRUE)
    {
        $code = ExtensionManager::instance()->checkName($code);

        if ($code === null) return FALSE;

        !isset($data['data']) OR $data = $data['data'];

        $query = FALSE;

        if ($this->extensionExists($code)) {
            $extension = ExtensionManager::instance()->findExtension($code);

            if (!$extension instanceof BaseExtension) {
                return $query;
            }

            if (!$log_activity)
                self::$recordEvents = array_except(self::$recordEvents, 'updated');

            $extensionModel = $this->where('name', $code)->first();

            $saved = $extensionModel->fill([
                'data'       => (is_array($data)) ? serialize($data) : $data,
                'serialized' => '1',
                'type'       => 'module',
            ])->save();

            $query = $saved ? $extensionModel->extension_id : $saved;
        }

        return $query;
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
	 * Create a new or update existing extension
	 *
	 * @param null $code
	 * @param array $data
	 * @param bool $log_activity
	 *
	 * @return bool TRUE on success, FALSE on failure
	 */
	public function saveExtensionData($code = null, $data = [], $log_activity = FALSE)
	{
		if (empty($data)) return FALSE;

		!isset($data['ext_data']) OR $data = $data['ext_data'];

		return $this->updateSettings($code, $data, $log_activity);
	}

	/**
	 * Find an existing extension in filesystem by folder name
	 *
	 * @param string $code
	 *
	 * @return bool TRUE on success, FALSE on failure
	 */
	public static function extensionExists($code)
	{
		return ExtensionManager::instance()->hasExtension($code);
	}

	/**
	 * Install a new or existing extension by code
	 *
	 * @param string $code
	 * @param object $extension Extension
	 *
	 * @return bool|null
	 */
	public static function install($code = '', $extension)
	{
		$code = str_slug(strtolower($code), '-');

		if (!self::extensionExists($code))
            return FALSE;

        $extensionModel = self::firstOrNew(['type' => 'module', 'name' => $code]);

        if ($extensionModel AND $extensionModel->meta) {
            $extensionModel->fill([
                'title' => $extensionModel->meta['name'],
                'status' => '1',
                'version' => $extensionModel->meta['version']
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
            } else {
                $query = $extensionModel->fill(['status' => '0'])->save();
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
        $extensionModel = self::where('name', $code)->first();

        $deletedData = false;
        if ($extensionModel AND $deleteData) {
            $deletedData = $extensionModel->delete();
        }

        // Lets make sure extension files are deleted
        // since deleting the model also triggers
        // deleting the extension files
        if (!$deletedData)
            ExtensionManager::instance()->removeExtension($code);

        return TRUE;
	}

	/**
	 * Return all extension paths
	 *
	 * @return array
	 */
	protected function fetchExtensionsPath()
	{
		$results = [];

		foreach (ExtensionManager::instance()->paths() as $code => $path) {
			if (!ExtensionManager::instance()->hasExtension($code)) {
				$results[] = $path;
			}
		}

		return $results;
	}
}