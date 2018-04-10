<?php

/**
 * SetupController Class
 */
class SetupController
{
    const TI_ENDPOINT = 'https://api.tastyigniter.io/v2';

    const COMPOSER_INSTALLER_URL = 'https://getcomposer.org/composer.phar';

    const COMPOSER_EXTRACTED_PHAR = 'extracted_phar';

    const COMPOSER_PHAR = 'composer.phar';

    const COMPOSER_VENDOR = 'vendor';

    public $page;

    public $logFile;

    public function __construct()
    {
        // Establish directory paths
        $this->baseDirectory = BASEPATH;
        $this->tempDirectory = SETUPPATH.'/temp';
        $this->configDirectory = $this->baseDirectory.'/config';
        $this->logFile = SETUPPATH.'/setup.log';
        $this->writePostToLog();

        $this->repository = new SetupRepository(SETUPPATH.'/setup_config');

        // Execute post handler
        $this->execPostHandler();
    }

    public function getPage()
    {
        if (!$this->page)
            $this->page = new stdClass;

        $this->page->currentStep = 'requirement';

        return $this->page;
    }

    //
    // Post Handlers
    //

    public function onCheckRequirement()
    {
        $code = $this->post('code');
        $this->writeLog('System check: %s', $code);
        $result = FALSE;
        switch ($code) {
            case 'php':
                $result = version_compare(PHP_VERSION, TI_PHP_VERSION, ">=");
                break;
            case 'mysqli':
                $result = extension_loaded('mysqli') AND class_exists('Mysqli');
                break;
            case 'pdo':
                $result = defined('PDO::ATTR_DRIVER_NAME') OR class_exists('PDO');
                break;
            case 'mbstring':
                $result = extension_loaded('mbstring');
                break;
            case 'ssl':
                $result = extension_loaded('openssl');
                break;
            case 'gd':
                $result = extension_loaded('gd');
                break;
            case 'curl':
                $result = function_exists('curl_init') AND defined('CURLOPT_FOLLOWLOCATION');
                break;
            case 'zip':
                $result = class_exists('ZipArchive');
                break;
            case 'uploads':
                $result = ini_get('file_uploads');
                break;
            case 'connection':
                $result = ($this->requestRemoteData('ping') !== null);
                break;
            case 'writable':
                $result = is_writable(BASEPATH) AND is_writable($this->logFile);
                break;
        }

        $this->repository->set('requirement', $result ? $code : 'fail')->save();

        $this->writeLog('Requirement %s %s', $code, ($result ? '+OK' : '=FAIL'));

        return ['result' => $result];
    }

    public function onCheckLicense()
    {
        if ($this->post('license_agreed') != 1)
            throw new SetupException('Please accept the TastyIgniter license before proceeding.');

        if (($requirement = $this->post('requirement')) != 'complete')
            throw new SetupException('Error checking server requirements, please make sure all lights are green.');

        $this->repository->set('requirement', $requirement)->save();

        $this->writeLog('License & requirement check: %s', $requirement);

        return ['step' => 'database'];
    }

    public function onCheckDatabase()
    {
        $database = $this->post('database');
        $this->writeLog('Database check: %s', $database);

        $this->confirmRequirements();

        if (!strlen($this->post('host')))
            throw new SetupException('Please specify a database host');

        if (!strlen($database = $this->post('database')))
            throw new SetupException('Please specify the database name');

        if (!$config = $this->testDbConnection($this->post())) {
            return [
                'flash' => [
                    'type'    => 'warning',
                    'message' => sprintf(
                        'Database "%s" is not empty. Please empty the database or specify a different database table prefix.',
                        $this->e($database)
                    ),
                ],
            ];
        }

        $result = $this->verifyDbConfiguration($config);

        $this->repository->set('database', $result);
        $result = $this->repository->save();

        $this->writeLog('Database %s %s', $database, ($result ? '+OK' : '=FAIL'));

        return $result ? ['step' => 'settings'] : ['result' => $result];
    }

    public function onValidateSettings()
    {
        $siteName = $this->post('site_name');
        $this->writeLog('Settings check: %s', $siteName);

        $this->confirmRequirements();

        if (!strlen($siteName))
            throw new SetupException('Please specify your restaurant name');

        if (!strlen($siteEmail = $this->post('site_email')))
            throw new SetupException('Please specify your restaurant email');

        if (!strlen($adminName = $this->post('staff_name')))
            throw new SetupException('Please specify the administrator name');

        if (!strlen($username = $this->post('username')))
            throw new SetupException('Please specify the administrator username');

        if (!strlen($password = $this->post('password'))
            OR strlen($password = $this->post('password')) < 6
        )
            throw new SetupException('Please specify the administrator password, at least 6 characters');

        if (!strlen($this->post('confirm_password')))
            throw new SetupException('Please confirm the administrator password');

        if ($this->post('confirm_password') != $password)
            throw new SetupException('Password does not match');

        $this->repository->set('settings', [
            'include_demo' => ($this->post('demo_data') == '1'),
            'use_multi'    => ($this->post('site_location_mode') == 'multiple'),
            'site_name'    => $siteName,
            'site_email'   => $siteEmail,
            'staff_name'   => $adminName,
            'username'     => $username,
            'password'     => $password,
        ]);

        $result = $this->repository->save();
        $this->writeLog('Settings %s', ($result ? '+OK' : '=FAIL'));

        return $result ? ['step' => 'install'] : ['result' => $result];
    }

    public function onFetchItems()
    {
        return $this->requestRemoteData('items', [
            'browse'  => 'popular',
            'type'    => 'theme',
            'include' => 'require',
        ]);
    }

    public function onInstall()
    {
        $installStep = $this->post('process');
        $this->writeLog('Foundation setup: %s', $installStep);
        $result = FALSE;

        $item = $this->post('item');

        $params = [];
        if ($this->post('step') != 'complete' AND isset($item['code'])) {
            $params = [
                'name'   => $item['code'],
                'type'   => $item['type'],
                'ver'    => $item['version'],
                'action' => $item['action'],
            ];
        }

        switch ($installStep) {
            case 'apply':
                $result = $this->applyInstall();
                break;
            case 'downloadExtension':
            case 'downloadTheme':
            case 'downloadCore':
                if ($this->downloadFile($item['code'], $item['hash'], $params))
                    $result = TRUE;
                break;
            case 'extractExtension':
                if ($this->extractFile($item['code'], 'extensions/'))
                    $result = TRUE;
                break;
            case 'extractTheme':
                if ($this->extractFile($item['code'], 'themes/'))
                    $result = TRUE;

                $this->repository->set('activeTheme', $item['code']);
                break;
            case 'extractCore':
                if ($this->extractFile($item['code']))
                    $result = TRUE;

                $this->repository->set('core', $item);
                break;
            case 'finishInstall':
                $this->writeExampleFiles();

                // Boot framework and run migration
                $this->completeSetup();
                $this->completeInstall();
                $this->cleanUpAfterInstall();

                $result = admin_url('login');
                break;
        }

        $status = $installStep == 'install' ? 'complete' : $installStep;
        $this->repository->set('install', $result ? $status : 'fail')->save();

        $this->writeLog('Foundation setup: %s %s', $installStep, ($result ? '+OK' : '=FAIL'));

        return ['result' => $result];
    }

    protected function execPostHandler()
    {
        $handler = $this->post('handler');
        if (!is_null($handler)) {
            if (!strlen($handler)) exit;

            try {
                if (!preg_match('/^on[A-Z]{1}[\w+]*$/', $handler))
                    throw new SetupException(sprintf('Invalid handler: %s', $this->e($handler)));
                if (method_exists($this, $handler) AND ($result = $this->$handler()) !== null) {
                    $this->writeLog('Execute handler (%s): %s', $handler, print_r($result, TRUE));
                    header('Content-Type: application/json');
                    die(json_encode($result));
                }
            } catch (Exception $ex) {
                header($_SERVER['SERVER_PROTOCOL'].' 500 Internal Server Error', TRUE, 500);
                $this->writeLog('Handler error (%s): %s', $handler, $ex->getMessage());
                $this->writeLog(['Trace log:', '%s'], $ex->getTraceAsString());
                die($ex->getMessage());
            }
            exit;
        }
    }

    //
    // Database
    //

    public function checkDatabase()
    {
        if (!$config = $this->repository->get('database', []))
            return FALSE;

        // Make sure the database name is specified
        if (!isset($config['host']))
            return FALSE;

        try {
            $this->testDbConnection($config);
        } catch (Exception $ex) {
            return FALSE;
        }

        // At this point,
        // its clear database configuration is set
        // and connection successful
        return TRUE;
    }

    protected function testDbConnection($db = [])
    {
        $config = $this->verifyDbConfiguration($db);

        extract($config);

        // Try connecting to database using the specified driver
        $dsn = 'mysql:host='.$host.';dbname='.$database;
        if ($port) $dsn .= ";port=".$port;

        try {
            $db = new PDO($dsn, $username, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
        } catch (PDOException $ex) {
            throw new SetupException('Connection failed: '.$ex->getMessage());
        }

        // Check the database table prefix is empty
        $fetch = $db->query("show tables where tables_in_{$database} like '".str_replace('_', '\\_', $prefix)."%'", PDO::FETCH_NUM);

        $tables = 0;
        while ($result = $fetch->fetch()) $tables++;
        if ($tables > 0) {
            return FALSE;
        }

        return $config;
    }

    protected function verifyDbConfiguration($config)
    {
        $result = [];
        $result['host'] = '127.0.0.1';
        if (isset($config['host']) AND is_string($config['host']))
            $result['host'] = trim($config['host']);

        $result['port'] = 3306;
        if (isset($config['port']) AND is_string($config['port']))
            $result['port'] = trim($config['port']);

        $result['database'] = '';
        if (isset($config['database']) AND is_string($config['database']))
            $result['database'] = trim($config['database']);

        $result['username'] = '';
        if (isset($config['username']) AND is_string($config['username']))
            $result['username'] = trim($config['username']);

        $result['password'] = '';
        if (isset($config['password']) AND is_string($config['password']))
            $result['password'] = $config['password'];

        $result['prefix'] = 'ti_';
        if (isset($config['prefix']) AND is_string($config['prefix']))
            $result['prefix'] = trim($config['prefix']);

        return $result;
    }

    //
    // Setup steps
    //

    protected function applyInstall()
    {
        $params = [];

        if ($themeCode = $this->post('code'))
            $params['items'] = json_encode([
                [
                    'name'   => $themeCode,
                    'type'   => 'theme',
                    'action' => 'install',
                ],
            ]);

        if ($siteKey = $this->post('site_key'))
            $params['site_key'] = $siteKey;

        $response = $this->requestRemoteData('core/install', $params);

        return $this->buildProcessSteps($response);
    }

    protected function buildProcessSteps($meta)
    {
        $processSteps = [];

        foreach (['download', 'extract', 'install'] as $step) {

            $applySteps = [];

            if ($step == 'install') {
                $processSteps[$step][] = [
                    'items'   => $meta['data'],
                    'process' => 'finishInstall',
                ];

                continue;
            }

            foreach ($meta['data'] as $item) {
                if ($item['type'] == 'core') {
                    $applySteps[] = array_merge([
                        'action'  => 'install',
                        'process' => "{$step}Core",
                    ], $item);
                }
                else {
                    $singularType = $item['type'];

                    $applySteps[] = array_merge([
                        'action'  => 'install',
                        'process' => $step.ucfirst($singularType),
                    ], $item);
                }
            }

            $processSteps[$step] = $applySteps;
        }

        return $processSteps;
    }

    protected function completeSetup()
    {
        $this->bootFramework();

        // Install the database tables
        \System\Classes\UpdateManager::instance()->update();

        // Create the default location if not already created
        $this->createDefaultLocation();

        // Create the admin user if no admin exists.
        $this->createSuperUser();

        // Save the site configuration to the settings table
        $this->addSystemSettings();
    }

    protected function createDefaultLocation()
    {
        // Abort: a location already exists
        if (\Admin\Models\Locations_model::count())
            return TRUE;

        $config = $this->repository->get('settings');

        \Admin\Models\Locations_model::insert([
            'location_name'  => $config['site_name'],
            'location_email' => $config['site_email'],
        ]);
    }

    protected function createSuperUser()
    {
        // Abort: a super admin user already exists
        if (\Admin\Models\Users_model::where('super_user', 1)->count())
            return TRUE;

        $config = $this->repository->get('settings');

        $staffEmail = strtolower($config['site_email']);
        $staff = \Admin\Models\Staffs_model::firstOrNew([
            'staff_email' => $staffEmail,
        ]);

        $staff->staff_name = $config['staff_name'];
        $staff->staff_group_id = \Admin\Models\Staff_groups_model::first()->staff_group_id;
        $staff->staff_location_id = \Admin\Models\Locations_model::first()->location_id;
        $staff->language_id = \System\Models\Languages_model::first()->language_id;
        $staff->timezone = FALSE;
        $staff->staff_status = TRUE;
        $staff->save();

        $user = \Admin\Models\Users_model::firstOrNew([
            'username' => $config['username'],
        ]);

        $user->staff_id = $staff->staff_id;
        $user->password = $config['password'];
        $user->super_user = TRUE;
        $user->is_activated = TRUE;
        $user->date_activated = \Carbon\Carbon::now();

        return $user->save();
    }

    protected function addSystemSettings()
    {
        $core = $this->repository->get('core');
        $config = $this->repository->get('settings');

        $settings = [
            'site_name'           => $config['site_name'],
            'site_email'          => $config['site_email'],
            'site_location_mode'  => $config['use_multi'] ? 'multiple' : 'single',
            'ti_setup'            => 'installed',
            'ti_version'          => array_get($core, 'version'),
            'sys_hash'            => array_get($core, 'hash'),
            'site_key'            => isset($config['site_key']) ? $config['site_key'] : null,
            'default_location_id' => \Admin\Models\Locations_model::first()->location_id,
        ];

        $paramsKeyNames = ['ti_setup', 'ti_version', 'sys_hash', 'site_key', 'default_location_id'];
        foreach ($settings as $key => $value) {
            $setting = in_array($key, $paramsKeyNames)
                ? params() : setting();

            $setting->set($key, $value);
        }

        params()->save();
        setting()->save();
    }

    protected function completeInstall()
    {
        $item = $this->post('item');
        $items = isset($item['items']) ? $item['items'] : [];
        foreach ($items as $item) {
            if ($item['type'] != 'extension')
                continue;

            \System\Models\Extensions_model::install($item['code']);
        }

        \System\Models\Themes_model::syncAll();
        \System\Models\Themes_model::activateTheme($this->repository->get('activeTheme', 'demo'));
    }

    protected function cleanUpAfterInstall()
    {
        if (file_exists($this->tempDirectory)) {
            File::deleteDirectory($this->tempDirectory);
        }

        // Delete the setup repository file since its no longer needed
        $this->repository->destroy();
    }

    //
    // File
    //

    protected function getFilePath($fileCode)
    {
        $fileName = md5($fileCode).'.zip';

        return "{$this->tempDirectory}/{$fileName}";
    }

    protected function downloadFile($fileCode, $fileHash, $params)
    {
        return $this->requestRemoteFile('core/download', [
            'item' => json_encode($params),
        ], $fileCode, $fileHash);
    }

    protected function extractFile($fileCode, $directory = null)
    {
        $filePath = $this->getFilePath($fileCode);
        $this->writeLog('Extracting [%s] file %s', $fileCode, basename($filePath));

        $extractTo = $this->baseDirectory;
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

        $this->writeLog('Unable to open [%s] archive file %s', $fileCode, basename($filePath));

        return FALSE;
    }

    protected function writeExampleFiles()
    {
        $this->moveExampleFile('env', null, 'backup');
        $this->moveExampleFile('env', 'example', null);

        $exampleEnvFile = $this->baseDirectory.'/.env';
        $contents = file_get_contents($exampleEnvFile);

        foreach ($this->envReplacementPatterns() as $pattern => $replace) {
            $contents = preg_replace($pattern, $replace, $contents);
            putenv($replace);
        }

        file_put_contents($exampleEnvFile, $contents);

        $this->moveExampleFile('htaccess', null, 'backup');
        $this->moveExampleFile('htaccess', 'example', null);
    }

    protected function moveExampleFile($name, $old, $new)
    {
        // /$old.$name => /$new.$name
        if (file_exists($this->baseDirectory.'/'.$old.'.'.$name)) {
            rename(
                $this->baseDirectory.'/'.$old.'.'.$name,
                $this->baseDirectory.'/'.$new.'.'.$name
            );
        }
    }

    protected function envReplacementPatterns()
    {
        $setting = $this->repository->get('settings');
        $db = $this->repository->get('database');

        return [
            '/^APP_NAME=TastyIgniter/m' => 'APP_NAME='.$setting['site_name'],
            '/^APP_URL=/m'              => 'APP_URL='.$this->getBaseUrl(),
            '/^APP_KEY=/m'              => 'APP_KEY='.$this->generateKey(),
            '/^DB_HOST=127.0.0.1/m'     => 'DB_HOST='.$db['host'],
            '/^DB_DATABASE=database/m'  => 'DB_DATABASE='.$db['database'],
            '/^DB_USERNAME=username/m'  => 'DB_USERNAME='.$db['username'],
            '/^DB_PASSWORD=password/m'  => 'DB_PASSWORD='.$db['password'],
            '/^DB_PREFIX=ti_/m'         => 'DB_PREFIX='.$db['prefix'],
        ];
    }

    public static function generateKey()
    {
        return 'base64:'.base64_encode(random_bytes(32));
    }

    //
    // Helpers
    //

    public function getDatabaseDetails()
    {
        $defaults = [
            'database' => '',
            'host'     => '127.0.0.1',
            'port'     => 3306,
            'username' => '',
            'password' => '',
            'prefix'   => 'ti_',
        ];

        $settings = [];
        $db = $this->repository->get('database');
        foreach ($defaults as $item => $value) {
            if ($this->post($item)) {
                $settings[$item] = $this->post($item);
            }
            else if (isset($db[$item])) {
                $settings[$item] = $db[$item];
            }
            else {
                $settings[$item] = $value;
            }
        }

        return (object)$settings;
    }

    public function getSettingsDetails()
    {
        $defaults = [
            'site_location_mode' => 'single',
            'site_name'          => 'TastyIgniter',
            'site_email'         => 'admin@restaurant.com',
            'staff_name'         => 'Chef Sam',
            'username'           => 'admin',
            'demo_data'          => 1,
            'site_key'           => '',
        ];

        $settings = [];
        foreach ($defaults as $item => $value) {
            if ($this->post($item)) {
                $settings[$item] = $this->post($item);
            }
            else if ($this->repository->has($item)) {
                $settings[$item] = $this->repository->get($item);
            }
            else {
                $settings[$item] = $value;
            }
        }

        return (object)$settings;
    }

    protected function confirmRequirements()
    {
        $requirement = $this->post('requirement', $this->repository->get('requirement'));
        if (!strlen($requirement) OR $requirement != 'complete')
            throw new SetupException('Please make sure your system meets all requirements');
    }

    protected function bootFramework()
    {
        if (!is_file($this->baseDirectory.'/vendor/tastyigniter/flame/src/Support/helpers.php'))
            throw new SetupException('Missing vendor files.');

        $autoloadFile = $this->baseDirectory.'/bootstrap/autoload.php';
        if (!file_exists($autoloadFile))
            throw new SetupException('Autoloader file was not found.');

        include $autoloadFile;

        $appFile = $this->baseDirectory.'/bootstrap/app.php';
        if (!file_exists($appFile))
            throw new SetupException('App loader file was not found.');

        $app = require_once $appFile;
        $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
        $kernel->bootstrap();
    }

    protected function e($value)
    {
        return htmlentities($value, ENT_QUOTES, 'UTF-8', FALSE);
    }

    protected function server($key, $default = null)
    {
        if (array_key_exists($key, $_SERVER)) {
            $result = $_SERVER[$key];
            if (is_string($result)) $result = trim($result);

            return $result;
        }

        return $default;
    }

    protected function post($key = null, $default = null)
    {
        if (is_null($key))
            return $_POST;

        if (array_key_exists($key, $_POST)) {
            $result = $_POST[$key];
            if (is_string($result)) $result = trim($result);

            return $result;
        }

        return $default;
    }

    protected function session($key, $default = null)
    {
        if (array_key_exists($key, $_SESSION)) {
            $result = $_SESSION[$key];
            if (is_string($result)) $result = trim($result);

            return $result;
        }

        return $default;
    }

    protected function getBaseUrl()
    {
        if (isset($_SERVER['HTTP_HOST'])) {
            $baseUrl = (!empty($_SERVER['HTTPS']) AND strtolower($_SERVER['HTTPS']) !== 'off') ? 'https' : 'http';
            $baseUrl .= '://'.$_SERVER['HTTP_HOST'];
            $baseUrl .= str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);
        }
        else {
            $baseUrl = 'http://localhost/';
        }

        return $baseUrl;
    }

    protected function requestRemoteData($uri, $params = [])
    {
        $result = null;
        $error = null;
        try {
            $this->writeLog('Server request: %s', $uri);

            $curl = $this->prepareRequest($uri, $params);
            $result = curl_exec($curl);

            $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            if ($httpCode == 500) {
                $error = $result;
                $result = '';
            }

            $this->writeLog('Request information: %s', print_r(curl_getinfo($curl), TRUE));
            curl_close($curl);
        } catch (Exception $ex) {
            $this->writeLog('Failed to get server data (ignored): '.$ex->getMessage());
        }

        if ($error !== null)
            throw new SetupException('Server responded with error: '.$error);

        try {
            $_result = @json_decode($result, TRUE);
        } catch (Exception $ex) {
        }

        if (!is_array($_result)) {
            $this->writeLog('Server response: '.$result);
            throw new SetupException('Server returned an invalid response.');
        }

        if (isset($_result['message']) AND !in_array($httpCode, [200, 201])) {
            if (isset($_result['errors']))
                $this->writeLog('Server validation errors: '.print_r($_result['errors'], TRUE));

            throw new SetupException($_result['message']);
        }

        return $_result;
    }

    protected function requestRemoteFile($uri, $params = [], $code, $expectedHash)

    {
        if (!mkdir($this->tempDirectory, 0777, TRUE) AND !is_dir($this->tempDirectory))
            throw new SetupException(sprintf('Failed to create temp directory: %s', $this->tempDirectory));

        try {
            $filePath = $this->getFilePath($code);
            $curl = $this->prepareRequest($uri, $params);
            $fileStream = fopen($filePath, 'wb');
            curl_setopt($curl, CURLOPT_FILE, $fileStream);
            curl_exec($curl);

            $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            if ($httpCode == 500)
                throw new SetupException(file_get_contents($filePath));

            curl_close($curl);
            fclose($fileStream);
        } catch (Exception $ex) {
            $this->writeLog('Server responded with error: '.$ex->getMessage());
            throw new SetupException('Server responded with error: '.$ex->getMessage());
        }

        $fileSha = sha1_file($filePath);
        if ($expectedHash != $fileSha) {
            $this->writeLog(file_get_contents($filePath));
            $this->writeLog("Download failed, File hash mismatch: {$expectedHash} (expected) vs {$fileSha} (actual)");
            @unlink($filePath);
            throw new SetupException('Downloaded files from server are corrupt');
        }

        $this->writeLog('Downloaded file (%s) to %s', $code, $filePath);

        return TRUE;
    }

    protected function prepareRequest($uri, $params = [])
    {
        $params['url'] = base64_encode($this->getBaseUrl());

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, static::TI_ENDPOINT.'/'.$uri);
        curl_setopt($curl, CURLOPT_TIMEOUT, 3600);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($params, '', '&'));

        if (isset($params['site_key']) AND $siteKey = $params['site_key']) {
            curl_setopt($curl, CURLOPT_HTTPHEADER, ["TI-Rest-Key: bearer {$siteKey}"]);
        }

        return $curl;
    }

    //
    // Logging
    //

    public function cleanLog()
    {
        $message = '.++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++.'."\n";
        $message .= '.------------------- TASTYIGNITER SETUP LOG ------------------.'."\n";
        $message .= '.++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++.';
        file_put_contents($this->logFile, $message.PHP_EOL);
    }

    public function writeLog()
    {
        $args = func_get_args();

        $message = array_shift($args);
        if (is_array($message))
            $message = implode(PHP_EOL, $message);

        $date = "";
        if (!array_key_exists('hideTime', $args))
            $date = '['.date('Y/m/d h:i:s').'] => ';

        $message = vsprintf($date.$message, $args).PHP_EOL;

        file_put_contents($this->logFile, $message, FILE_APPEND);
    }

    protected function writePostToLog()
    {
        if (!isset($_POST) OR !count($_POST)) return;

        $postData = $_POST;
        if (array_key_exists('disableLog', $postData))
            $postData = ['disableLog' => TRUE];

        // Filter sensitive data fields
        $fieldsToErase = [
            'encryption_code',
            'admin_password',
            'admin_confirm_password',
            'db_pass',
            'project_id',
        ];

        if (isset($postData['admin_email'])) $postData['admin_email'] = '*******@*****.com';
        foreach ($fieldsToErase as $field) {
            if (isset($postData[$field])) $postData[$field] = '*******';
        }

        $this->writeLog('.============================ POST REQUEST ==========================.', ['hideTime' => TRUE]);
        $this->writeLog('Postback payload: %s', print_r($postData, TRUE));
    }
}