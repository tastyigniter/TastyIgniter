<?php namespace System\Database\Seeds;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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

        $this->seedSettings();

        $this->seedStaffGroups();

        $this->seedStaffRoles();

        $this->seedStatuses();
    }

    protected function seedCountries()
    {
        if (DB::table('countries')->count())
            return;

        DB::table('countries')->insert($this->getSeedRecords('countries'));

        DB::table('countries')->update([
            'format' => '{address_1}\n{address_2}\n{city} {postcode} {state}\n{country}',
            'status' => 1,
        ]);
    }

    protected function seedCurrencies()
    {
        if (DB::table('currencies')->count())
            return;

        $currencies = $this->getSeedRecords('currencies');

        foreach ($currencies as $currency) {
            $query = DB::table('countries')->where('iso_code_3', $currency['iso_alpha3']);
            if ($country = $query->first()) {
                $currency['country_id'] = $country->country_id;
                DB::table('currencies')->insert($currency);
            }
        }
    }

    protected function seedCustomerGroups()
    {
        if (DB::table('customer_groups')->count())
            return;

        DB::table('customer_groups')->insert([
            'group_name' => 'Default group',
            'approval' => FALSE,
        ]);
    }

    protected function seedLanguages()
    {
        if (DB::table('languages')->count())
            return;

        DB::table('languages')->insert([
            'code' => 'en',
            'name' => 'English',
            'idiom' => 'english',
            'status' => TRUE,
            'can_delete' => FALSE,
        ]);
    }

    protected function seedMealtimes()
    {
        if (DB::table('mealtimes')->count())
            return;

        DB::table('mealtimes')->insert([
            [
                'mealtime_name' => 'Breakfast',
                'start_time' => '07:00:00',
                'end_time' => '10:00:00',
                'mealtime_status' => TRUE,
            ],
            [
                'mealtime_name' => 'Lunch',
                'start_time' => '12:00:00',
                'end_time' => '14:30:00',
                'mealtime_status' => TRUE,
            ],
            [
                'mealtime_name' => 'Dinner',
                'start_time' => '18:00:00',
                'end_time' => '20:00:00',
                'mealtime_status' => TRUE,
            ],
        ]);
    }

    protected function seedSettings()
    {
        if (DB::table('settings')->count())
            return;

        DB::table('settings')->insert($this->getSeedRecords('settings'));
    }

    protected function seedStaffGroups()
    {
        if (DB::table('staff_groups')->count())
            return;

        DB::table('staff_groups')->insert([
            'staff_group_name' => 'Owners',
            'description' => 'Default group for owners',
        ]);

        DB::table('staff_groups')->insert([
            'staff_group_name' => 'Managers',
            'description' => 'Default group for managers',
        ]);

        DB::table('staff_groups')->insert([
            'staff_group_name' => 'Waiters',
            'description' => 'Default group for waiters.',
        ]);

        DB::table('staff_groups')->insert([
            'staff_group_name' => 'Delivery',
            'description' => 'Default group for delivery drivers.',
        ]);
    }

    protected function seedStaffRoles()
    {
        if (DB::table('staff_roles')->count())
            return;

        DB::table('staff_roles')->insert([
            'name' => 'Owner',
            'code' => 'owner',
            'description' => 'Default role for restaurant owners',
        ]);

        DB::table('staff_roles')->insert([
            'name' => 'Manager',
            'code' => 'manager',
            'description' => 'Default role for restaurant managers.',
            'permissions' => 'a:18:{s:15:"Admin.Dashboard";s:1:"1";s:16:"Admin.Categories";s:1:"1";s:14:"Admin.Statuses";s:1:"1";s:12:"Admin.Staffs";s:1:"1";s:17:"Admin.StaffGroups";s:1:"1";s:15:"Admin.Customers";s:1:"1";s:20:"Admin.CustomerGroups";s:1:"1";s:13:"Admin.Reviews";s:1:"1";s:14:"Admin.Payments";s:1:"1";s:18:"Admin.Reservations";s:1:"1";s:12:"Admin.Orders";s:1:"1";s:12:"Admin.Tables";s:1:"1";s:15:"Admin.Locations";s:1:"1";s:13:"Admin.Coupons";s:1:"1";s:15:"Admin.Mealtimes";s:1:"1";s:11:"Admin.Menus";s:1:"1";s:11:"Site.Themes";s:1:"1";s:18:"Admin.MediaManager";s:1:"1";}',
        ]);

        DB::table('staff_roles')->insert([
            'name' => 'Waiter',
            'code' => 'waiter',
            'description' => 'Default role for restaurant waiters.',
            'permissions' => 'a:4:{s:16:"Admin.Categories";s:1:"1";s:18:"Admin.Reservations";s:1:"1";s:12:"Admin.Orders";s:1:"1";s:11:"Admin.Menus";s:1:"1";}',
        ]);

        DB::table('staff_roles')->insert([
            'name' => 'Delivery',
            'code' => 'delivery',
            'description' => 'Default role for restaurant delivery.',
            'permissions' => 'a:3:{s:14:"Admin.Statuses";s:1:"1";s:18:"Admin.Reservations";s:1:"1";s:12:"Admin.Orders";s:1:"1";}',
        ]);
    }

    protected function seedStatuses()
    {
        if (DB::table('statuses')->count())
            return;

        DB::table('statuses')->insert($this->getSeedRecords('statuses'));
    }

    protected function getSeedRecords($name)
    {
        return json_decode(file_get_contents($this->recordsPath.'/'.$name.'.json'), TRUE);
    }
}
