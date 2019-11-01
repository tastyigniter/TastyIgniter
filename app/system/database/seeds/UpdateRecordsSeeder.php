<?php namespace System\Database\Seeds;

use Admin\Models\Categories_model;
use Admin\Models\Locations_model;
use Carbon\Carbon;
use DB;
use Illuminate\Database\Seeder;

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

        $this->updateMorphsOnReviews();

        $this->fixPermalinkSlugColumns();

        $this->copyRecordsFromExtensionsToThemes();

        $this->copyRecordsFromExtensionsToPayments();

        $this->copyRecordsFromLocationsToLocationAreas();

        $this->fillColumnsOnMailTemplatesData();
    }

    protected function updateMorphsOnStatusHistory()
    {
        if (DB::table('status_history')->where('object_type', 'Admin\Models\Orders_model')->count())
            return;

        $morphs = [
            'order' => 'Admin\Models\Orders_model',
            'reserve' => 'Admin\Models\Reservations_model',
        ];

        DB::table('status_history')->get()->each(function ($model) use ($morphs) {
            if (!isset($morphs[$model->status_for]))
                return FALSE;

            DB::table('status_history')->where('status_history_id', $model->status_history_id)->update([
                'object_type' => $morphs[$model->status_for],
            ]);
        });
    }

    protected function updateMorphsOnReviews()
    {
        if (DB::table('reviews')
              ->where('sale_type', 'Admin\Models\Orders_model')
              ->orWhere('sale_type', 'Admin\Models\Reservations_model')
              ->count()
        ) return;

        $morphs = [
            'order' => 'Admin\Models\Orders_model',
            'reservation' => 'Admin\Models\Reservations_model',
        ];

        DB::table('reviews')->get()->each(function ($model) use ($morphs) {
            if (!isset($morphs[$model->sale_type]))
                return FALSE;

            DB::table('reviews')->where('review_id', $model->review_id)->update([
                'sale_type' => $morphs[$model->sale_type],
            ]);
        });
    }

    protected function fixPermalinkSlugColumns()
    {
        Categories_model::all()->each(function (Categories_model $model) {
            $model->save();
        });

        Locations_model::all()->each(function (Locations_model $model) {
            $model->save();
        });
    }

    protected function copyRecordsFromExtensionsToThemes()
    {
        if (DB::table('themes')->count())
            return;

        DB::table('extensions')->where('type', 'theme')->get()->each(function ($model) {
            DB::table('themes')->insert([
                'name' => $model->title,
                'code' => $model->name,
                'version' => $model->version,
                'data' => $model->data,
                'status' => $model->status,
                'is_default' => FALSE,
            ]);
        });
    }

    protected function copyRecordsFromExtensionsToPayments()
    {
        if (DB::table('payments')->count())
            return;

        DB::table('extensions')->where('type', 'payment')->get()->each(function ($model) {

            $code = str_replace(['-', '_'], '', $model->name);
            DB::table('payments')->insert([
                'name' => $model->title,
                'code' => $code,
                'class_name' => 'SamPoyigi\\PayRegister\\Payments\\'.studly_case($model->name),
                'data' => $model->data,
                'status' => $model->status,
                'is_default' => FALSE,
                'date_added' => Carbon::now(),
                'date_updated' => Carbon::now(),
            ]);
        });
    }

    protected function copyRecordsFromLocationsToLocationAreas()
    {
        if (DB::table('location_areas')->count())
            return;

        collect(DB::table('locations')->pluck('options', 'location_id'))->each(function ($options, $id) {
            $options = is_string($options) ? unserialize($options) : [];
            
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
                    'boundaries' => serialize($boundaries),
                    'conditions' => serialize($option['conditions'] ?? $option['charge']),
                ]);
            }
        });
    }

    protected function fillColumnsOnMailTemplatesData()
    {
        DB::table('mail_templates_data')->update(['is_custom' => 1]);
    }

    protected function fillIsCustomOnPermissions()
    {
        if (DB::table('permissions')->where('is_custom', 1)->count())
            return;

        DB::table('permissions')->update(['is_custom' => 1]);
    }
}