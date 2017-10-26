<?php namespace System\Classes;

use App;
use Config;
use Exception;
use File;
use Igniter\Flame\Traits\Singleton;
use Main\Classes\ThemeManager;
use Schema;
use ZipArchive;

/**
 * TastyIgniter Updates Manager Class
 * @package System
 */
class UpdateManager
{
    use Singleton;

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
     * @var \System\Classes\InstallerManager
     */
    protected $installerManager;

    /**
     * @var ThemeManager
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
        $this->installerManager = InstallerManager::instance();
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
        $this->prepareDatabase();

        // Update app
        $modules = Config::get('system.modules', []);
        foreach ($modules as $module) {
            $this->migrateApp($module);
        }

        // Seed app
//        if ($this->repository->wasFreshlyMigrated) {
        foreach ($modules as $module) {
            $this->seedApp($module);
        }
//        }

        // Update extensions
        $extensions = $this->extensionManager->listByDependencies();
        foreach ($extensions as $extension) {
            $this->migrateExtension($extension);
        }

        return $this;
    }

    protected function prepareDatabase()
    {
        $migrationTable = Config::get('database.migrations', 'migrations');

        if ($hasColumn = Schema::hasColumns($migrationTable, ['group', 'batch'])) {
            $this->log('Migration table already created');

            return;
        }

        $this->repository->createRepository();

        $action = $this->repository->wasFreshlyMigrated ? 'created' : 'updated';
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
            return false;

        $seeder = App::make($className);
        $seeder->run();

        $this->log(sprintf('<info>Seeded %s</info> ', $app));

        return $this;
    }

    public function migrateExtension($name)
    {
        if (!($extension = $this->extensionManager->findExtension($name))) {
            $this->log('<error>Unable to find:</error> '.$name);

            return false;
        }

        if (File::exists($path = $this->getMigrationPath($name))) {
            $this->migrator->run([$name => $path]);

            $this->log($name);
            foreach ($this->migrator->getNotes() as $note) {
                $this->log(' - '.$note);
            }
        }

        return $this;
    }

    public function purgeExtension($name)
    {
        if (!($extension = $this->extensionManager->findExtension($name))) {
            $this->log('<error>Unable to find:</error> '.$name);

            return false;
        }

        if (File::exists($path = $this->getMigrationPath($name))) {
            $this->migrator->rollbackAll([$name => $path]);

            $this->log($name);
            foreach ($this->migrator->getNotes() as $note) {
                $this->log(' - '.$note);
            }
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

    public function updateExtension($extensionCode)
    {
        $this->CI->load->model('Extensions_model');
        $this->CI->Extensions_model->updateInstalledExtensions($extensionCode);

        $extension = ExtensionManager::instance()->findExtension($extensionCode);
        $permissions = $extension->registerPermissions();
        $this->CI->Extensions_model->savePermissions($permissions);

        // set extension migration to the latest version
        ExtensionManager::instance()->updateExtension($extensionCode);

        return TRUE;
    }

    public function updateTheme($themeCode)
    {
        $this->CI->load->model('Themes_model');

        return $this->CI->Themes_model->updateInstalledThemes($themeCode);
    }

    public function updateTranslation($translationCode)
    {
        // @TODO: complete with new translation implementation
        return TRUE;
    }

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

        // cache recommended items for 6 hours.
        $cacheTime = 6 * 60 * 60;
        $items = $this->getHubManager()->setCacheLife($cacheTime)->listItems([
            'browse' => 'recommended',
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

    public function getSiteDetail($key = null)
    {
        if (!is_null($key)) {
            $this->getHubManager()->setSecurity($key);

            $result = $this->getHubManager()->getDetail('site');
            if (isset($result['data']) AND is_array($result['data']))
                setting()->add('carte_info', $result['data']);
        }

        return setting('carte_info');
    }

    public function requestUpdateList($force = FALSE)
    {
        // Delete setting entry as its no longer in use... remove code in next version
//        if ($this->config->item('last_version_check'))
        params()->forget('prefs', 'last_version_check');

        $installedItems = $this->getInstalledItems();

        // cache updates for 6 hours.
        $cacheTime = 6 * 60 * 60;
        $updates = $this->getHubManager()->setCacheLife($cacheTime)->applyItemsToUpdate($installedItems, $force);
        if (is_string($updates))
            return $updates;

        $result = $items = $ignoredUpdates = [];
        $result['last_check'] = mdate('%d-%m-%Y %H:%i:%s', isset($updates['check_time']) ? $updates['check_time'] : time());

        $installedItems = collect($installedItems)->keyBy('name')->all();

        $updateCount = 0;
        foreach ($updates['data'] as $update) {

            switch ($update['type']) {
                case 'extension':
                    if (ExtensionManager::instance()->isDisabled($update['code']))
                        continue 2;
                    break;
                case 'theme':
                    if (!$this->getThemeManager()->hasTheme($update['code']))
                        continue 2;
                    break;
//                case 'translation':
//                    break;
            }

            $updateCount++;
            $update['ver'] = $installedItems[$update['code']]['ver'];

            if ($this->isUpdateIgnored($update)) {
                $ignoredUpdates[] = $update;
                continue;
            }

            $items[] = $update;
        }

        $result['count'] = $updateCount;
        $result['items'] = $items;
        $result['ignored'] = $ignoredUpdates;

        return $result;
    }

    public function getInstalledItems($type = null)
    {
        if ($this->installedItems)
            return isset($this->installedItems[$type]) ? $this->installedItems[$type] : $this->installedItems;

        $installedItems = [];

        foreach (ExtensionManager::instance()->listExtensions() as $extension) {
            if ($extension = ExtensionManager::instance()->findExtension($extension) AND $meta = $extension->extensionMeta()) {
                $installedItems['extensions'][] = [
                    'name' => $meta['code'],
                    'ver'  => $meta['version'],
                    'type' => 'extension',
                ];
            }
        }

        $themeManager = $this->getThemeManager();
        foreach ($themeManager->listThemes() as $themeCode) {
            if ($meta = $themeManager->themeMeta($themeCode)) {
                $installedItems['themes'][] = [
                    'name' => $themeCode,
                    'ver'  => isset($meta['version']) ? $meta['version'] : null,
                    'type' => 'theme',
                ];
            }
        }

        $this->installedItems = array_collapse($installedItems);

        if (!is_null($type))
            return isset($installedItems[$type]) ? $installedItems[$type] : [];

        return $this->installedItems;
    }

    public function applyItems($names, $context = 'update')
    {
        $applies = $this->getHubManager()->applyItems('core', $names);

        if (isset($applies['data'])) foreach ($applies['data'] as $index => $item) {
            if ($context == 'update' AND $this->isUpdateIgnored($item))
                unset($applies['data'][$index]);
        }

        return $applies;
    }

    public function ignoreUpdates($names)
    {
        $ignoredUpdates = $this->config->item('ignored_updates');

        foreach ($names as $item) {
            if (!isset($item['ver']) OR !version_compare($item['ver'], '0.0.1', '>'))
                continue;

            if (isset($item['action']) AND $item['action'] == 'remove') {
                unset($ignoredUpdates[$item['name']]);
                continue;
            }

            $ignoredUpdates[$item['name']] = $item;
        }

        setting()->add('ignored_updates', $ignoredUpdates);
        $this->config->set_item('ignored_updates', $ignoredUpdates);

        return TRUE;
    }

    public function getIgnoredUpdates()
    {
        $ignoredUpdates = setting('ignored_updates');

        return is_array($ignoredUpdates) ? $ignoredUpdates : [];
    }

    public function isUpdateIgnored($update = [])
    {
        $ignoredUpdates = $this->getIgnoredUpdates();

        if (!isset($update['code']))
            return FALSE;

        if (!isset($ignoredUpdates[$update['code']]))
            return FALSE;

        $ignoredUpdate = $ignoredUpdates[$update['code']];

        if (!isset($ignoredUpdate['ver']))
            return TRUE;

        return isset($update['version']) AND $ignoredUpdate['ver'] == $update['version'];
    }

    public function downloadFile($fileCode, $fileHash, $params = [])
    {
        $filePath = $this->getFilePath($fileCode);

        if (!is_dir($fileDir = dirname($filePath)))
            mkdir($fileDir, 0777, TRUE);

        return $this->getHubManager()->downloadFile('core', $filePath, $fileHash, $params);
    }

    public function extractCore($fileCode)
    {
        ini_set('max_execution_time', 3600);

        $extractTo = $this->getBaseDirectory('core');

        if (!$this->extractTo($fileCode, $extractTo, TRUE))
            throw new Exception('Failed to extract %s archive file', $fileCode);

        return TRUE;
    }

    public function extractFile($fileCode, $fileType)
    {
        $extractTo = $this->getBaseDirectory($fileType);

        if (!$this->extractTo($fileCode, $extractTo.$fileCode))
            throw new Exception('Failed to extract %s archive file', $fileCode);

        return TRUE;
    }

    public function getBaseDirectory($fileType)
    {
        switch ($fileType) {
            case 'core':
                return base_path();
            case 'extension':
                return current(ExtensionManager::instance()->folders());
            case 'theme':
                return $this->getThemeManager()->folders()[MAINDIR];
            case 'translation':
                break; // @TODO improve translations
        }
    }

    /**
     * Extract a directory contents within a zip File
     *
     * @param string $fileCode
     * @param string $extractTo
     * @param bool $checkIgnored
     *
     * @return string
     */
    public function extractTo($fileCode, $extractTo, $checkIgnored = FALSE)
    {
        if (!class_exists('ZipArchive')) return FALSE;

        $zip = new ZipArchive();

        $zipPath = $this->getFilePath($fileCode);
        if (!file_exists($zipPath)) return FALSE;

        chmod($zipPath, 0777);

        if ($zip->open($zipPath) === TRUE) {
//            $dirname = trim($zip->getNameIndex(0), DIRECTORY_SEPARATOR);
            $extractTo = rtrim($extractTo, DIRECTORY_SEPARATOR);

            for ($i = 0; $i < $zip->numFiles; $i++) {
                $filename = $zip->getNameIndex($i);

//                $pathToCopy = substr($filename, mb_strlen($dirname, "UTF-8"));
//                var_dump($pathToCopy);
                $relativePath = $extractTo.DIRECTORY_SEPARATOR.$filename;

                // Ignore the themes, extensions, logs and sessions folder
                if ($checkIgnored AND $this->isFileIgnored($filename)) continue;

                if (substr($filename, -1) == '/') {
                    // Delete existing directory to replace all contents
                    if (!is_dir($relativePath))
                        mkdir($relativePath, 0777, TRUE);
                }
                else {
                    $this->copyFiles("zip://".$zipPath."#".$filename, $relativePath);
                }
            }
        }

        @unlink($zipPath);
        log_message('debug', sprintf("Extracted {$fileCode} files: %s", json_encode($this->updatedFiles)));

        return TRUE;
    }

    public function getFilePath($fileCode)
    {
        $fileName = md5($fileCode).'.zip';

        return storage_path("temp/{$fileName}");
    }

    protected function getIgnoredFiles()
    {
        $ignitePath = rtrim(str_replace(ROOTPATH, '', IGNITEPATH), DIRECTORY_SEPARATOR);

        $ignoredFiles = [
            '/tests',
            '/'.MAINDIR.'/views/themes',
            '/extensions',
            '/setup',
            '/'.$ignitePath.'/logs',
            '/'.$ignitePath.'/session',
            '/'.$ignitePath.'/config/database.php',
        ];

        return $ignoredFiles;
    }

    protected function isFileIgnored($file)
    {
        foreach ($this->getIgnoredFiles() as $ignoredFile) {
            if (strpos($file, $ignoredFile) !== FALSE)
                return TRUE;
        }

        return FALSE;
    }

    protected function copyFiles($source, $destination)
    {
        $source = rtrim($source, '/');
        $destination = rtrim($destination, '/');
        $baseDir = trim(str_replace(rtrim(ROOTPATH, '/'), '', $destination), '/');

        if (!is_dir($dir = dirname($destination)))
            mkdir($dir, 0777, TRUE);

        if (file_exists($destination)) {
            if ($this->isFilesIdentical($source, $destination) === FALSE) {
                $this->updatedFiles['modified'][] = $baseDir;
            }
            else {
                $this->updatedFiles['unchanged'][] = $baseDir;
            }
        }
        else {
            $this->updatedFiles['added'][] = $baseDir;
        }

        if (!copy($source, $destination)) {
            $this->updatedFiles['failed'][] = $baseDir;
        }
    }

    protected function isFilesIdentical($file_one, $file_two)
    {
        // Check if filesize is different
        if (@filesize($file_one) !== @filesize($file_two)) {
            return FALSE;
        }

        // Check if content is different
        $open_file_one = @fopen($file_one, 'rb');
        $open_file_two = @fopen($file_two, 'rb');

        $result = TRUE;
        while (!@feof($open_file_one)) {
            if (@fread($open_file_one, 8192) != @fread($open_file_two, 8192)) {
                $result = FALSE;
                break;
            }
        }

        @fclose($open_file_one);
        @fclose($open_file_two);

        return $result;
    }

    /**
     * @return \System\Classes\HubManager
     */
    protected function getHubManager()
    {
        return $this->hubManager;
    }

    /**
     * @return \System\Classes\InstallerManager
     */
    protected function getInstallerManager()
    {
        return $this->installerManager;
    }

    /**
     * @return \Main\Classes\ThemeManager
     */
    protected function getThemeManager()
    {
        return $this->themeManager;
    }

//    public function __get($name)
//    {
//        return get_instance()->$name;
//    }
}
