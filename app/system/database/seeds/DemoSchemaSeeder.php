<?php namespace System\Database\Seeds;

use Admin\Models\Categories_model;
use Admin\Models\Coupons_model;
use Admin\Models\Locations_model;
use Admin\Models\Menu_options_model;
use Admin\Models\Menus_model;
use Admin\Models\Tables_model;
use Admin\Models\Working_hours_model;
use Eloquent;
use Illuminate\Database\Seeder;

class DemoSchemaSeeder extends Seeder
{
    protected $recordsPath = __DIR__.'/../records';

    /**
     * Run the demo schema seeds.
     * @return void
     */
    public function run()
    {
        Eloquent::unguard();

        $this->seedDefaultLocation();

        $this->seedCategories();

        $this->seedMenuOptions();

        $this->seedMenuItems();

        $this->seedCoupons();
    }

    protected function seedDefaultLocation()
    {
        // Abort: a location already exists
        if (Locations_model::count())
            return TRUE;

        $location = $this->getSeedRecords('location');
        $location['location_email'] = DatabaseSeeder::$siteEmail;
        $location['delivery_areas'][0]['boundaries']['circle'] = json_encode(
            $location['delivery_areas'][0]['boundaries']['circle']
        );

        $location = Locations_model::create($location);
        
        $this->seedLocationTables($location);
    }

    protected function seedLocationTables($location)
    {
        if (Tables_model::count())
            return;

        for ($i = 1; $i < 15; $i++) {
            $table = Tables_model::create([
                'table_name' => 'Table '.$i,
                'min_capacity' => random_int(2, 5),
                'max_capacity' => random_int(6, 12),
                'table_status' => 1,
            ]);

            $location->tables()->attach($table);
        }
    }

    protected function seedWorkingHours($location)
    {
        foreach (['opening', 'delivery', 'collection'] as $type) {
            foreach (['0', '1', '2', '3', '4', '5', '6'] as $day) {
                Working_hours_model::insert([
                    'location_id' => $location->getKey(),
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
        if (Categories_model::count())
            return;

        foreach ($this->getSeedRecords('categories') as $category) {
            Categories_model::create($category);
        }
    }

    protected function seedMenuOptions()
    {
        if (Menu_options_model::count())
            return;

        foreach ($this->getSeedRecords('menu_options') as $menuOption) {
            Menu_options_model::create($menuOption);
        }
    }

    protected function seedMenuItems()
    {
        if (Menus_model::count())
            return;

        foreach ($this->getSeedRecords('menus') as $menu) {
            $model = Menus_model::create(array_except($menu, 'menu_options'));

            foreach (array_get($menu, 'menu_options', []) as $name) {
                $option = Menu_options_model::where('option_name', $name)->first();

                $values = [];
                foreach ($option->option_values as $optionValue) {
                    $values[] = [
                        'option_value_id' => $optionValue->option_value_id,
                        'new_price' => $optionValue->price,
                        'quantity' => 0,
                        'subtract_stock' => 0,
                        'priority' => $optionValue->priority,
                    ];
                }

                $model->menu_options()->create([
                    'option_id' => $option->option_id,
                    'menu_option_values' => $values,
                ]);
            }
        }
    }

    protected function seedCoupons()
    {
        if (Coupons_model::count())
            return;

        foreach ($this->getSeedRecords('coupons') as $coupon) {
            Coupons_model::create($coupon);
        }
    }

    protected function getSeedRecords($name)
    {
        return json_decode(file_get_contents($this->recordsPath.'/'.$name.'.json'), TRUE);
    }
}