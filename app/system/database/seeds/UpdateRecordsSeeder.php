<?php

namespace System\Database\Seeds;

use Admin\Models\Category;
use Admin\Models\Location;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Fill newly created permalink_slug column with values from permalinks table
 * Truncate the permalinks table
 */
class UpdateRecordsSeeder extends Seeder
{
    /**
     * Run the demo schema seeds.
     * @return void
     */
    public function run()
    {
        $this->updateMorphsOnStatusHistory();

        $this->fixPermalinkSlugColumns();

        $this->copyRecordsFromLocationsToLocationAreas();

        $this->fillColumnsOnMailTemplatesData();
    }

    protected function updateMorphsOnStatusHistory()
    {
        if (DB::table('status_history')->where('object_type', \Admin\Models\Order::class)->count())
            return;

        $morphs = [
            'order' => \Admin\Models\Order::class,
            'reserve' => \Admin\Models\Reservation::class,
        ];

        DB::table('status_history')->get()->each(function ($model) use ($morphs) {
            $status = DB::table('statuses')->where('status_id', $model->status_id)->first();
            if (!$status || !isset($morphs[$status->status_for]))
                return FALSE;

            DB::table('status_history')->where('status_history_id', $model->status_history_id)->update([
                'object_type' => $morphs[$status->status_for],
            ]);
        });
    }

    protected function fixPermalinkSlugColumns()
    {
        Category::all()->each(function (Category $model) {
            $model->save();
        });

        Location::all()->each(function (Location $model) {
            $model->save();
        });
    }

    protected function copyRecordsFromLocationsToLocationAreas()
    {
        if (DB::table('location_areas')->count())
            return;

        collect(DB::table('locations')->pluck('options', 'location_id'))->each(function ($options, $id) {
            $options = is_string($options) ? json_decode($options, TRUE) : [];

            if (!isset($options['delivery_areas']))
                return TRUE;

            foreach ($options['delivery_areas'] as $option) {
                $boundaries = array_except($option, ['type', 'name', 'charge', 'conditions']);
                if (isset($boundaries['shape']))
                    $boundaries['polygon'] = $boundaries['shape'];

                unset($boundaries['shape']);

                DB::table('location_areas')->insert([
                    'location_id' => $id,
                    'name' => $option['name'],
                    'type' => $option['type'] == 'shape' ? 'polygon' : $option['type'],
                    'boundaries' => json_encode($boundaries),
                    'conditions' => json_encode($option['conditions'] ?? $option['charge']),
                ]);
            }
        });
    }

    protected function fillColumnsOnMailTemplatesData()
    {
        DB::table('mail_templates')->update(['is_custom' => 1]);
    }
}
