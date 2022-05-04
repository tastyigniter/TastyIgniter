<?php

namespace System\Database\Seeds;

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

        $this->seedDefaultLocation();

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

        DB::table('countries')->insert($this->getSeedRecords('countries', true));

        DB::table('countries')->update(['updated_at' => now(), 'created_at' => now()]);

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

        DB::table('currencies')->update(['updated_at' => now(), 'created_at' => now()]);
    }

    protected function seedCustomerGroups()
    {
        if (DB::table('customer_groups')->count())
            return;

        DB::table('customer_groups')->insert([
            'group_name' => 'Default group',
            'approval' => false,
        ]);

        DB::table('customer_groups')->update(['updated_at' => now(), 'created_at' => now()]);
    }

    protected function seedLanguages()
    {
        if (DB::table('languages')->count())
            return;

        DB::table('languages')->insert([
            'code' => 'en',
            'name' => 'English',
            'idiom' => 'english',
            'status' => true,
            'can_delete' => false,
        ]);

        DB::table('languages')->update(['updated_at' => now(), 'created_at' => now()]);
    }

    protected function seedDefaultLocation()
    {
        // Abort: a location already exists
        if (DB::table('locations')->count())
            return true;

        $location = $this->getSeedRecords('location');
        $location['location_email'] = DatabaseSeeder::$siteEmail;
        $location['options'] = json_encode($location['options']);
        $location['delivery_areas'][0]['boundaries']['circle'] = json_encode(
            $location['delivery_areas'][0]['boundaries']['circle']
        );

        $locationId = DB::table('locations')->insertGetId(array_except($location, ['delivery_areas']));
        DB::table('locations')->update(['updated_at' => now(), 'created_at' => now()]);

        $this->seedLocationTables($locationId);
    }

    protected function seedLocationTables($locationId)
    {
        if (DB::table('tables')->count())
            return;

        for ($i = 1; $i < 15; $i++) {
            $tableId = DB::table('tables')->insertGetId([
                'table_name' => 'Table '.$i,
                'min_capacity' => random_int(2, 5),
                'max_capacity' => random_int(6, 12),
                'table_status' => 1,
            ]);

            DB::table('locationables')->insert([
                'location_id' => $locationId,
                'locationable_id' => $tableId,
                'locationable_type' => 'tables',
            ]);
        }

        DB::table('tables')->update(['updated_at' => now(), 'created_at' => now()]);
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
                'mealtime_status' => true,
            ],
            [
                'mealtime_name' => 'Lunch',
                'start_time' => '12:00:00',
                'end_time' => '14:30:00',
                'mealtime_status' => true,
            ],
            [
                'mealtime_name' => 'Dinner',
                'start_time' => '18:00:00',
                'end_time' => '20:00:00',
                'mealtime_status' => true,
            ],
        ]);

        DB::table('mealtimes')->update(['updated_at' => now(), 'created_at' => now()]);
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

        DB::table('staff_groups')->update(['updated_at' => now(), 'created_at' => now()]);
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
            'permissions' => 'a:16:{s:15:"Admin.Dashboard";s:1:"1";s:16:"Admin.Categories";s:1:"1";s:14:"Admin.Statuses";s:1:"1";s:12:"Admin.Staffs";s:1:"1";s:17:"Admin.StaffGroups";s:1:"1";s:15:"Admin.Customers";s:1:"1";s:20:"Admin.CustomerGroups";s:1:"1";s:14:"Admin.Payments";s:1:"1";s:18:"Admin.Reservations";s:1:"1";s:12:"Admin.Orders";s:1:"1";s:12:"Admin.Tables";s:1:"1";s:15:"Admin.Locations";s:1:"1";s:15:"Admin.Mealtimes";s:1:"1";s:11:"Admin.Menus";s:1:"1";s:11:"Site.Themes";s:1:"1";s:18:"Admin.MediaManager";s:1:"1";}',
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

        DB::table('staff_roles')->update(['updated_at' => now(), 'created_at' => now()]);
    }

    protected function seedStatuses()
    {
        if (DB::table('statuses')->count())
            return;

        DB::table('statuses')->insert($this->getSeedRecords('statuses'));

        DB::table('statuses')->update(['updated_at' => now(), 'created_at' => now()]);
    }

    protected function getSeedRecords($name)
    {
        return json_decode(file_get_contents($this->recordsPath.'/'.$name.'.json'), true);
    }
}
