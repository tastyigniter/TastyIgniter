<?php namespace System\Database\Seeds;

use Admin\Models\Categories_model;
use Admin\Models\Layout_modules_model;
use Admin\Models\Location_areas_model;
use Admin\Models\Locations_model;
use Admin\Models\Pages_model;
use Admin\Models\Payments_model;
use Admin\Models\Reviews_model;
use Admin\Models\Status_history_model;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use System\Models\Extensions_model;
use System\Models\Mail_templates_data_model;
use System\Models\Message_meta_model;
use System\Models\Messages_model;
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

        $this->fillAliasColumnOnLayoutModules();

        $this->copyRecordsFromExtensionsToThemes();

        $this->copyRecordsFromExtensionsToPayments();

        $this->copyRecordsFromLocationsToLocationAreas();

        $this->fillLabelColumnOnMailTemplatesData();
    }

    protected function updateMorphsOnStatusHistory()
    {
        $morphs = [
            'order'   => 'Admin\Models\Orders_model',
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
        $morphs = [
            'order'       => 'Admin\Models\Orders_model',
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

        Pages_model::all()->each(function ($model) {
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
        if (Message_meta_model::where('messageable_type', 'System\Models\Customers_model')->count())
            return;

        $replace = [
            'customer_id' => 'Admin\Models\Customers_model',
            'staff_id'    => 'Admin\Models\Users_model',
        ];

        Message_meta_model::all()->each(function ($model) use ($replace) {
            if (!array_key_exists($model->item, $replace))
                return FALSE;

            $model->messageable_id = $model->value;
            $model->messageable_type = $replace[$model->item];
            $model->save();
        });
    }

    protected function fillAliasColumnOnLayoutModules()
    {
        if (!Layout_modules_model::where('module_code', 'local_module')->count())
            return;

        $replaceAlias = [
            'pages_module'       => 'pages',
            'local_module'       => 'local',
            'account_module'     => 'account',
            'categories_module'  => 'categories',
            'cart_module'        => 'cart',
            'reservation_module' => 'seatbooker',
        ];

        Layout_modules_model::all()->each(function ($model) use ($replaceAlias) {
            $model->alias = isset($replaceAlias[$model->module_code])
                ? $replaceAlias[$model->module_code]
                : $model->module_code;

            $model->save();
        });
    }

    protected function copyRecordsFromExtensionsToThemes()
    {
        if (Themes_model::count())
            return;

        Extensions_model::getQuery()->where('type', 'theme')->get()->each(function ($model) {

            Themes_model::insert([
                'name'       => $model->title,
                'code'       => $model->name,
                'version'    => $model->version,
                'data'       => $model->data,
                'status'     => $model->status,
                'is_default' => FALSE,
            ]);
        });
    }

    protected function copyRecordsFromExtensionsToPayments()
    {
        if (Payments_model::count() OR !Extensions_model::getQuery()->where('type', 'payment')->count())
            return;

        Extensions_model::getQuery()->where('type', 'payment')->get()->each(function ($model) {

            Payments_model::insert([
                'name'         => $model->title,
                'code'         => $model->name,
                'class_name'   => 'SamPoyigi\\PayRegister\\Payments\\'.ucwords($model->name),
                'data'         => $model->data,
                'status'       => $model->status,
                'is_default'   => FALSE,
                'date_added'   => Carbon::now(),
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
                    'name'        => $option['name'],
                    'type'        => $option['type'] == 'shape' ? 'polygon' : $option['type'],
                    'boundaries'  => serialize($boundaries),
                    'conditions'  => serialize(isset($option['conditions']) ? $option['conditions'] : $option['charge']),
                ]);
            }
        });
    }

    protected function fillLabelColumnOnMailTemplatesData()
    {
        $labels = [
            'registration'                 => 'lang:system::mail_templates.text_registration',
            'registration_alert'           => 'lang:system::mail_templates.text_registration_alert',
            'password_reset_request'       => 'lang:system::mail_templates.text_password_reset_request',
            'password_reset_request_alert' => 'lang:system::mail_templates.text_password_reset_request_alert',
            'password_reset'               => 'lang:system::mail_templates.text_password_reset',
            'password_reset_alert'         => 'lang:system::mail_templates.text_password_reset_alert',
            'order'                        => 'lang:system::mail_templates.text_order',
            'order_alert'                  => 'lang:system::mail_templates.text_order_alert',
            'order_update'                 => 'lang:system::mail_templates.text_order_update',
            'reservation'                  => 'lang:system::mail_templates.text_reservation',
            'reservation_alert'            => 'lang:system::mail_templates.text_reservation_alert',
            'reservation_update'           => 'lang:system::mail_templates.text_reservation_update',
            'internal'                     => 'lang:system::mail_templates.text_internal',
            'contact'                      => 'lang:system::mail_templates.text_contact',
        ];

        Mail_templates_data_model::all()->each(function ($model) use ($labels) {
            if (!isset($labels[$model->code]))
                return TRUE;

            $model->label = $labels[$model->code];
            $model->save();
        });
    }
}