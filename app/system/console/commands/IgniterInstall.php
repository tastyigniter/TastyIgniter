<?php

namespace System\Console\Commands;

use Admin\Models\Customer_groups_model;
use Admin\Models\Locations_model;
use Admin\Models\Staff_groups_model;
use Admin\Models\Staff_roles_model;
use Admin\Models\Staffs_model;
use Admin\Models\Users_model;
use App;
use Carbon\Carbon;
use Config;
use DB;
use Igniter\Flame\Foundation\Http\Kernel;
use Igniter\Flame\Support\ConfigRewrite;
use Illuminate\Console\Command;
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

        $this->moveExampleFile('env', null, 'backup');
        $this->copyExampleFile('env', 'example', null);

        $this->rewriteEnvFile();

        $this->setSeederProperties();

        $this->migrateDatabase();

        $this->createSuperUser();

        $this->addSystemValues();

        $this->moveExampleFile('htaccess', null, 'backup');
        $this->moveExampleFile('htaccess', 'example', null);

        $this->deleteExampleFile('env');

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
        $this->replaceInEnv('APP_KEY=', 'APP_KEY='.$this->generateEncryptionKey());

        $config = [];
        $name = Config::get('database.default');
        $config['host'] = $this->ask('MySQL Host', Config::get("database.connections.{$name}.host"));
        $config['port'] = $this->ask('MySQL Port', Config::get("database.connections.{$name}.port") ?: FALSE) ?: '';
        $config['database'] = $this->ask('Database Name', Config::get("database.connections.{$name}.database"));
        $config['username'] = $this->ask('MySQL Login', Config::get("database.connections.{$name}.username"));
        $config['password'] = $this->ask('MySQL Password', Config::get("database.connections.{$name}.password") ?: FALSE) ?: '';
        $config['prefix'] = $this->ask('MySQL Table Prefix', Config::get("database.connections.{$name}.prefix") ?: FALSE) ?: '';

        $this->replaceInEnv('DB_CONNECTION=mysql', 'DB_CONNECTION='.$name);

        foreach ($config as $key => $value) {
            $this->replaceInEnv('DB_'.strtoupper($key).'=', 'DB_'.strtoupper($key).'='.$value);
        }
    }

    protected function migrateDatabase()
    {
        $this->line('Migrating application and extensions...');

        resolve(Kernel::class)->bootstrap();

        DB::purge();

        $manager = UpdateManager::instance()->setLogsOutput($this->output);

        $manager->update();

        $this->line('Done. Migrating application and extensions...');
    }

    protected function setSeederProperties()
    {
        $siteName = $this->ask('Site Name', DatabaseSeeder::$siteName);
        $this->replaceInEnv('APP_NAME=', 'APP_NAME='.$siteName);

        $siteUrl = $this->ask('Site URL', Config::get('app.url'));
        $this->replaceInEnv('APP_URL=', 'APP_URL='.$siteUrl);

        DatabaseSeeder::$seedDemo = $this->confirm('Install demo data?', DatabaseSeeder::$seedDemo);

        DatabaseSeeder::$siteName = $siteName;
        DatabaseSeeder::$siteUrl = $siteUrl;
        DatabaseSeeder::$siteEmail = $this->ask('Admin Email', DatabaseSeeder::$siteEmail);
        DatabaseSeeder::$staffName = $this->ask('Admin Name', DatabaseSeeder::$staffName);
    }

    protected function createSuperUser()
    {
        $username = $this->ask('Admin Username', 'admin');
        $password = $this->ask('Admin Password', '123456');

        $staff = Staffs_model::firstOrNew(['staff_email' => DatabaseSeeder::$siteEmail]);
        $staff->staff_name = DatabaseSeeder::$staffName;
        $staff->staff_role_id = Staff_roles_model::first()->staff_role_id;
        $staff->language_id = Languages_model::first()->language_id;
        $staff->staff_status = TRUE;
        $staff->save();

        $staff->groups()->attach(Staff_groups_model::first()->staff_group_id);
        $staff->locations()->attach(Locations_model::first()->location_id);

        $user = Users_model::firstOrNew(['username' => $username]);
        $user->staff_id = $staff->staff_id;
        $user->password = $password;
        $user->super_user = TRUE;
        $user->is_activated = TRUE;
        $user->date_activated = Carbon::now();
        $user->save();

        $this->line('Admin user '.$username.' created!');
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

    protected function deleteExampleFile($name)
    {
        if (file_exists(base_path().'/example.'.$name)) {
            unlink(base_path().'/example.'.$name);
        }
    }

    protected function replaceInEnv(string $search, string $replace)
    {
        $file = base_path().'/.env';

        file_put_contents(
            $file,
            str_replace($search, $replace, file_get_contents($file))
        );
    }
}
