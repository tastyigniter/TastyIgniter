<?php

/**
 * SetupController Class
 */
class SetupController
{
    const TI_ENDPOINT = 'https://api.tastyigniter.com/v2';

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
        $this->tempDirectory = SETUPPATH.'/temp'; //
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
            $this->evalPage();

        return $this->page;
    }

    public function getDatabaseDetails()
    {
        $defaults = [
            'database' => '',
            'host'     => '127.0.0.1',
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

    protected function evalPage()
    {
        $this->page = new stdClass;

        if ($this->isBooted()) {
            $this->page->currentStep = 'proceed';
        }
        else {
            $this->page->currentStep = 'requirement';
        }
    }

    protected function isBooted()
    {
        if (!$this->vendorInstalled())
            return FALSE;

        if ($this->repository->get('install') != 'complete')
            return FALSE;

        if (!$this->checkDatabase())
            return FALSE;

        return TRUE;
    }

    //
    // Event Handlers
    //

    public function onCheckRequirement()
    {
        $code = $this->post('code');
        $this->writeLog('System check: %s', $code);
        $result = FALSE;
        switch ($code) {
            case 'connection':
                $result = ($this->requestRemoteData('ping') !== null);
                break;
            case 'writable':
                $result = is_writable(BASEPATH) AND is_writable($this->logFile);
                break;
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
        }

        $status = ($code == 'writable') ? 'complete' : $code;
        $this->repository->set('requirement', $result ? $status : 'fail')->save();
        $this->writeLog('Requirement %s %s', $code, ($result ? '+OK' : '=FAIL'));

        return ['result' => $result];
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

    public function onInstallDependencies()
    {
        $installStep = $this->post('step');
        $this->writeLog('Foundation framework check: %s', $installStep);
        $result = FALSE;

        if (!strlen($this->post('db')) OR $this->post('db') != 'success')
            throw new SetupException('Database connection was not successful');

        if ($installed = $this->confirmInstallation())
            $installStep = 'install';

        switch ($installStep) {
            case 'download':
                if ($this->downloadFoundation())
                    $result = TRUE;
                break;
            case 'extract':
                if ($this->extractFoundation())
                    $result = TRUE;
                break;
            case 'install':
                if ($installed OR $this->installFoundation())
                    $result = $this->getBaseUrl().'admin/settings';

                $this->writeExampleFiles();
                $this->cleanUpAfterInstall();
                break;
        }

        $status = $installStep == 'install' ? 'complete' : $installStep;
        $this->repository->set('install', $result ? $status : 'fail')->save();

        $this->writeLog('Foundation framework check: %s %s', $installStep, ($result ? '+OK' : '=FAIL'));

        return ['result' => $result];
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
        $port = 3306;

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
    // Install
    //

    protected function downloadFoundation()
    {
        $composerPhar = $this->tempDirectory.'/'.static::COMPOSER_PHAR;
        if (is_dir($composerPhar) OR $this->vendorExists()) {
            $this->writeLog('Skipping download: dependencies already installed.');

            return TRUE;
        }

        $this->ensureTempDirExists();

        try {
            $installerStream = fopen($composerPhar, 'w+');
            $curl = curl_init(static::COMPOSER_INSTALLER_URL);
            curl_setopt($curl, CURLOPT_HEADER, FALSE);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
            curl_setopt($curl, CURLOPT_FILE, $installerStream);
            $response = curl_exec($curl);

            $this->writeLog('Server request: %s', static::COMPOSER_INSTALLER_URL);
            $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            if ($httpCode == 500) {
                $this->writeLog('Request information: %s', print_r(curl_getinfo($curl), TRUE));
            }
            curl_close($curl);
        } catch (Exception $ex) {
            $this->writeLog('Failed to get server data (ignored): '.$ex->getMessage());
        }

        return file_exists($composerPhar);
    }

    protected function extractFoundation()
    {
        if ($this->vendorExists()) {
            $this->writeLog('Skipping extract: dependencies already installed.');

            return TRUE;
        }

        $composerPhar = $this->tempDirectory.'/'.static::COMPOSER_PHAR;
        $extractedPhar = $this->tempDirectory.'/'.static::COMPOSER_EXTRACTED_PHAR;
        if (!is_file($composerPhar))
            return FALSE;

        mkdir($extractedPhar, 0777, TRUE);
        $composer = new Phar($composerPhar);
        $composer->extractTo($extractedPhar);
        @unlink($composerPhar);

        return TRUE;
    }

    protected function installFoundation()
    {
        if ($this->vendorInstalled()) {
            $this->writeLog('Skipping install: dependencies already installed.');

            return TRUE;
        }

        $vendorPath = $this->tempDirectory.'/'.static::COMPOSER_EXTRACTED_PHAR.'/bin';
        if (!is_dir($vendorPath)) {
            $this->writeLog('Missing vendor autoload file');

            return FALSE;
        }

        $vendorPath = dirname($vendorPath);

        set_time_limit(-1);
        ini_set('memory_limit', -1); // @todo: remove later
        putenv("COMPOSER_HOME={$vendorPath}/bin/composer");
        require_once($vendorPath.'/vendor/autoload.php');

        ob_start();
        $command = $this->vendorInstalled() ? 'update' : 'install';
        $output = new Symfony\Component\Console\Output\StreamOutput(fopen('php://output', 'w'));
        $input = new Symfony\Component\Console\Input\StringInput($command.' -v -d '.$this->baseDirectory);
        $composerApp = new Composer\Console\Application();
        $composerApp->setAutoExit(FALSE);
        $composerApp->run($input, $output);
        $content = ob_get_contents();
        ob_end_clean();

        $this->writeLog('Composer Console output: %s => %s', $command, print_r($content, TRUE));

        if (!$this->vendorInstalled())
            return FALSE;

        return TRUE;
    }

    //
    // Logging
    //

    public function cleanLog()
    {
        $message = ".========================== SETUP LOG ========================.";
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
            $date = "[".date("Y/m/d h:i:s", time())."] => ";

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

    //
    // Helpers
    //

    public function e($value)
    {
        return htmlentities($value, ENT_QUOTES, 'UTF-8', FALSE);
    }

    protected function server($var, $default = null)
    {
        if (array_key_exists($var, $_SERVER)) {
            $result = $_SERVER[$var];
            if (is_string($result)) $result = trim($result);

            return $result;
        }

        return $default;
    }

    protected function post($var = null, $default = null)
    {
        if (is_null($var))
            return $_POST;

        if (array_key_exists($var, $_POST)) {
            $result = $_POST[$var];
            if (is_string($result)) $result = trim($result);

            return $result;
        }

        return $default;
    }

    protected function session($var, $default = null)
    {
        if (array_key_exists($var, $_SESSION)) {
            $result = $_SESSION[$var];
            if (is_string($result)) $result = trim($result);

            return $result;
        }

        return $default;
    }

    protected function vendorExists()
    {
        if ($this->vendorInstalled())
            return TRUE;

        $extractedPhar = $this->tempDirectory.'/'.static::COMPOSER_EXTRACTED_PHAR;

        return is_dir($extractedPhar.'/vendor');
    }

    protected function vendorInstalled()
    {
        if (!is_file($this->baseDirectory.'/vendor/tastyigniter/flame/src/Support/helpers.php'))
            return FALSE;

        if (!is_file($this->baseDirectory.'/vendor/laravel/framework/src/illuminate/support/helpers.php'))
            return FALSE;

        return TRUE;
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

    protected function getSysInfo()
    {
        $info = [
            'domain' => $this->getBaseUrl(),
            'ver'    => TI_VERSION,
            'web'    => isset($_SERVER['SERVER_SOFTWARE']) ? $_SERVER['SERVER_SOFTWARE'] : null,
            'os'     => php_uname(),
            'php'    => phpversion(),
        ];

        return $info;
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

    protected function requestRemoteData($uri = null, $params = [])
    {
        $result = null;
        $error = null;
        try {
            $curl = $this->prepareRequest($uri, $params);
            $result = curl_exec($curl);

            $this->writeLog('Server request: %s', $uri);
            $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            if ($httpCode == 500) {
                $result = '';
            }

            $this->writeLog('Request information: %s', print_r(curl_getinfo($curl), TRUE));
            curl_close($curl);
        } catch (Exception $ex) {
            $this->writeLog('Failed to get server data (ignored): '.$ex->getMessage());
        }

        if (!$result || !strlen($result))
            throw new SetupException('Server responded with no response.');

        try {
            $_result = @json_decode($result, TRUE);
        } catch (Exception $ex) {
        }

        if (!is_array($_result)) {
            $this->writeLog('Server response: '.$result);
            throw new SetupException('Server returned an invalid response.');
        }

        return $_result;
    }

    protected function prepareRequest($uri, $params)
    {
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, static::TI_ENDPOINT.'/'.$uri);
        curl_setopt($curl, CURLOPT_TIMEOUT, 3600);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);

        if (isset($_SERVER['HTTP_USER_AGENT']))
            curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);

        $info = $this->getSysInfo();
        $params['server'] = base64_encode(serialize($info));
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($params, '', '&'));

        return $curl;
    }

    protected function confirmRequirements()
    {
        $requirement = $this->post('requirement', $this->repository->get('requirement'));
        if (!strlen($requirement) OR $requirement != 'complete')
            throw new SetupException('Please make sure your system meets all requirements');
    }

    protected function confirmInstallation()
    {
        $installation = $this->repository->get('install');

        return $installation == 'complete';
    }

    protected function cleanUpAfterInstall()
    {
        if (file_exists($this->tempDirectory)) {
            $this->deleteTempFiles($this->tempDirectory);
            @rmdir($this->tempDirectory);
        }
    }

    protected function deleteTempFiles($path, $depth = 0)
    {
        // Trim the trailing slash
        $path = rtrim($path, '/\\');

        if (!$dir = @opendir($path)) {
            return FALSE;
        }

        while (FALSE !== ($filename = @readdir($dir))) {
            if ($filename !== '.' AND $filename !== '..') {
                $filepath = $path.'/'.$filename;
                if (is_dir($filepath) AND $filename[0] !== '.' AND !is_link($filepath)) {
                    $this->deleteTempFiles($filepath, $depth + 1);
                }
                else {
                    @unlink($filepath);
                }
            }
        }

        closedir($dir);

        return (is_dir($path) AND $depth > 0) ? @rmdir($path) : TRUE;
    }

    protected function ensureTempDirExists()
    {
        if (!is_dir($this->tempDirectory))
            @mkdir($this->tempDirectory, 0777);
    }

    protected function writeExampleFiles()
    {
        if (!file_exists($exampleEnvFile = $this->baseDirectory.'/example.env'))
            $exampleEnvFile = $this->baseDirectory.'/.env';

        if (file_exists($exampleEnvFile)) {
            $contents = file_get_contents($exampleEnvFile);

            $search = $this->envReplacementPatterns();
            foreach ($search as $pattern => $replace) {
                $contents = preg_replace($pattern, $replace, $contents);
                putenv($replace);
            }

            file_put_contents($exampleEnvFile, $contents);
            rename($exampleEnvFile, $this->baseDirectory.'/.env');
        }

        if (file_exists($this->baseDirectory.'/example.htaccess')) {
            rename(
                $this->baseDirectory.'/example.htaccess',
                $this->baseDirectory.'/.htaccess'
            );
        }
    }

    protected function envReplacementPatterns()
    {
        $setting = $this->repository->get('settings');
        $db = $this->repository->get('database');

        return [
            '/^APP_NAME=TastyIgniter/m' => 'APP_NAME='.$setting['site_name'],
            '/^DB_HOST=127.0.0.1/m'     => 'DB_HOST='.$db['host'],
            '/^DB_DATABASE=database/m'  => 'DB_DATABASE='.$db['database'],
            '/^DB_USERNAME=username/m'  => 'DB_USERNAME='.$db['username'],
            '/^DB_PASSWORD=password/m'  => 'DB_PASSWORD='.$db['password'],
            '/^DB_PREFIX=ti_/m'         => 'DB_PREFIX='.$db['prefix'],
        ];
    }
}