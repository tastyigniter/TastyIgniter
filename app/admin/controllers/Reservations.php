<?php

namespace Admin\Controllers;

use Admin\Models\Reservations_model;
use AdminMenu;
use Exception;

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
        ],
        'edit' => [
            'title' => 'lang:admin::lang.form.edit_title',
            'redirect' => 'reservations/edit/{reservation_id}',
            'redirectClose' => 'reservations',
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

    protected $requiredPermissions = ['Admin.Reservations', 'Admin.AssignReservations'];

    public function __construct()
    {
        parent::__construct();

        if ($this->action === 'assigned')
            $this->requiredPermissions = null;

        AdminMenu::setContext('reservations', 'sales');
    }

    public function calendarGenerateEvents($startAt, $endAt)
    {
        return Reservations_model::listCalendarEvents($startAt, $endAt);
    }

    public function calendarUpdateEvent($eventId, $startAt, $endAt)
    {
        if (!$reservation = Reservations_model::find($eventId))
            throw new Exception('No matching reservation found');

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
                $q->orderBy('date_added', 'desc');
            },
            'status_history.staff',
            'status_history.status',
        ]);
    }
}
