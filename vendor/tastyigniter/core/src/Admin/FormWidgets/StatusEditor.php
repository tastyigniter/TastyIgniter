<?php

declare(strict_types=1);

namespace Igniter\Admin\FormWidgets;

use Igniter\Admin\Classes\BaseFormWidget;
use Igniter\Admin\Classes\FormField;
use Igniter\Admin\Models\Status;
use Igniter\Admin\Models\StatusHistory;
use Igniter\Admin\Traits\FormModelWidget;
use Igniter\Admin\Traits\ValidatesForm;
use Igniter\Admin\Widgets\Form;
use Igniter\Cart\Models\Order;
use Igniter\Flame\Database\Model;
use Igniter\Flame\Exception\FlashException;
use Igniter\Local\Facades\Location as LocationFacade;
use Igniter\Reservation\Models\Reservation;
use Igniter\User\Facades\AdminAuth;
use Igniter\User\Models\AssignableLog;
use Igniter\User\Models\User;
use Igniter\User\Models\UserGroup;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Override;

/**
 * Status Editor
 * @property-read Order|Reservation $model
 */
class StatusEditor extends BaseFormWidget
{
    use FormModelWidget;
    use ValidatesForm;

    public ?Model $model = null;

    public null|string|array $form = null;

    public string $formTitle = 'igniter::admin.statuses.text_editor_title';

    /** Text to display for the title of the popup list form */
    public string $statusFormName = 'Status';

    public string $statusArrayName = 'statusData';

    /** Relation column to display for the name */
    public string $statusKeyFrom = 'status_id';

    /** Relation column to display for the name */
    public string $statusNameFrom = 'status_name';

    /** Relation column to display for the color */
    public string $statusColorFrom = 'status_color';

    public string $statusRelationFrom = 'status';

    public string $statusModelClass = StatusHistory::class;

    /** Text to display for the title of the popup list form */
    public string $assigneeFormName = 'Assignee';

    public string $assigneeArrayName = 'assigneeData';

    public string $assigneeKeyFrom = 'assignee_id';

    public string $assigneeGroupKeyFrom = 'assignee_group_id';

    /** Relation column to display for the name */
    public string $assigneeNameFrom = 'name';

    public string $assigneeGroupNameFrom = 'user_group_name';

    public string $assigneeRelationFrom = 'assignee';

    public string $assigneeModelClass = AssignableLog::class;

    public string $assigneeOrderPermission = 'Admin.AssignOrders';

    public string $assigneeReservationPermission = 'Admin.AssignReservations';

    //
    // Object properties
    //

    protected string $defaultAlias = 'statuseditor';

    protected ?string $modelClass = null;

    protected bool $isStatusMode = true;

    #[Override]
    public function initialize(): void
    {
        $this->fillFromConfig([
            'form',
            'statusArrayName',
            'statusKeyFrom',
            'statusFormName',
            'statusRelationFrom',
            'statusNameFrom',
            'statusColorFrom',
            'assigneeKeyFrom',
            'assigneeFormName',
            'assigneeArrayName',
            'assigneeRelationFrom',
            'assigneeNameFrom',
            'assigneeOrderPermission',
            'assigneeReservationPermission',
        ]);
    }

    #[Override]
    public function render(): string
    {
        $this->setMode('status');
        $this->prepareVars();

        return $this->makePartial('statuseditor/statuseditor');
    }

    public function onLoadRecord(): mixed
    {
        $context = post('recordId');
        throw_unless(in_array($context, ['load-status', 'load-assignee']),
            new FlashException(lang('igniter::admin.statuses.alert_invalid_action')),
        );

        $this->setMode(str_after($context, 'load-'));

        $formTitle = sprintf(lang($this->formTitle), lang($this->getModeConfig('formName')));
        $model = $this->createFormModel();

        return $this->makePartial('statuseditor/form', [
            'formTitle' => $formTitle,
            'formWidget' => $this->makeEditorFormWidget($model),
        ]);
    }

    public function onSaveRecord(): array
    {
        $this->setMode($context = post('context'));

        $keyFrom = $this->getModeConfig('keyFrom');
        $arrayName = $this->getModeConfig('arrayName');
        $recordId = post($arrayName.'.'.$keyFrom);

        if (!$this->isStatusMode) {
            $this->checkAssigneePermission();
        }

        $model = $this->createFormModel();
        $form = $this->makeEditorFormWidget($model);

        throw_if(
            $this->isStatusMode && $recordId == $this->model->{$keyFrom},
            new FlashException(sprintf(lang('igniter::admin.statuses.alert_already_added'), $context, $context)),
        );

        $saveData = $this->validateFormWidget($form, $form->getSaveData());

        $saveData['user_id'] = $this->getController()->getUser()->getKey();

        DB::transaction(function() use ($saveData, $keyFrom) {
            if ($this->saveRecord($saveData, $keyFrom)) {
                flash()->success(sprintf(lang('igniter::admin.alert_success'), lang($this->getModeConfig('formName')).' '.'updated'))->now();
            } else {
                flash()->error(lang('igniter::admin.alert_error_try_again'))->now();
            }
        });

        $this->prepareVars();

        return [
            '#notification' => $this->makePartial('flash'),
            '#'.$this->getId() => $this->makePartial('statuseditor/info'),
        ];
    }

    public function onLoadStatus(): array
    {
        throw_unless(!empty($statusId = post('statusId', '')),
            new FlashException(lang('igniter::admin.form.missing_id')),
        );

        throw_unless($status = Status::find($statusId),
            new FlashException(sprintf(lang('igniter::admin.statuses.alert_status_not_found'), $statusId)),
        );

        return $status->toArray();
    }

    public function onLoadAssigneeList(): array
    {
        throw_unless(!empty(post('groupId', '')),
            new FlashException(lang('igniter::admin.form.missing_id')),
        );

        $this->setMode('assignee');

        $model = $this->createFormModel();

        $form = $this->makeEditorFormWidget($model);

        $formField = $form->getField($this->assigneeKeyFrom);

        return [
            '#'.$formField->getId('group') => $form->renderField($formField, [
                'useContainer' => false,
            ]),
        ];
    }

    #[Override]
    public function loadAssets(): void
    {
        $this->addJs('formwidgets/recordeditor.modal.js', 'recordeditor-modal-js');
        $this->addJs('statuseditor.js', 'statuseditor-js');
    }

    public function prepareVars(): void
    {
        $this->vars['field'] = $this->formField;
        $this->vars['status'] = $this->model->{$this->statusRelationFrom};
        $this->vars['assignee'] = $this->model->{$this->assigneeRelationFrom};
    }

    #[Override]
    public function getSaveValue(mixed $value): int
    {
        return FormField::NO_SAVE_DATA;
    }

    public static function getAssigneeOptions(Form $form, $field): array|Collection
    {
        if (empty($groupId = post('groupId', $form->getField('assignee_group_id')->value ?? ''))) {
            return [];
        }

        $query = User::whereHas('groups', function($query) use ($groupId) {
            $query->where('admin_user_groups.user_group_id', $groupId);
        })->whereIsEnabled();

        if ($ids = LocationFacade::currentOrAssigned()) {
            $query->whereHasLocation($ids);
        }

        return $query->dropdown('name');
    }

    public static function getAssigneeGroupOptions()
    {
        if (AdminAuth::isSuperUser()) {
            return UserGroup::getDropdownOptions();
        }

        return AdminAuth::user()->groups->pluck('user_group_name', 'user_group_id');
    }

    protected function makeEditorFormWidget($model)
    {
        $widgetConfig = is_string($this->form)
            ? $this->loadConfig($this->form, ['form'], 'form') : $this->form;

        $widgetConfig['model'] = $model;
        $widgetConfig['alias'] = $this->alias.'StatusEditor';
        $widgetConfig['context'] = $this->isStatusMode ? 'status' : 'assignee';
        $widgetConfig['arrayName'] = $this->getModeConfig('arrayName');
        $widget = $this->makeWidget(Form::class, $widgetConfig);

        $widget->bindEvent('form.extendFieldsBefore', function() use ($widget) {
            $this->formExtendFieldsBefore($widget);
        });

        $widget->bindEvent('form.extendFields', function($fields) use ($widget) {
            $this->formExtendFields($widget, $fields);
        });

        $widget->bindToController();

        return $widget;
    }

    protected function setMode($context)
    {
        $this->isStatusMode = $context !== 'assignee';
        $this->modelClass = $this->isStatusMode
            ? $this->statusModelClass : $this->assigneeModelClass;
    }

    protected function getModeConfig($key)
    {
        $key = ucfirst((string)$key);

        return $this->isStatusMode ? $this->{'status'.$key} : $this->{'assignee'.$key};
    }

    protected function formExtendFieldsBefore($form)
    {
        if ($this->isStatusMode) {
            if ($status = $this->model->{$this->statusRelationFrom}) {
                $form->fields['status_id']['default'] = $status->getKey();
                $form->fields['comment']['default'] = $status->status_comment;
                $form->fields['notify']['default'] = $status->notify_customer;
            }

            return;
        }

        $form->fields['assignee_group_id']['default'] = $this->model->assignee_group_id;
        $form->fields['assignee_id']['default'] = $this->model->assignee_id;
        $form->fields['assignee_group_id']['options'] = $this->getAssigneeGroupOptions(...);
        $form->fields['assignee_id']['options'] = $this->getAssigneeOptions(...);
    }

    protected function formExtendFields($form, $fields) {}

    protected function checkAssigneePermission()
    {
        $saleType = $this->model instanceof Order
            ? 'orderPermission' : 'reservationPermission';

        $permission = $this->getModeConfig($saleType);

        if (!$this->controller->getUser()->hasPermission($permission)) {
            throw new FlashException(lang('igniter::admin.alert_user_restricted'));
        }
    }

    protected function saveRecord(array $saveData, string $keyFrom)
    {
        if (!$this->isStatusMode) {
            /** @var UserGroup $group */
            $group = UserGroup::find(array_get($saveData, $this->assigneeGroupKeyFrom));
            /** @var User $user */
            $user = User::find(array_get($saveData, $keyFrom));
            $record = $this->model->updateAssignTo($group, $user, $this->controller->getUser());
        } else {
            /** @var Status $status */
            $status = Status::find(array_get($saveData, $keyFrom));
            $record = $this->model->addStatusHistory($status, $saveData);
        }

        return $record;
    }
}
