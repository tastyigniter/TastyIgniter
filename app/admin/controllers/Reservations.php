<?php namespace Admin\Controllers;

use Admin\Models\Reservations_model;
use AdminMenu;
use Exception;

class Reservations extends \Admin\Classes\AdminController
{
    public $implement = [
        'Admin\Actions\ListController',
        'Admin\Actions\CalendarController',
        'Admin\Actions\FormController',
    ];

    public $listConfig = [
        'list' => [
            'model'        => 'Admin\Models\Reservations_model',
            'title'        => 'lang:admin::lang.reservations.text_title',
            'emptyMessage' => 'lang:admin::lang.reservations.text_empty',
            'defaultSort'  => ['reserve_date', 'DESC'],
            'configFile'   => 'reservations_model',
        ],
    ];

    public $calendarConfig = [
        'calender' => [
            'title'          => 'lang:admin::lang.reservations.text_title',
            'emptyMessage'   => 'lang:admin::lang.reservations.text_no_booking',
            'popoverPartial' => 'reservations/calendar_popover',
            'configFile'     => 'reservations_model',
        ],
    ];

    public $formConfig = [
        'name'       => 'lang:admin::lang.reservations.text_form_name',
        'model'      => 'Admin\Models\Reservations_model',
        'create'     => [
            'title'         => 'lang:admin::lang.form.create_title',
            'redirect'      => 'reservations/edit/{reservation_id}',
            'redirectClose' => 'reservations',
        ],
        'edit'       => [
            'title'         => 'lang:admin::lang.form.edit_title',
            'redirect'      => 'reservations/edit/{reservation_id}',
            'redirectClose' => 'reservations',
        ],
        'preview'    => [
            'title'    => 'lang:admin::lang.form.preview_title',
            'redirect' => 'reservations',
        ],
        'delete'     => [
            'redirect' => 'reservations',
        ],
        'configFile' => 'reservations_model',
    ];

    protected $requiredPermissions = 'Admin.Reservations';

    public function __construct()
    {
        parent::__construct();

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

    public function formValidate($model, $form)
    {
        $namedRules = [
            ['status_id', 'lang:admin::lang.label_status', 'required|integer|exists:statuses,status_id'],
            ['location_id', 'lang:admin::lang.reservations.text_restaurant', 'required|integer'],
            ['statusData.status_id', 'lang:admin::lang.reservations.label_status', 'required|same:status_id'],
            ['statusData.comment', 'lang:admin::lang.reservations.label_comment', 'max:1500'],
            ['statusData.notify', 'lang:admin::lang.reservations.label_notify', 'required|integer'],
            ['assignee_id', 'lang:admin::lang.reservations.label_assign_staff', 'required|integer'],
            ['first_name', 'lang:admin::lang.reservations.label_first_name', 'required|min:2|max:32'],
            ['last_name', 'lang:admin::lang.reservations.label_last_name', 'required|min:2|max:32'],
            ['email', 'lang:admin::lang.reservations.label_customer_email', 'required|email|max:96'],
            ['telephone', 'lang:admin::lang.reservations.label_customer_telephone', 'sometimes'],
            ['reserve_date', 'lang:admin::lang.reservations.label_reservation_date', 'required|valid_date'],
            ['reserve_time', 'lang:admin::lang.reservations.label_reservation_time', 'required|valid_time'],
            ['guest_num', 'lang:admin::lang.reservations.label_guest', 'required|integer'],
        ];

        return $this->validatePasses(post($form->arrayName), $namedRules);
    }
}