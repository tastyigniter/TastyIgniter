<?php namespace System\Database\Seeds;

use Admin\Models\Customer_groups_model;
use Admin\Models\Mealtimes_model;
use Admin\Models\Staff_groups_model;
use Admin\Models\Statuses_model;
use Illuminate\Database\Seeder;
use System\Models\Countries_model;
use System\Models\Currencies_model;
use System\Models\Languages_model;
use System\Models\Pages_model;
use System\Models\Permissions_model;
use System\Models\Settings_model;

class InitialSchemaSeeder extends Seeder
{
    protected $recordsPath;

    /**
     * Run the initial schema seeds.
     * @return void
     */
    public function run()
    {
        $this->recordsPath = __DIR__.'/../records';

        $this->seedCountries();

        $this->seedCurrencies();

        $this->seedCustomerGroups();

        $this->seedLanguages();

        $this->seedMealtimes();

        $this->seedPages();

        $this->seedPermissions();

        $this->seedSettings();

        $this->seedStaffGroups();
    }

    protected function seedCountries()
    {
        if (Countries_model::count())
            return;

        $countries = json_decode(file_get_contents($this->recordsPath.'/countries.json'), TRUE);

        foreach ($countries as $country) {
            Countries_model::insert($country);
        }
    }

    protected function seedCurrencies()
    {
        if (Currencies_model::count())
            return;

        $currencies = json_decode(file_get_contents($this->recordsPath.'/currencies.json'), TRUE);

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
            'approval'   => FALSE,
        ]);
    }

    protected function seedLanguages()
    {
        if (Languages_model::count())
            return;

        Languages_model::insert([
            'code'       => 'en',
            'name'       => 'English',
            'image'      => 'data/flags/gb.png',
            'idiom'      => 'english',
            'status'     => TRUE,
            'can_delete' => FALSE,
        ]);
    }

    protected function seedMealtimes()
    {
        if (Mealtimes_model::count())
            return;

        Mealtimes_model::insert([
            [
                "mealtime_name"   => "Breakfast",
                "start_time"      => "07:00:00",
                "end_time"        => "10:00:00",
                "mealtime_status" => TRUE,
            ],
            [
                "mealtime_name"   => "Lunch",
                "start_time"      => "12:00:00",
                "end_time"        => "14:30:00",
                "mealtime_status" => TRUE,
            ],
            [
                "mealtime_name"   => "Dinner",
                "start_time"      => "18:00:00",
                "end_time"        => "20:00:00",
                "mealtime_status" => TRUE,
            ],
        ]);
    }

    protected function seedPages()
    {
        if (Pages_model::count())
            return;

        $language = Languages_model::whereCode('en')->first();

        Pages_model::insert([
            [
                "language_id"      => $language->language_id,
                "name"             => "About Us",
                "title"            => "About Us",
                "heading"          => "About Us",
                "content"          => "Lorem ipsum dolor sit amet, consectetur adipiscing elit.",
                "meta_description" => "",
                "meta_keywords"    => "",
//                "layout_id"        => 17,
                "navigation"       => "a:2:{i:0;s:8:\"side_bar\";i:1;s:6:\"footer\";}",
                "date_added"       => "2014-04-19 16:57:21",
                "date_updated"     => "2015-05-07 12:39:52",
                "status"           => 1,
            ], [
                "language_id"      => $language->language_id,
                "name"             => "Policy",
                "title"            => "Policy",
                "heading"          => "Policy",
                "content"          => "Lorem ipsum dolor sit amet, consectetur adipiscing elit.",
                "meta_description" => "",
                "meta_keywords"    => "",
//                "layout_id"        => 17,
                "navigation"       => "a:2:{i:0;s:8:\"side_bar\";i:1;s:6:\"footer\";}",
                "date_added"       => "2014-04-19 17:21:23",
                "date_updated"     => "2015-05-16 09:18:39",
                "status"           => 1,
            ],
        ]);
    }

    protected function seedPermissions()
    {
        if (Permissions_model::count())
            return;

        $permissions = json_decode(file_get_contents($this->recordsPath.'/permissions.json'), TRUE);

        foreach ($permissions as $permission) {
            Permissions_model::insert($permission);
        }
    }

    protected function seedSettings()
    {
        if (Settings_model::count())
            return;

        $settings = json_decode(file_get_contents($this->recordsPath.'/settings.json'), TRUE);

        foreach ($settings as $setting) {
            Settings_model::insert($setting);
        }
    }

    protected function seedStaffGroups()
    {
        if (Staff_groups_model::count())
            return;

        Staff_groups_model::insert([
            'staff_group_name'        => 'Administrator',
            'customer_account_access' => TRUE,
            'location_access'         => TRUE,
            'permissions'             => '',
        ]);
    }

    protected function seedStatuses()
    {
        if (Statuses_model::count())
            return;

        $statuses = json_decode(file_get_contents($this->recordsPath.'/statuses.json'), TRUE);

        foreach ($statuses as $status) {
            Statuses_model::insert($status);
        }
    }
}