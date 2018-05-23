<?php namespace System\Classes;

use App;
use Carbon\Carbon;
use Config;
use Exception;
use Main\Classes\ThemeManager;
use Schema;
use ZipArchive;

/**
 * TastyIgniter Updates Manager Class
 * @package System
 */
class UpdateManager
{
    use \Igniter\Flame\Traits\Singleton;

    protected $logs = [];

    protected $baseDirectory;

    protected $tempDirectory;

    protected $logFile;

    protected $updatedFiles;

    protected $installedItems;

    /**
     * @var ThemeManager
     */
    protected $themeManager;

    /**
     * @var HubManager
     */
    protected $hubManager;

    /**
     * @var ExtensionManager
     */
    protected $extensionManager;

    /**
     * @var \Igniter\Flame\Database\Migrations\Migrator
     */
    protected $migrator;

    /**
     * @var \Igniter\Flame\Database\Migrations\DatabaseMigrationRepository
     */
    public $repository;

    public function initialize()
    {
        $this->hubManager = HubManager::instance();
        $this->extensionManager = ExtensionManager::instance();
        $this->themeManager = ThemeManager::instance();

        $this->tempDirectory = temp_path();
        $this->baseDirectory = base_path();

        $this->bindContainerObjects();
    }

    public function bindContainerObjects()
    {
        $this->migrator = App::make('migrator');
        $this->repository = App::make('migration.repository');
    }

    public function log($message)
    {
        $this->logs[] = $message;

        return $this;
    }

    /**
     * @return \System\Classes\UpdateManager $this
     */
    public function resetLogs()
    {
        $this->logs = [];

        return $this;
    }

    public function getLogs()
    {
        return $this->logs;
    }

    public function down()
    {
        // Rollback extensions
        $extensions = $this->extensionManager->getExtensions();
        foreach ($extensions as $code => $extension) {
            $this->purgeExtension($code);
        }

        // Rollback app
        $modules = Config::get('system.modules', []);
        foreach ($modules as $module) {
            $path = $this->getMigrationPath($module);
            $this->migrator->rollbackAll([$module => $path]);

            $this->log($module);
            foreach ($this->migrator->getNotes() as $note) {
                $this->log(' - '.$note);
            }
        }

        $this->repository->deleteRepository();

        return $this;
    }

    public function update()
    {
        $wasPreviouslyMigrated = $this->prepareDatabase();

        // Update app
        $modules = Config::get('system.modules', []);
        foreach ($modules as $module) {
            $this->migrateApp($module);
        }

        // Seed app
        if (!$wasPreviouslyMigrated) {
            foreach ($modules as $module) {
                $this->seedApp($module);
            }
        }

        // Update extensions
        $extensions = $this->extensionManager->listByDependencies();
        foreach ($extensions as $extension) {
            $this->migrateExtension($extension);
        }

        return $this;
    }

    public function applyCoreVersion($sysVersion, $sysHash)
    {
        params()->set('ti_version', $sysVersion);
        params()->set('sys_hash', $sysHash);
        params()->save();
    }

    protected function prepareDatabase()
    {
        $migrationTable = Config::get('database.migrations', 'migrations');

        if ($hasColumn = Schema::hasColumns($migrationTable, ['group', 'batch'])) {
            $this->log('Migration table already created');

            return true;
        }

        $this->repository->createRepository();

        $action = $hasColumn ? 'updated' : 'created';
        $this->log("Migration table {$action}");
    }

    public function migrateApp($app)
    {
        $path = $this->getMigrationPath($app);

        $this->migrator->run([$app => $path]);

        $this->log($app);
        foreach ($this->migrator->getNotes() as $note) {
            $this->log(' - '.$note);
        }

        return $this;
    }

    public function seedApp($app)
    {
        $className = '\\'.$app.'\Database\Seeds\DatabaseSeeder';
        if (!class_exists($className))
            return FALSE;

        $seeder = App::make($className);
        $seeder->run();

        $this->log(sprintf('<info>Seeded %s</info> ', $app));

        return $this;
    }

    public function migrateExtension($name)
    {
        if (!($extension = $this->extensionManager->findExtension($name))) {
            $this->log('<error>Unable to find:</error> '.$name);

            return FALSE;
        }

        $extensionName = array_get($extension->extensionMeta(), 'name');
        $this->log($extensionName);
        $path = $this->getMigrationPath($this->extensionManager->getNamePath($name));
        $this->migrator->run([$name => $path]);

        foreach ($this->migrator->getNotes() as $note) {
            $this->log(' - '.$note);
        }

        return $this;
    }

    public function purgeExtension($name)
    {
        if (!($extension = $this->extensionManager->findExtension($name))) {
            $this->log('<error>Unable to find:</error> '.$name);

            return FALSE;
        }

        $path = $this->getMigrationPath($this->extensionManager->getNamePath($name));
        $this->migrator->rollbackAll([$name => $path]);

        $extensionName = array_get($extension->extensionMeta(), 'name');
        $this->log($extensionName);
        foreach ($this->migrator->getNotes() as $note) {
            $this->log(' - '.$note);
        }

        return $this;
    }

    /**
     * Get migration directory path.
     *
     * @param string $name
     *
     * @return string
     */
    protected function getMigrationPath($name)
    {
        if (in_array($name, Config::get('system.modules', [])))
            return app_path(strtolower($name).'/database/migrations');

        return extension_path($name.'/database/migrations');
    }

    //
    //
    //

    public function isLastCheckDue()
    {
        $response = $this->requestUpdateList(FALSE);

        if (isset($response['last_check'])) {
            return (strtotime('-7 day') < strtotime($response['last_check']));
        }

        return TRUE;
    }

    public function listItems($itemType)
    {
        $installedItems = $this->getInstalledItems();

        $items = $this->getHubManager()->listItems([
            'browse' => 'popular',
            'type'   => $itemType,
        ]);

        $installedItems = array_column($installedItems, 'name');
        if (isset($items['data'])) foreach ($items['data'] as &$item) {
            $item['installed'] = in_array($item['code'], $installedItems);
        }

        return $items;
    }

    public function searchItems($itemType, $searchQuery)
    {
        $installedItems = $this->getInstalledItems();

        $items = $this->getHubManager()->listItems([
            'type'   => $itemType,
            'search' => $searchQuery,
        ]);

        $installedItems = array_column($installedItems, 'name');
        if (isset($items['data'])) foreach ($items['data'] as &$item) {
            $item['installed'] = in_array($item['code'], $installedItems);
        }

        return $items;
    }

    public function getSiteDetail()
    {
        return params('carte_info');
    }

    public function applySiteDetail($key)
    {
        $info = [];
        $result = $this->getHubManager()->getDetail('site');
        if (isset($result['data']) AND is_array($result['data']))
            $info = $result['data'];

        $this->getHubManager()->setSecurity($key, $info);

        return $info;
    }

    public function requestUpdateList($force = FALSE)
    {
        $installedItems = $this->getInstalledItems();

        $updates = $this->hubManager->applyItemsToUpdate($installedItems, $force);

        if (is_string($updates))
            return $updates;

        $result = $items = $ignoredItems = [];
        $result['last_check'] = $updates['check_time'] ?? Carbon::now()->toDateTimeString();

        $installedItems = collect($installedItems)->keyBy('name')->all();

        $updateCount = 0;
        foreach (array_get($updates, 'data', []) as $update) {
            $updateCount++;
            $installedItem = array_get($installedItems, $update['code']);
            $installedItemCode = array_get($installedItem, 'name');
            $installedItemVersion = array_get($installedItem, 'ver');
            $update['ver'] = $installedItemVersion;

            if ($this->isUpdateIgnored($installedItemCode, $installedItemVersion)) {
                $ignoredItems[] = $update;
                continue;
            }

            $items[] = $update;
        }

        $result['count'] = $updateCount;
        $result['items'] = $items;
        $result['ignoredItems'] = $ignoredItems;

        return $result;
    }

    public function getInstalledItems($type = null)
    {
        if ($this->installedItems)
            return ($type AND isset($this->installedItems[$type]))
                ? $this->installedItems[$type] : $this->installedItems;

        $installedItems = [];

        foreach ($this->extensionManager->listExtensions() as $extensionCode) {
            $extensionObj = $this->extensionManager->findExtension($extensionCode);
            if ($extensionObj AND $meta = $extensionObj->extensionMeta()) {
                $installedItems['extensions'][] = [
                    'name' => $extensionCode,
                    'ver'  => $meta['version'],
                    'type' => 'extension',
                ];
            }
        }

        $themeManager = $this->getThemeManager();
        foreach ($themeManager->listThemes() as $themeCode) {
            if ($theme = $themeManager->findTheme($themeCode)) {
                $installedItems['themes'][] = [
                    'name' => $theme->name,
                    'ver'  => $theme->version ?? null,
                    'type' => 'theme',
                ];
            }
        }

        $this->installedItems = array_collapse($installedItems);

        if (!is_null($type))
            return $installedItems[$type] ?? [];

        return $this->installedItems;
    }

    public function requestApplyItems($names)
    {
        $applies = $this->getHubManager()->applyItems($names);

        if (isset($applies['data'])) foreach ($applies['data'] as $index => $item) {
            if ($this->isUpdateIgnored($item['code'], $item['version']))
                unset($applies['data'][$index]);
        }

        return $applies;
    }

    public function ignoreUpdates($names)
    {
        $ignoredUpdates = $this->getIgnoredUpdates();

        foreach ($names as $item) {
            if (!isset($item['ver']) OR !version_compare($item['ver'], '0.0.1', '>'))
                continue;

            if (array_get($item, 'action', 'ignore') == 'remove') {
                unset($ignoredUpdates[$item['name']]);
                continue;
            }

            $ignoredUpdates[$item['name']] = $item['ver'];
        }

        setting()->set('ignored_updates', $ignoredUpdates);

        return TRUE;
    }

    public function getIgnoredUpdates()
    {
        return array_dot(setting()->get('ignored_updates', []));
    }

    public function isUpdateIgnored($code, $version)
    {
        $ignoredUpdates = $this->getIgnoredUpdates();

        $ignoredUpdateVersion = array_get($ignoredUpdates, $code);

        return strlen($version) AND $ignoredUpdateVersion == $version;
    }

    //
    //
    //

    public function downloadFile($fileCode, $fileHash, $params = [])
    {
        $filePath = $this->getFilePath($fileCode);

        if (!is_dir($fileDir = dirname($filePath)))
            mkdir($fileDir, 0777, TRUE);

        return $this->getHubManager()->downloadFile($filePath, $fileHash, $params);
    }

    public function extractCore($fileCode)
    {
        ini_set('max_execution_time', 3600);

        return $this->extractFile($fileCode);
    }

    public function extractFile($fileCode, $directory = null)
    {
        $filePath = $this->getFilePath($fileCode);
        $extractTo = base_path();
        if ($directory)
            $extractTo .= '/'.$directory.str_replace('.', '/', $fileCode);

        if (!file_exists($extractTo))
            mkdir($extractTo, 0777, TRUE);

        $zip = new ZipArchive();
        if ($zip->open($filePath) === TRUE) {
            $zip->extractTo($extractTo);
            $zip->close();
            @unlink($filePath);

            return TRUE;
        }

        throw new Exception('Failed to extract '.$fileCode.' archive file');
    }

    public function getFilePath($fileCode)
    {
        $fileName = md5($fileCode).'.zip';

        return storage_path("temp/{$fileName}");
    }

    /**
     * @return \System\Classes\HubManager
     */
    protected function getHubManager()
    {
        return $this->hubManager;
    }

    /**
     * @return \Main\Classes\ThemeManager
     */
    protected function getThemeManager()
    {
        return $this->themeManager;
    }
}
