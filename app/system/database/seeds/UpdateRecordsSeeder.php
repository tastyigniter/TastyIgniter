<?php

namespace System\Database\Seeds;

use Admin\Models\Categories_model;
use Admin\Models\Locations_model;
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
            $status = DB::table('statuses')->where('status_id', $model->status_id)->first();
            if (!$status || !isset($morphs[$status->status_for]))
                return false;

            DB::table('status_history')->where('status_history_id', $model->status_history_id)->update([
                'object_type' => $morphs[$status->status_for],
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

    protected function fillColumnsOnMailTemplatesData()
    {
        DB::table('mail_templates')->update(['is_custom' => 1]);
    }
}
