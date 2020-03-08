<?php

namespace System\Console\Commands;

use App;
use Config;
use DB;
use Igniter\Flame\Support\ConfigRewrite;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use System\Classes\UpdateManager;
use System\Database\Seeds\DatabaseSeeder;

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
    protected $configWriter;

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

        $this->rewriteConfigFiles();

        $this->setSeederProperties();

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

    protected function rewriteConfigFiles()
    {
        $this->writeDatabaseConfig();
        $this->writeToConfig('app', ['key' => $this->generateEncryptionKey()]);
    }

    protected function writeDatabaseConfig()
    {
        $config = [];
        $name = Config::get('database.default');
        $config['host'] = $this->ask('MySQL Host', Config::get("database.connections.{$name}.host"));
        $config['port'] = $this->ask('MySQL Port', Config::get("database.connections.{$name}.port") ?: FALSE) ?: '';
        $config['database'] = $this->ask('Database Name', Config::get("database.connections.{$name}.database"));
        $config['username'] = $this->ask('MySQL Login', Config::get("database.connections.{$name}.username"));
        $config['password'] = $this->ask('MySQL Password', Config::get("database.connections.{$name}.password") ?: FALSE) ?: '';
        $config['prefix'] = $this->ask('MySQL Table Prefix', Config::get("database.connections.{$name}.prefix") ?: FALSE) ?: '';

        $this->writeToConfig('database', ['default' => $name]);

        foreach ($config as $config => $value) {
            $this->writeToConfig('database', ['connections.'.$name.'.'.$config => $value]);
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
        $siteName = $this->ask('Site Name', DatabaseSeeder::$siteName);
        $this->writeToConfig('app', ['name' => $siteName]);

        $siteUrl = $this->ask('Site URL', Config::get('app.url'));
        $this->writeToConfig('app', ['url' => $siteUrl]);

        DatabaseSeeder::$siteName = $siteName;
        DatabaseSeeder::$siteUrl = $siteUrl;
        DatabaseSeeder::$siteEmail = $this->ask('Admin Email', DatabaseSeeder::$siteEmail);
        DatabaseSeeder::$staffName = $this->ask('Admin Name', DatabaseSeeder::$staffName);
    }

    protected function createSuperUser()
    {
        $username = $this->ask('Admin Username', 'admin');
        $password = $this->ask('Admin Password', '123456');

        $staff = \Admin\Models\Staffs_model::firstOrNew(['staff_email' => DatabaseSeeder::$siteEmail]);
        $staff->staff_name = DatabaseSeeder::$staffName;
        $staff->staff_role_id = \Admin\Models\Staff_roles_model::first()->staff_role_id;
        $staff->language_id = \System\Models\Languages_model::first()->language_id;
        $staff->timezone = FALSE;
        $staff->staff_status = TRUE;
        $staff->save();

        $user = \Admin\Models\Users_model::firstOrNew(['username' => $username]);
        $user->staff_id = $staff->staff_id;
        $user->password = $password;
        $user->super_user = TRUE;
        $user->is_activated = TRUE;
        $user->date_activated = \Carbon\Carbon::now();
        $user->save();

        $this->line('Admin user '.$username.' created!');
    }

    protected function addSystemValues()
    {
        params()->flushCache();

        params()->set([
            'ti_setup' => 'installed',
            'default_location_id' => \Admin\Models\Locations_model::first()->location_id,
        ]);

        params()->save();

        setting()->flushCache();
        setting()->set('site_name', DatabaseSeeder::$siteName);
        setting()->set('site_email', DatabaseSeeder::$siteEmail);
        setting()->set('sender_name', DatabaseSeeder::$siteName);
        setting()->set('sender_email', DatabaseSeeder::$siteEmail);
        setting()->set('customer_group_id', \Admin\Models\Customer_groups_model::first()->customer_group_id);
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
}