<?php namespace System\Database\Seeds;

use Admin\Models\Customer_groups_model;
use Admin\Models\Mealtimes_model;
use Admin\Models\Staff_groups_model;
use Admin\Models\Statuses_model;
use Illuminate\Database\Seeder;
use System\Models\Countries_model;
use System\Models\Currencies_model;
use System\Models\Languages_model;
use System\Models\Permissions_model;
use System\Models\Settings_model;

class InitialSchemaSeeder extends Seeder
{
    protected $recordsPath = __DIR__.'/../records';

    /**
     * Run the initial schema seeds.
     * @return void
     */
    public function run()
    {
        $this->seedCountries();

        $this->seedCurrencies();

        $this->seedCustomerGroups();

        $this->seedLanguages();

        $this->seedMealtimes();

        $this->seedPermissions();

        $this->seedSettings();

        $this->seedStaffGroups();

        $this->seedStatuses();
    }

    protected function seedCountries()
    {
        if (Countries_model::count())
            return;

        $countries = $this->getSeedRecords('countries');

        foreach ($countries as $country) {
            Countries_model::insert($country);
        }
    }

    protected function seedCurrencies()
    {
        if (Currencies_model::count())
            return;

        $currencies = $this->getSeedRecords('currencies');

        foreach ($currencies as $currency) {
            Currencies_model::insert($currency);
        }
    }

    protected function seedCustomerGroups()
    {
        if (Customer_groups_model::count())
            return;

        Customer_groups_model::create([
            'group_name' => 'Default group',
            'approval' => FALSE,
        ]);
    }

    protected function seedLanguages()
    {
        if (Languages_model::count())
            return;

        Languages_model::insert([
            'code' => 'en',
            'name' => 'English',
            'image' => 'flags/gb.png',
            'idiom' => 'english',
            'status' => TRUE,
            'can_delete' => FALSE,
        ]);
    }

    protected function seedMealtimes()
    {
        if (Mealtimes_model::count())
            return;

        Mealtimes_model::insert([
            [
                "mealtime_name" => "Breakfast",
                "start_time" => "07:00:00",
                "end_time" => "10:00:00",
                "mealtime_status" => TRUE,
            ],
            [
                "mealtime_name" => "Lunch",
                "start_time" => "12:00:00",
                "end_time" => "14:30:00",
                "mealtime_status" => TRUE,
            ],
            [
                "mealtime_name" => "Dinner",
                "start_time" => "18:00:00",
                "end_time" => "20:00:00",
                "mealtime_status" => TRUE,
            ],
        ]);
    }

    protected function seedPermissions()
    {
        if (Permissions_model::count())
            return;

        $permissions = $this->getSeedRecords('permissions');

        foreach ($permissions as $permission) {
            Permissions_model::insert($permission);
        }
    }

    protected function seedSettings()
    {
        if (Settings_model::count())
            return;

        $settings = $this->getSeedRecords('settings');

        foreach ($settings as $setting) {
            Settings_model::insert($setting);
        }
    }

    protected function seedStaffGroups()
    {
        if (Staff_groups_model::count())
            return;

        Staff_groups_model::insert([
            'staff_group_name' => 'Administrator',
            'customer_account_access' => TRUE,
            'location_access' => FALSE,
            'permissions' => '',
        ]);
    }

    protected function seedStatuses()
    {
        if (Statuses_model::count())
            return;

        $statuses = $this->getSeedRecords('statuses');

        foreach ($statuses as $status) {
            Statuses_model::insert($status);
        }
    }

    protected function getSeedRecords($name)
    {
        return json_decode(file_get_contents($this->recordsPath.'/'.$name.'.json'), TRUE);
    }
}