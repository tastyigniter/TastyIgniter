<?php namespace System\Database\Seeds;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DemoSchemaSeeder extends Seeder
{
    protected $recordsPath = __DIR__.'/../records';

    /**
     * Run the demo schema seeds.
     * @return void
     */
    public function run()
    {
        $this->seedDefaultLocation();

        $this->seedCategories();

        $this->seedMenuOptions();

        $this->seedMenuItems();

        $this->seedCoupons();
    }

    protected function seedDefaultLocation()
    {
        // Abort: a location already exists
        if (DB::table('locations')->count())
            return TRUE;

        $location = $this->getSeedRecords('location');
        $location['location_email'] = DatabaseSeeder::$siteEmail;
        $location['options'] = serialize($location['options']);
        $location['delivery_areas'][0]['boundaries']['circle'] = json_encode(
            $location['delivery_areas'][0]['boundaries']['circle']
        );

        $locationId = DB::table('locations')->insertGetId(array_except($location, ['delivery_areas']));

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

            DB::table('location_tables')->insert([
                'location_id' => $locationId,
                'table_id' => $tableId,
            ]);
        }
    }

    protected function seedWorkingHours($locationId)
    {
        foreach (['opening', 'delivery', 'collection'] as $type) {
            foreach (['0', '1', '2', '3', '4', '5', '6'] as $day) {
                DB::table('working_hours')->insert([
                    'location_id' => $locationId,
                    'weekday' => $day,
                    'type' => $type,
                    'opening_time' => '00:00',
                    'closing_time' => '23:59',
                    'status' => 1,
                ]);
            }
        }
    }

    protected function seedCategories()
    {
        if (DB::table('categories')->count())
            return;

        DB::table('categories')->insert($this->getSeedRecords('categories'));
    }

    protected function seedMenuOptions()
    {
        if (DB::table('options')->count())
            return;

        foreach ($this->getSeedRecords('menu_options') as $menuOption) {
            $optionId = DB::table('options')->insertGetId(array_except($menuOption, 'option_values'));

            foreach (array_get($menuOption, 'option_values') as $optionValue) {
                DB::table('option_values')->insert(array_merge($optionValue, [
                    'option_id' => $optionId,
                ]));
            }
        }
    }

    protected function seedMenuItems()
    {
        if (DB::table('menus')->count())
            return;

        foreach ($this->getSeedRecords('menus') as $menu) {
            $menuId = DB::table('menus')->insertGetId(array_except($menu, 'menu_options'));

            foreach (array_get($menu, 'menu_options', []) as $name) {
                $option = DB::table('options')->where('option_name', $name)->first();

                $menuOptionId = DB::table('menu_options')->insertGetId([
                    'option_id' => $option->option_id,
                    'menu_id' => $menuId,
                ]);

                $optionValues = DB::table('option_values')->where('option_id', $option->option_id)->get();

                foreach ($optionValues as $optionValue) {
                    DB::table('menu_option_values')->insertGetId([
                        'menu_option_id' => $menuOptionId,
                        'option_value_id' => $optionValue->option_value_id,
                        'new_price' => $optionValue->price,
                        'quantity' => 0,
                        'subtract_stock' => 0,
                        'priority' => $optionValue->priority,
                    ]);
                }
            }
        }
    }

    protected function seedCoupons()
    {
        if (DB::table('coupons')->count())
            return;

        DB::table('coupons')->insert($this->getSeedRecords('coupons'));
    }

    protected function getSeedRecords($name)
    {
        return json_decode(file_get_contents($this->recordsPath.'/'.$name.'.json'), TRUE);
    }
}