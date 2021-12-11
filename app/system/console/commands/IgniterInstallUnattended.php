<?php

namespace System\Console\Commands;

use Admin\Facades\AdminAuth;
use Admin\Models\Customer_groups_model;
use Admin\Models\Locations_model;
use Admin\Models\Staff_groups_model;
use Admin\Models\Staff_roles_model;
use Admin\Models\Staffs_model;
use Admin\Models\Users_model;
use Igniter\Flame\Support\ConfigRewrite;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Input\InputOption;
use System\Classes\UpdateManager;
use System\Database\Seeds\DatabaseSeeder;
use System\Models\Languages_model;

/**
 * Console command to install TastyIgniter in an unattended fashion.
 * This sets up TastyIgniter for the first time. It will run through setup using the provided values and then
 * perform a database migration.
 */
class IgniterInstallUnattended extends Command
{
    /**
     * The console command name.
     */
    protected $name = 'igniter:install-unattended';

    /**
     * The console command description.
     */
    protected $description = 'Set up TastyIgniter for the first time unattended.';

    /**
     * Interface for updating local app config entries.
     */
    protected ConfigRewrite $configRewrite;

    /**
     * Temp store for DB config defined during setup.
     */
    protected array $dbConfig = [];

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();

        $this->configRewrite = new ConfigRewrite();
    }

    /**
     * Get the console command options. This would normally be in the command signature directly, but due to the config
     * load requirement, that cannot be done within the constant delcaration of the command signature itself in the
     * new preferred syntax.
     */
    protected function getOptions()
    {
        $dbName = Config::get('database.default');

        return [
            // Force override flag
            [
                'force', null, InputOption::VALUE_NONE,
                'Force install over an existing TastyIgniter database',
            ],

            // Install demo data flag
            [
                'with-demo-data', null, InputOption::VALUE_NONE,
                'Install TastyIgniter with demo data',
            ],

            // Site Configuration options
            [
                'site-name', null, InputOption::VALUE_REQUIRED,
                'Site Name', DatabaseSeeder::$siteName,
            ],
            [
                'site-url', null, InputOption::VALUE_REQUIRED,
                'Site URL', Config::get('app.url'),
            ],

            // Admin User Configuration options
            [
                'admin-email', null, InputOption::VALUE_REQUIRED,
                'Admin Email', DatabaseSeeder::$siteEmail,
            ],
            [
                'admin-name', null, InputOption::VALUE_REQUIRED,
                'Admin Name', DatabaseSeeder::$staffName,
            ],
            [
                'admin-username', null, InputOption::VALUE_REQUIRED,
                'Admin Username', DatabaseSeeder::$staffUsername,
            ],
            [
                'admin-password', null, InputOption::VALUE_REQUIRED,
                'Admin Password', DatabaseSeeder::$staffPassword,
            ],

            // MySQL Configuration options
            [
                'mysql-host', null, InputOption::VALUE_REQUIRED,
                'MySQL hostname for the primary DB', Config::get("database.connections.${dbName}.host"),
            ],
            [
                'mysql-port', null, InputOption::VALUE_REQUIRED,
                'MySQL port for the primary DB', (Config::get("database.connections.${dbName}.port") ?: false),
            ],
            [
                'mysql-database', null, InputOption::VALUE_REQUIRED,
                'MySQL database name for the primary DB', Config::get("database.connections.${dbName}.database"),
            ],
            [
                'mysql-username', null, InputOption::VALUE_REQUIRED,
                'MySQL username for the primary DB', Config::get("database.connections.${dbName}.username"),
            ],
            [
                'mysql-password', null, InputOption::VALUE_REQUIRED,
                'MySQL password for the primary DB', (Config::get("database.connections.${dbName}.password") ?: false),
            ],
            [
                'mysql-table-prefix', null, InputOption::VALUE_REQUIRED,
                'MySQL password for the primary DB', (Config::get("database.connections.${dbName}.prefix") ?: false),
            ],
        ];
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->alert('INSTALLATION');

        if (App::hasDatabase() && !$this->option('force')) {
            $this->error('Application appears to be installed already. Please use -f|--force to override this.');

            return;
        }

        $this->line('Enter a new value, or press ENTER for the default');

        $this->setSeederProperties();

        $this->rewriteEnvFile();

        $this->migrateDatabase();

        $this->createSuperUser();

        $this->addSystemValues();

        $this->moveExampleFile('htaccess', null, 'backup');
        $this->moveExampleFile('htaccess', 'example', null);

        $this->alert('INSTALLATION COMPLETE');
    }

    protected function rewriteEnvFile()
    {
        if (file_exists(base_path().'/.env') && !$this->confirm('Rewrite environment file?', false)) {
            return;
        }

        $this->moveExampleFile('env', null, 'backup');
        $this->copyExampleFile('env', 'example', null);

        $this->replaceInEnv('APP_KEY=', 'APP_KEY='.$this->generateEncryptionKey());

        $this->replaceInEnv('APP_NAME=', 'APP_NAME="'.DatabaseSeeder::$siteName.'"');
        $this->replaceInEnv('APP_URL=', 'APP_URL='.DatabaseSeeder::$siteUrl);

        $name = Config::get('database.default');

        foreach ($this->dbConfig as $key => $value) {
            Config::set("database.connections.$name.".strtolower($key), $value);

            if ($key === 'password') {
                $value = '"'.$value.'"';
            }

            $this->replaceInEnv('DB_'.strtoupper($key).'=', 'DB_'.strtoupper($key).'='.$value);
        }
    }

    protected function migrateDatabase()
    {
        $this->line('Migrating application and extensions...');

        DB::purge();

        $manager = UpdateManager::instance()->setLogsOutput($this->output);

        $manager->update();

        $this->line('Done. Migrating application and extensions...');
    }

    protected function setSeederProperties()
    {
        $this->dbConfig['host']     = $this->option('mysql-host');
        $this->dbConfig['port']     = $this->option('mysql-port');
        $this->dbConfig['database'] = $this->option('mysql-database');
        $this->dbConfig['username'] = $this->option('mysql-username');
        $this->dbConfig['password'] = $this->option('mysql-password');
        $this->dbConfig['prefix']   = $this->option('mysql-table-prefix');

        DatabaseSeeder::$siteName = $this->option('site-name');
        DatabaseSeeder::$siteUrl  = $this->option('site-url');

        DatabaseSeeder::$siteEmail     = $this->option('admin-email');
        DatabaseSeeder::$staffName     = $this->option('admin-name');
        DatabaseSeeder::$staffUsername = $this->option('admin-username');
        DatabaseSeeder::$staffPassword = $this->option('admin-password');

        DatabaseSeeder::$seedDemo = $this->option('with-demo-data');
    }

    protected function createSuperUser()
    {
        if (Staffs_model::whereStaffEmail(DatabaseSeeder::$siteEmail)->first()) {
            throw new \RuntimeException('An administrator with that email already exists, please choose a different email.');
        }

        if (Users_model::whereUsername(DatabaseSeeder::$staffUsername)->first()) {
            throw new \RuntimeException('An administrator with that username already exists, please choose a different username.');
        }

        if (!is_string(DatabaseSeeder::$staffPassword) || strlen(DatabaseSeeder::$staffPassword) < 6) {
            throw new \RuntimeException('Please specify the administrator password, at least 6 characters');
        }

        $user = AdminAuth::register([
            'staff_email'   => DatabaseSeeder::$siteEmail,
            'staff_name'    => DatabaseSeeder::$staffName,
            'language_id'   => Languages_model::first()->language_id,
            'staff_role_id' => Staff_roles_model::first()->staff_role_id,
            'staff_status'  => true,
            'username'      => DatabaseSeeder::$staffUsername,
            'password'      => DatabaseSeeder::$staffPassword,
            'super_user'    => true,
            'groups'        => [Staff_groups_model::first()->staff_group_id],
            'locations'     => [Locations_model::first()->location_id],
        ]);

        $this->line('Admin user '.$user->username.' created!');
    }

    protected function addSystemValues()
    {
        params()->flushCache();

        params()->set([
            'ti_setup'            => 'installed',
            'default_location_id' => Locations_model::first()->location_id,
        ]);

        params()->save();

        setting()->flushCache();
        setting()->set('site_name', DatabaseSeeder::$siteName);
        setting()->set('site_email', DatabaseSeeder::$siteEmail);
        setting()->set('sender_name', DatabaseSeeder::$siteName);
        setting()->set('sender_email', DatabaseSeeder::$siteEmail);
        setting()->set('customer_group_id', Customer_groups_model::first()->customer_group_id);
        setting()->save();

        // These parameters are no longer in use
        params()->forget('main_address');

        UpdateManager::instance()->setCoreVersion();
    }

    protected function writeToConfig($file, $values)
    {
        $configFile = $this->getConfigFile($file);

        foreach ($values as $key => $value) {
            Config::set($file.'.'.$key, $value);
        }

        $this->configRewrite->toFile($configFile, $values);
    }

    protected function getConfigFile($name = 'app')
    {
        $env  = $this->option('env') ? $this->option('env').'/' : '';
        $path = $this->laravel['path.config']."/{$env}{$name}.php";

        return $path;
    }

    protected function generateEncryptionKey()
    {
        return 'base64:'.base64_encode(random_bytes(32));
    }

    protected function moveExampleFile($name, $old, $new)
    {
        // /$old.$name => /$new.$name
        if (file_exists(base_path().'/'.$old.'.'.$name)) {
            rename(base_path().'/'.$old.'.'.$name, base_path().'/'.$new.'.'.$name);
        }
    }

    protected function copyExampleFile($name, $old, $new)
    {
        // /$old.$name => /$new.$name
        if (file_exists(base_path().'/'.$old.'.'.$name)) {
            if (file_exists(base_path().'/'.$new.'.'.$name)) {
                unlink(base_path().'/'.$new.'.'.$name);
            }

            copy(base_path().'/'.$old.'.'.$name, base_path().'/'.$new.'.'.$name);
        }
    }

    protected function replaceInEnv(string $search, string $replace)
    {
        $file = base_path().'/.env';

        file_put_contents(
            $file,
            preg_replace('/^'.$search.'(.*)$/m', $replace, file_get_contents($file))
        );

        putenv($replace);
    }
}
