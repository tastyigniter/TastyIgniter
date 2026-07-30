<?php

declare(strict_types=1);

namespace Igniter\Reservation\Http\Controllers;

use Igniter\Admin\Classes\AdminController;
use Igniter\Admin\Facades\AdminMenu;
use Igniter\Admin\Http\Actions\FormController;
use Igniter\Admin\Http\Actions\ListController;
use Igniter\Flame\Exception\FlashException;
use Igniter\Local\Http\Actions\LocationAwareController;
use Igniter\Reservation\Http\Requests\DiningAreaRequest;
use Igniter\Reservation\Models\DiningArea;
use Igniter\Reservation\Models\DiningSection;
use Igniter\Reservation\Models\DiningTable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Event;

/**
 * Admin Controller Class Dining Areas
 */
class DiningAreas extends AdminController
{
    public array $implement = [
        ListController::class,
        FormController::class,
        LocationAwareController::class,
    ];

    public array $listConfig = [
        'list' => [
            'model' => DiningArea::class,
            'title' => 'lang:igniter.reservation::default.dining_areas.text_title',
            'emptyMessage' => 'lang:igniter.reservation::default.dining_areas.text_empty',
            'defaultSort' => ['created_at', 'DESC'],
            'configFile' => 'dining_area',
        ],
    ];

    public array $formConfig = [
        'name' => 'lang:igniter.reservation::default.dining_areas.text_form_name',
        'model' => DiningArea::class,
        'request' => DiningAreaRequest::class,
        'create' => [
            'title' => 'lang:admin::lang.form.create_title',
            'redirect' => 'dining_areas/edit/{id}',
            'redirectClose' => 'dining_areas',
            'redirectNew' => 'dining_areas/create',
        ],
        'edit' => [
            'title' => 'lang:admin::lang.form.edit_title',
            'redirect' => 'dining_areas/edit/{id}',
            'redirectClose' => 'dining_areas',
            'redirectNew' => 'dining_areas/create',
        ],
        'preview' => [
            'title' => 'lang:admin::lang.form.preview_title',
            'back' => 'dining_areas',
        ],
        'delete' => [
            'redirect' => 'dining_areas',
        ],
        'configFile' => 'dining_area',
    ];

    protected null|string|array $requiredPermissions = 'Admin.Tables';

    public static function getSlug(): string
    {
        return 'dining_areas';
    }

    public function __construct()
    {
        parent::__construct();

        AdminMenu::setContext('dining_areas', 'restaurant');
    }

    public function edit(string $context, ?string $recordId): void
    {
        Event::listen('admin.form.extendFields', function($form, array $fields) use ($recordId): void {
            if (isset($fields['dining_area_id']) && !$fields['dining_area_id']->value) {
                $fields['dining_area_id']->value = $recordId;
            }

            $formModel = $this->asExtension('FormController')->getFormModel();
            if ($form->model instanceof DiningSection && isset($fields['location_id']) && !$fields['location_id']->value) {
                $fields['location_id']->value = $formModel->location_id;
            }
        });

        $this->asExtension('FormController')->edit($context, $recordId);
    }

    public function index_onDuplicate($context): RedirectResponse
    {
        $model = $this->asExtension('FormController')->formFindModelObject(post('id'));

        $duplicate = $model->duplicate();

        flash()->success(sprintf(lang('admin::lang.alert_success'), 'Dining area duplicated'));

        return $this->redirect('dining_areas/edit/'.$duplicate->getKey());
    }

    public function edit_onCreateCombo($context, $recordId): RedirectResponse
    {
        $checked = (array)post('DiningArea._select_dining_tables', []);
        throw_if(!$checked || count($checked) < 2,
            new FlashException(lang('igniter.reservation::default.dining_areas.alert_tables_not_checked')),
        );

        $model = $this->asExtension('FormController')->formFindModelObject($recordId);

        $checkedTables = $model->dining_tables()->whereIn('id', $checked)->get();

        $model->createCombo($checkedTables);

        flash()->success(sprintf(lang('admin::lang.alert_success'), 'Table combo created'));

        return $this->redirectBack();
    }

    public function listExtendQuery($query): void
    {
        $query->with(['available_tables', 'dining_sections']);
    }

    public function formExtendFields($form): void
    {
        if ($form->context != 'create') {
            $form->getField('location_id')->disabled = true;
        }
    }

    public function formBeforeSave($model): void
    {
        $diningTable = resolve(DiningTable::class);
        if ($diningTable->isBroken()) {
            $diningTable->fixBrokenTreeQuietly();
        }
    }
}
