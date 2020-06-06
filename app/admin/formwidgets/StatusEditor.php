<?php namespace Admin\FormWidgets;

use Admin\ActivityTypes\AssigneeUpdated;
use Admin\ActivityTypes\StatusUpdated;
use Admin\Classes\BaseFormWidget;
use Admin\Classes\FormField;
use Admin\Facades\AdminAuth;
use Admin\Models\Orders_model;
use Admin\Models\Reservations_model;
use Admin\Models\Staff_groups_model;
use Admin\Models\Staffs_model;
use Admin\Models\Statuses_model;
use Admin\Traits\FormModelWidget;
use Admin\Traits\ValidatesForm;
use Admin\Widgets\Form;
use Exception;
use Igniter\Flame\Exception\ApplicationException;
use Igniter\Flame\Exception\ValidationException;

/**
 * Status Editor
 *
 * @package Admin
 */
class StatusEditor extends BaseFormWidget
{
    use FormModelWidget;
    use ValidatesForm;

    /**
     * @var Orders_model|\Admin\Models\Reservations_model Form model object.
     */
    public $model;

    public $form;

    public $formTitle = 'admin::lang.statuses.text_editor_title';

    /**
     * @var string Text to display for the title of the popup list form
     */
    public $statusFormName = 'Status';

    public $statusArrayName = 'statusData';

    /**
     * @var string Relation column to display for the name
     */
    public $statusKeyFrom = 'status_id';

    /**
     * @var string Relation column to display for the name
     */
    public $statusNameFrom = 'status_name';

    /**
     * @var string Relation column to display for the color
     */
    public $statusColorFrom = 'status_color';

    public $statusRelationFrom = 'status';

    public $statusModelClass = 'Admin\Models\Status_history_model';

    /**
     * @var string Text to display for the title of the popup list form
     */
    public $assigneeFormName = 'Assignee';

    public $assigneeArrayName = 'assigneeData';

    public $assigneeKeyFrom = 'assignee_id';

    public $assigneeGroupKeyFrom = 'assignee_group_id';

    /**
     * @var string Relation column to display for the name
     */
    public $assigneeNameFrom = 'staff_name';

    public $assigneeGroupNameFrom = 'staff_group_name';

    public $assigneeRelationFrom = 'assignee';

    public $assigneeModelClass = 'Admin\Models\Assignable_logs_model';

    public $assigneeOrderPermission = 'Admin.AssignOrders';

    public $assigneeReservationPermission = 'Admin.AssignReservation';

    //
    // Object properties
    //

    protected $defaultAlias = 'statuseditor';

    protected $modelClass;

    protected $isStatusMode;

    public function initialize()
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

    public function render()
    {
        $this->setMode('status');
        $this->prepareVars();

        return $this->makePartial('statuseditor/statuseditor');
    }

    public function onLoadRecord()
    {
        $context = post('recordId');
        if (!in_array($context, ['load-status', 'load-assignee']))
            throw new ApplicationException('Invalid action');

        $this->setMode(str_after($context, 'load-'));

        $formTitle = sprintf(lang($this->formTitle), lang($this->getModeConfig('formName')));
        $model = $this->createFormModel();

        return $this->makePartial('statuseditor/form', [
            'formTitle' => $formTitle,
            'formWidget' => $this->makeEditorFormWidget($model),
        ]);
    }

    public function onSaveRecord()
    {
        $this->setMode($context = post('context'));

        $keyFrom = $this->getModeConfig('keyFrom');
        $arrayName = $this->getModeConfig('arrayName');
        $recordId = post($arrayName.'.'.$keyFrom);

        if (!$this->isStatusMode)
            $this->checkAssigneePermission();

        $model = $this->createFormModel();
        $form = $this->makeEditorFormWidget($model);
        $saveData = $this->mergeSaveData($form->getSaveData());

        try {
            $this->validateAfter(function ($validator) use ($context, $recordId, $keyFrom) {
                if ($this->isStatusMode AND $recordId == $this->model->{$keyFrom}) {
                    $validator->errors()->add($keyFrom, sprintf(
                        lang('admin::lang.statuses.alert_already_added'),
                        $context, $context
                    ));
                }
            });
            $this->validate($saveData, $this->getFormRules());
        }
        catch (ValidationException $ex) {
            throw new ApplicationException($ex->getMessage());
        }

        if ($this->saveRecord($saveData, $keyFrom)) {
            flash()->success(sprintf(lang('admin::lang.alert_success'), lang($this->getModeConfig('formName')).' '.'updated'))->now();
        }
        else {
            flash()->error(lang('admin::lang.alert_error_try_again'))->now();
        }

        $this->prepareVars();

        return [
            '#notification' => $this->makePartial('flash'),
            '#'.$this->getId() => $this->makePartial('statuseditor/info'),
        ];
    }

    public function onLoadStatus()
    {
        if (!strlen($statusId = post('statusId')))
            throw new ApplicationException(lang('admin::lang.form.missing_id'));

        if (!$status = Statuses_model::find($statusId))
            throw new Exception('Status ID ['.$statusId.'] not found.');

        return $status->toArray();
    }

    public function onLoadAssigneeList()
    {
        if (!strlen($groupId = post('groupId')))
            throw new ApplicationException(lang('admin::lang.form.missing_id'));

        $this->setMode('assignee');

        $model = $this->createFormModel();

        $form = $this->makeEditorFormWidget($model);

        $formField = $form->getField($this->assigneeKeyFrom);

        return [
            '#'.$formField->getId() => $form->renderField($formField, [
                'useContainer' => FALSE,
            ]),
        ];
    }

    public function loadAssets()
    {
        $this->addJs('../../recordeditor/assets/js/recordeditor.modal.js', 'recordeditor-modal-js');
        $this->addJs('js/statuseditor.js', 'statuseditor-js');
    }

    public function prepareVars()
    {
        $this->vars['field'] = $this->formField;
        $this->vars['status'] = $this->model->{$this->statusRelationFrom};
        $this->vars['assignee'] = $this->model->{$this->assigneeRelationFrom};
    }

    public function getSaveValue($value)
    {
        return FormField::NO_SAVE_DATA;
    }

    public static function getAssigneeOptions($form, $field)
    {
        if (!strlen($groupId = post('groupId', $form->getField('assignee_group_id')->value)))
            return [];

        return Staffs_model::whereHas('groups', function ($query) use ($groupId) {
            $query->where('staff_groups.staff_group_id', $groupId);
        })->isEnabled()->dropdown('staff_name');
    }

    public static function getAssigneeGroupOptions()
    {
        if (AdminAuth::isSuperUser()) {
            return Staff_groups_model::getDropdownOptions();
        }

        return AdminAuth::staff()->groups->pluck('staff_group_name', 'staff_group_id');
    }

    protected function makeEditorFormWidget($model)
    {
        $widgetConfig = is_string($this->form)
            ? $this->loadConfig($this->form, ['form'], 'form') : $this->form;

        $widgetConfig['model'] = $model;
        $widgetConfig['alias'] = $this->alias.'status-editor';
        $widgetConfig['context'] = $this->isStatusMode ? 'status' : 'assignee';
        $widgetConfig['arrayName'] = $this->getModeConfig('arrayName');
        $widget = $this->makeWidget(Form::class, $widgetConfig);

        $widget->bindEvent('form.extendFieldsBefore', function () use ($widget) {
            $this->formExtendFieldsBefore($widget);
        });

        $widget->bindEvent('form.extendFields', function ($fields) use ($widget) {
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
        $key = ucfirst($key);

        return $this->isStatusMode ? $this->{'status'.$key} : $this->{'assignee'.$key};
    }

    protected function mergeSaveData()
    {
        return array_merge(post($this->getModeConfig('arrayName'), []), [
            'staff_id' => $this->getController()->getUser()->staff->getKey(),
        ]);
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
        $form->fields['assignee_group_id']['options'] = [$this, 'getAssigneeGroupOptions'];
        $form->fields['assignee_id']['options'] = [$this, 'getAssigneeOptions'];
    }

    protected function formExtendFields($form, $fields)
    {
    }

    protected function getFormRules()
    {
        $widgetConfig = is_string($this->form)
            ? $this->loadConfig($this->form, ['form'], 'form') : $this->form;

        return array_get($widgetConfig, 'rules', []);
    }

    protected function checkAssigneePermission()
    {
        $saleType = $this->model instanceof Orders_model
            ? 'orderPermission' : 'reservationPermission';

        $permission = $this->getModeConfig($saleType);

        if (!$this->controller->getUser()->hasPermission($permission))
            throw new ApplicationException(lang('admin::lang.alert_user_restricted'));
    }

    protected function saveRecord(array $saveData, string $keyFrom)
    {
        if (!$this->isStatusMode) {
            $group = Staff_groups_model::find(array_get($saveData, $this->assigneeGroupKeyFrom));
            $staff = Staffs_model::find(array_get($saveData, $keyFrom));
            if ($record = $this->model->updateAssignTo($group, $staff))
                AssigneeUpdated::log($record, $this->getController()->getUser());
        }
        else {
            $status = Statuses_model::find(array_get($saveData, $keyFrom));
            if ($record = $this->model->addStatusHistory($status, $saveData)) {
                $this->model->reloadRelations();

                StatusUpdated::log($record, $this->getController()->getUser());

                $this->mailStatusUpdated($record);
            }
        }

        return $record;
    }

    protected function mailStatusUpdated($recordLog)
    {
        if ($recordLog->notify) {
            $mailView = ($recordLog->object instanceof Reservations_model)
                ? 'admin::_mail.reservation_update' : 'admin::_mail.order_update';

            $recordLog->object->mailSend($mailView, 'customer');
        }
    }
}
