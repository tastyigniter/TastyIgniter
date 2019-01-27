<?php namespace System\Database\Seeds;

use Admin\Models\Categories_model;
use Admin\Models\Location_areas_model;
use Admin\Models\Locations_model;
use Admin\Models\Payments_model;
use Admin\Models\Reviews_model;
use Admin\Models\Status_history_model;
use Carbon\Carbon;
use DB;
use File;
use Illuminate\Database\Seeder;
use System\Models\Extensions_model;
use System\Models\Mail_layouts_model;
use System\Models\Message_meta_model;
use System\Models\Messages_model;
use System\Models\Permissions_model;
use System\Models\Themes_model;

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

        $this->updateMorphsOnMessages();

        $this->updateMorphsOnMessagesMeta();

        $this->copyRecordsFromExtensionsToThemes();

        $this->copyRecordsFromExtensionsToPayments();

        $this->copyRecordsFromLocationsToLocationAreas();

        $this->fillColumnsOnMailTemplatesData();

        $this->fillIsCustomOnPermissions();
    }

    protected function updateMorphsOnStatusHistory()
    {
        if (Status_history_model::where('object_type', 'Admin\Models\Orders_model')->count())
            return;

        $morphs = [
            'order' => 'Admin\Models\Orders_model',
            'reserve' => 'Admin\Models\Reservations_model',
        ];

        Status_history_model::all()->each(function ($model) use ($morphs) {
            if (!isset($morphs[$model->status_for]))
                return FALSE;

            $model->object_type = $morphs[$model->status_for];
            $model->save();
        });
    }

    protected function updateMorphsOnReviews()
    {
        if (Reviews_model::where('sale_type', 'Admin\Models\Orders_model')->count())
            return;

        $morphs = [
            'order' => 'Admin\Models\Orders_model',
            'reservation' => 'Admin\Models\Reservations_model',
        ];

        Reviews_model::all()->each(function ($model) use ($morphs) {
            if (!isset($morphs[$model->sale_type]))
                return FALSE;

            $model->sale_type = $morphs[$model->sale_type];
            $model->save();
        });
    }

    protected function fixPermalinkSlugColumns()
    {
        Categories_model::all()->each(function ($model) {
            $model->save();
        });

        Locations_model::all()->each(function ($model) {
            $model->save();
        });
    }

    protected function updateMorphsOnMessages()
    {
        if (Messages_model::where('sender_type', 'Admin\Models\Users_model')->count())
            return;

        Messages_model::whereNotNull('sender_id')->update([
            'sender_type' => 'Admin\Models\Users_model',
        ]);
    }

    protected function updateMorphsOnMessagesMeta()
    {
        if (Message_meta_model::where('messagable_type', 'System\Models\Customers_model')->count())
            return;

        $replace = [
            'customer_id' => 'Admin\Models\Customers_model',
            'staff_id' => 'Admin\Models\Users_model',
        ];

        Message_meta_model::all()->each(function ($model) use ($replace) {
            if (!array_key_exists($model->item, $replace))
                return FALSE;

            $model->messagable_id = $model->value;
            $model->messagable_type = $replace[$model->item];
            $model->save();
        });
    }

    protected function copyRecordsFromExtensionsToThemes()
    {
        if (Themes_model::count())
            return;

        Extensions_model::getQuery()->where('type', 'theme')->get()->each(function ($model) {

            Themes_model::insert([
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
        if (Payments_model::count())
            return;

        Extensions_model::getQuery()->where('type', 'payment')->get()->each(function ($model) {

            $code = str_replace(['-', '_'], '', $model->name);
            Payments_model::insert([
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
        if (Location_areas_model::count())
            return;

        Locations_model::pluck('options', 'location_id')->each(function ($options, $id) {
            if (!isset($options['delivery_areas']))
                return TRUE;

            foreach ($options['delivery_areas'] as $option) {

                $boundaries = array_except($option, ['type', 'name', 'charge', 'conditions']);
                if (isset($boundaries['shape']))
                    $boundaries['polygon'] = $boundaries['shape'];

                unset($boundaries['shape']);

                Location_areas_model::insert([
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

        $path = __DIR__.'/mail/';

        Mail_layouts_model::create([
            'name' => 'New Default Layout',
            'code' => 'default',
            'layout' => File::get($path.'layout.htm'),
            'plain_layout' => File::get($path.'plain_layout.txt'),
            'layout_css' => File::get($path.'style.css'),
        ]);
    }

    protected function fillIsCustomOnPermissions()
    {
        if (Permissions_model::where('is_custom', 1)->count())
            return;

        DB::table('permissions')->update(['is_custom' => 1]);
    }
}