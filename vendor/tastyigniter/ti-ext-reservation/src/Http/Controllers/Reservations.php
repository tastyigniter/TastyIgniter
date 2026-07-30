<?php

declare(strict_types=1);

namespace Igniter\Reservation\Http\Controllers;

use Carbon\Carbon;
use DateInterval;
use DatePeriod;
use Igniter\Admin\Classes\AdminController;
use Igniter\Admin\Facades\AdminMenu;
use Igniter\Admin\Http\Actions\CalendarController;
use Igniter\Admin\Http\Actions\FormController;
use Igniter\Admin\Http\Actions\ListController;
use Igniter\Admin\Models\Status;
use Igniter\Admin\Widgets\Filter;
use Igniter\Flame\Exception\FlashException;
use Igniter\Local\Facades\Location as LocationFacade;
use Igniter\Local\Http\Actions\LocationAwareController;
use Igniter\Reservation\Http\Requests\ReservationRequest;
use Igniter\Reservation\Models\DiningArea;
use Igniter\Reservation\Models\Reservation;
use Igniter\User\Http\Actions\AssigneeController;
use Illuminate\Http\RedirectResponse;

class Reservations extends AdminController
{
    public array $implement = [
        ListController::class,
        CalendarController::class,
        FormController::class,
        AssigneeController::class,
        LocationAwareController::class,
    ];

    public array $listConfig = [
        'list' => [
            'model' => Reservation::class,
            'title' => 'lang:igniter.reservation::default.text_title',
            'emptyMessage' => 'lang:igniter.reservation::default.text_empty',
            'defaultSort' => ['reservation_id', 'DESC'],
            'configFile' => 'reservation',
        ],
        'floor_plan' => [
            'model' => Reservation::class,
            'title' => 'lang:igniter.reservation::default.text_title',
            'emptyMessage' => 'lang:igniter.reservation::default.text_empty',
            'defaultSort' => ['reservation_id', 'DESC'],
            'showCheckboxes' => false,
            'showSetup' => false,
            'configFile' => 'floor_plan',
        ],
    ];

    public $calendarConfig = [
        'calender' => [
            'title' => 'lang:igniter.reservation::default.text_title',
            'emptyMessage' => 'lang:igniter.reservation::default.text_no_booking',
            'popoverPartial' => 'reservations/form/calendar_popover',
            'configFile' => 'reservation',
        ],
    ];

    public array $formConfig = [
        'name' => 'lang:igniter.reservation::default.text_form_name',
        'model' => Reservation::class,
        'request' => ReservationRequest::class,
        'create' => [
            'title' => 'lang:igniter::admin.form.create_title',
            'redirect' => 'reservations/edit/{reservation_id}',
            'redirectClose' => 'reservations',
            'redirectNew' => 'reservations/create',
        ],
        'edit' => [
            'title' => 'lang:igniter::admin.form.edit_title',
            'redirect' => 'reservations/edit/{reservation_id}',
            'redirectClose' => 'reservations',
            'redirectNew' => 'reservations/create',
        ],
        'preview' => [
            'title' => 'lang:igniter::admin.form.preview_title',
            'back' => 'reservations',
        ],
        'delete' => [
            'redirect' => 'reservations',
        ],
        'configFile' => 'reservation',
    ];

    protected null|string|array $requiredPermissions = [
        'Admin.Reservations',
        'Admin.AssignReservations',
        'Admin.DeleteReservations',
    ];

    public static function getSlug(): string
    {
        return 'reservations';
    }

    public function __construct()
    {
        parent::__construct();

        AdminMenu::setContext('reservations', 'sales');
    }

    public function index(): void
    {
        $this->asExtension('ListController')->index();

        $this->vars['statusesOptions'] = Status::getDropdownOptionsForReservation();
    }

    public function floor_plan(): void
    {
        $this->defaultView = 'floor_plan';

        $this->addJs('https://unpkg.com/konva@8.3.12/konva.min.js', 'konva-js');
        $this->addCss('igniter.reservation::/css/floorplanner.css', 'floorplanner-css');
        $this->addJs('igniter.reservation::/js/floorplanner.js', 'floorplanner-js');

        $this->asExtension('ListController')->index();

        $this->vars['statusesOptions'] = Status::getDropdownOptionsForReservation();
    }

    public function index_onDelete()
    {
        throw_unless($this->authorize('Admin.DeleteReservations'),
            new FlashException(lang('igniter::admin.alert_user_restricted')),
        );

        return $this->asExtension(ListController::class)->index_onDelete();
    }

    public function onUpdateStatus(): ?RedirectResponse
    {
        $recordId = (string)post('recordId');
        $statusId = (int)post('statusId');
        if (!$recordId || !$statusId) {
            return null;
        }

        /** @var Reservation $model */
        $model = $this->asExtension(FormController::class)->formFindModelObject($recordId);

        /** @var Status $status */
        throw_unless($status = Status::query()->find($statusId),
            new FlashException(lang('igniter.reservation::default.alert_no_status_found')),
        );

        $model->addStatusHistory($status);

        flash()->success(sprintf(lang('igniter::admin.alert_success'), lang('igniter::admin.statuses.text_form_name').' updated'))->now();

        return $this->redirectBack();
    }

    public function edit_onDelete(?string $context = null, mixed $recordId = null)
    {
        throw_unless($this->authorize('Admin.DeleteReservations'),
            new FlashException(lang('igniter::admin.alert_user_restricted')),
        );

        return $this->asExtension(FormController::class)->edit_onDelete($context, $recordId);
    }

    public function calendarGenerateEvents($startAt, $endAt)
    {
        return Reservation::listCalendarEvents(
            $startAt, $endAt, LocationFacade::currentOrAssigned(),
        );
    }

    public function calendarUpdateEvent($eventId, $startAt, $endAt): void
    {
        /** @var Reservation $reservation */
        $reservation = $this->asExtension(FormController::class)->formFindModelObject((string)$eventId);

        $startAt = make_carbon($startAt);
        $endAt = make_carbon($endAt);

        $reservation->duration = (int)floor($startAt->diffInMinutes($endAt));
        $reservation->reserve_date = $startAt->toDateString();
        $reservation->reserve_time = $startAt->toTimeString();

        $reservation->save();
    }

    public function listExtendQuery($query, $alias): void
    {
        $query->with(['tables', 'status']);
    }

    public function formExtendQuery($query): void
    {
        $query->with([
            'status_history' => function($q): void {
                $q->orderBy('created_at', 'desc');
            },
            'status_history.user',
            'status_history.status',
        ]);
    }

    public function listFilterExtendScopesBefore(Filter $filter): void
    {
        if ($filter->alias === 'floor_plan_filter') {
            $filter->scopes['reserve_date']['default'] = now()->toDateString();
        }
    }

    public function listFilterExtendScopes(Filter $filter): void
    {
        if ($filter->alias !== 'floor_plan_filter') {
            return;
        }

        $diningAreaId = $filter->getScopeValue('dining_area');
        $this->vars['diningArea'] = $diningAreaId ? DiningArea::query()->find($diningAreaId) : null;

        $reserveDateScope = $filter->getScope('reserve_date');
        $reserveTimeScope = $filter->getScope('reserve_time');

        $selectedDate = $filter->getScopeValue('reserve_date', $reserveDateScope->config['default']);

        $reserveTimeScope->options = $this->getReserveTimeOptions($selectedDate) ?: ['No times available'];
    }

    protected function getReserveTimeOptions($date = null)
    {
        $items = [];

        $date = make_carbon($date ?? now());
        $start = $date->copy()->startOfDay();
        $end = $date->copy()->endOfDay();
        $interval = new DateInterval('PT15M');

        $datePeriod = new DatePeriod($start, $interval, $end);
        foreach ($datePeriod as $dateTime) {
            $dateTime = new Carbon($dateTime);
            $items[$dateTime->toDateTimeString()] = $dateTime->isoFormat(lang('system::lang.moment.time_format'));
        }

        return $items;
    }
}
