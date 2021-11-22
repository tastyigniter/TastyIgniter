<?php

namespace Admin\Controllers;

use Admin\ActivityTypes\StatusUpdated;
use Admin\Facades\AdminMenu;
use Admin\Models\Reservations_model;
use Admin\Models\Statuses_model;
use Exception;
use Igniter\Flame\Exception\ApplicationException;

class Reservations extends \Admin\Classes\AdminController
{
    public $implement = [
        'Admin\Actions\ListController',
        'Admin\Actions\CalendarController',
        'Admin\Actions\FormController',
        'Admin\Actions\AssigneeController',
        'Admin\Actions\LocationAwareController',
    ];

    public $listConfig = [
        'list' => [
            'model' => 'Admin\Models\Reservations_model',
            'title' => 'lang:admin::lang.reservations.text_title',
            'emptyMessage' => 'lang:admin::lang.reservations.text_empty',
            'defaultSort' => ['reservation_id', 'DESC'],
            'configFile' => 'reservations_model',
        ],
    ];

    public $calendarConfig = [
        'calender' => [
            'title' => 'lang:admin::lang.reservations.text_title',
            'emptyMessage' => 'lang:admin::lang.reservations.text_no_booking',
            'popoverPartial' => 'reservations/calendar_popover',
            'configFile' => 'reservations_model',
        ],
    ];

    public $formConfig = [
        'name' => 'lang:admin::lang.reservations.text_form_name',
        'model' => 'Admin\Models\Reservations_model',
        'request' => 'Admin\Requests\Reservation',
        'create' => [
            'title' => 'lang:admin::lang.form.create_title',
            'redirect' => 'reservations/edit/{reservation_id}',
            'redirectClose' => 'reservations',
            'redirectNew' => 'reservations/create',
        ],
        'edit' => [
            'title' => 'lang:admin::lang.form.edit_title',
            'redirect' => 'reservations/edit/{reservation_id}',
            'redirectClose' => 'reservations',
            'redirectNew' => 'reservations/create',
        ],
        'preview' => [
            'title' => 'lang:admin::lang.form.preview_title',
            'redirect' => 'reservations',
        ],
        'delete' => [
            'redirect' => 'reservations',
        ],
        'configFile' => 'reservations_model',
    ];

    protected $requiredPermissions = [
        'Admin.Reservations',
        'Admin.AssignReservations',
        'Admin.DeleteReservations',
    ];

    public function __construct()
    {
        parent::__construct();

        AdminMenu::setContext('reservations', 'sales');
    }

    public function index()
    {
        $this->asExtension('ListController')->index();

        $this->vars['statusesOptions'] = \Admin\Models\Statuses_model::getDropdownOptionsForReservation();
    }

    public function index_onDelete()
    {
        if (!$this->getUser()->hasPermission('Admin.DeleteReservations'))
            throw new ApplicationException(lang('admin::lang.alert_user_restricted'));

        return $this->asExtension('Admin\Actions\ListController')->index_onDelete();
    }

    public function index_onUpdateStatus()
    {
        $model = Reservations_model::find((int)post('recordId'));
        $status = Statuses_model::find((int)post('statusId'));
        if (!$model || !$status)
            return;

        if ($record = $model->addStatusHistory($status))
            StatusUpdated::log($record, $this->getUser());

        flash()->success(sprintf(lang('admin::lang.alert_success'), lang('admin::lang.statuses.text_form_name').' updated'))->now();

        return $this->redirectBack();
    }

    public function edit_onDelete()
    {
        if (!$this->getUser()->hasPermission('Admin.DeleteReservations'))
            throw new ApplicationException(lang('admin::lang.alert_user_restricted'));

        return $this->asExtension('Admin\Actions\FormController')->edit_onDelete();
    }

    public function calendarGenerateEvents($startAt, $endAt)
    {
        return Reservations_model::listCalendarEvents(
            $startAt, $endAt, $this->getLocationId()
        );
    }

    public function calendarUpdateEvent($eventId, $startAt, $endAt)
    {
        if (!$reservation = Reservations_model::find($eventId))
            throw new Exception(lang('admin::lang.reservations.alert_no_reservation_found'));

        $startAt = make_carbon($startAt);
        $endAt = make_carbon($endAt);

        $reservation->duration = $startAt->diffInMinutes($endAt);
        $reservation->reserve_date = $startAt->toDateString();
        $reservation->reserve_time = $startAt->toTimeString();

        $reservation->save();
    }

    public function formExtendQuery($query)
    {
        $query->with([
            'status_history' => function ($q) {
                $q->orderBy('created_at', 'desc');
            },
            'status_history.staff',
            'status_history.status',
        ]);
    }
}
