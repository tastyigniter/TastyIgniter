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

        $this->seedPermissions();

        $this->seedSettings();

        $this->seedStaffGroups();

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

    protected function seedPages()
    {
        if (DB::table('pages')->count())
            return;

        $language = DB::table('languages')->where('code', 'en')->first();

        DB::table('pages')->insert([
            [
                'language_id' => $language->language_id,
                'name' => 'About Us',
                'title' => 'About Us',
                'heading' => 'About Us',
                'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
                'meta_description' => '',
                'meta_keywords' => '',
                'navigation' => 'a:2:{i:0;s:8:\'side_bar\';i:1;s:6:\'footer\';}',
                'date_added' => '2014-04-19 16:57:21',
                'date_updated' => '2015-05-07 12:39:52',
                'status' => 1,
            ], [
                'language_id' => $language->language_id,
                'name' => 'Policy',
                'title' => 'Policy',
                'heading' => 'Policy',
                'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
                'meta_description' => '',
                'meta_keywords' => '',
                'navigation' => 'a:2:{i:0;s:8:\'side_bar\';i:1;s:6:\'footer\';}',
                'date_added' => '2014-04-19 17:21:23',
                'date_updated' => '2015-05-16 09:18:39',
                'status' => 1,
            ],
        ]);
    }

    protected function seedPermissions()
    {
        if (DB::table('permissions')->count())
            return;

        DB::table('permissions')->insert($this->getSeedRecords('permissions'));
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
            'staff_group_name' => 'Administrator',
            'customer_account_access' => TRUE,
            'location_access' => TRUE,
            'permissions' => '',
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
