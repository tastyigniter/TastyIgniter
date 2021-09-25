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
 * Console command to install TastyIgniter.
 * This sets up TastyIgniter for the first time. It will prompt the user for several
 * configuration items, including application URL and database config, and then
 * perform a database migration.
 */
class IgniterInstall extends Command
{
    /**
     * The console command name.
     */
    protected $name = 'igniter:install';

    /**
     * The console command description.
     */
    protected $description = 'Set up TastyIgniter for the first time.';

    /**
     * @var \Igniter\Flame\Support\ConfigRewrite
     */
    protected $configRewrite;

    protected $dbConfig = [];

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();

        $this->configRewrite = new ConfigRewrite;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->alert('INSTALLATION');

        if (
            App::hasDatabase() AND
            !$this->confirm('Application appears to be installed already. Continue anyway?', FALSE)
        ) {
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

    /**
     * Get the console command options.
     */
    protected function getOptions()
    {
        return [
            ['force', null, InputOption::VALUE_NONE, 'Force install.'],
        ];
    }

    protected function rewriteEnvFile()
    {
        if (file_exists(base_path().'/.env') AND !$this->confirm('Rewrite environment file?', FALSE))
            return;

        $this->moveExampleFile('env', null, 'backup');
        $this->copyExampleFile('env', 'example', null);

        $this->replaceInEnv('APP_KEY=', 'APP_KEY='.$this->generateEncryptionKey());

        $this->replaceInEnv('APP_NAME=', 'APP_NAME="'.DatabaseSeeder::$siteName.'"');
        $this->replaceInEnv('APP_URL=', 'APP_URL='.DatabaseSeeder::$siteUrl);

        $name = Config::get('database.default');
        foreach ($this->dbConfig as $key => $value) {
            Config::set("database.connections.$name.".strtolower($key), $value);

            if ($key === 'password') $value = '"'.$value.'"';
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
        $name = Config::get('database.default');
        $this->dbConfig['host'] = $this->ask('MySQL Host', Config::get("database.connections.$name.host"));
        $this->dbConfig['port'] = $this->ask('MySQL Port', Config::get("database.connections.$name.port") ?: FALSE) ?: '';
        $this->dbConfig['database'] = $this->ask('MySQL Database', Config::get("database.connections.$name.database"));
        $this->dbConfig['username'] = $this->ask('MySQL Username', Config::get("database.connections.$name.username"));
        $this->dbConfig['password'] = $this->ask('MySQL Password', Config::get("database.connections.$name.password") ?: FALSE) ?: '';
        $this->dbConfig['prefix'] = $this->ask('MySQL Table Prefix', Config::get("database.connections.$name.prefix") ?: FALSE) ?: '';

        DatabaseSeeder::$siteName = $this->ask('Site Name', DatabaseSeeder::$siteName);
        DatabaseSeeder::$siteUrl = $this->ask('Site URL', Config::get('app.url'));

        DatabaseSeeder::$seedDemo = $this->confirm('Install demo data?', DatabaseSeeder::$seedDemo);

        DatabaseSeeder::$siteEmail = $this->ask('Admin Email', DatabaseSeeder::$siteEmail);
        DatabaseSeeder::$staffName = $this->ask('Admin Name', DatabaseSeeder::$staffName);
    }

    protected function createSuperUser()
    {
        $email = $this->output->ask('Admin Email', DatabaseSeeder::$siteEmail, function ($answer) {
            if (Staffs_model::whereStaffEmail($answer)->first()) {
                throw new \RuntimeException('An administrator with that email already exists, please choose a different email.');
            }

            return $answer;
        });

        $username = $this->output->ask('Admin Username', 'admin', function ($answer) {
            if (Users_model::whereUsername($answer)->first()) {
                throw new \RuntimeException('An administrator with that username already exists, please choose a different username.');
            }

            return $answer;
        });

        $password = $this->output->ask('Admin Password', '123456', function ($answer) {
            if (!is_string($answer) OR strlen($answer) < 6) {
                throw new \RuntimeException('Please specify the administrator password, at least 6 characters');
            }

            return $answer;
        });

        $user = AdminAuth::register([
            'staff_email' => $email,
            'staff_name' => DatabaseSeeder::$staffName,
            'language_id' => Languages_model::first()->language_id,
            'staff_role_id' => Staff_roles_model::first()->staff_role_id,
            'staff_status' => TRUE,
            'username' => $username,
            'password' => $password,
            'groups' => [Staff_groups_model::first()->staff_group_id],
            'locations' => [Locations_model::first()->location_id],
        ]);

        $this->line('Admin user '.$user->username.' created!');
    }

    protected function addSystemValues()
    {
        params()->flushCache();

        params()->set([
            'ti_setup' => 'installed',
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
        $env = $this->option('env') ? $this->option('env').'/' : '';
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
            if (file_exists(base_path().'/'.$new.'.'.$name))
                unlink(base_path().'/'.$new.'.'.$name);

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
